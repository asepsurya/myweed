<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Services\MayarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MayarController extends Controller
{
    public function __construct(protected MayarService $mayar) {}

    public function createPaymentLink(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'coupon' => 'nullable|string',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $couponCode = $request->coupon;
        $finalAmount = $plan->price;
        $coupon = null;

        if ($couponCode && ! $plan->is_free) {
            $coupon = Coupon::where('code', strtoupper($couponCode))
                ->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('max_uses')->orWhere('used_count', '<', 'max_uses');
                })
                ->first();

            if ($coupon) {
                if ($coupon->min_amount && $plan->price < $coupon->min_amount) {
                    $coupon = null;
                } else {
                    if ($coupon->type === 'percentage') {
                        $discount = (int) floor($plan->price * $coupon->value / 100);
                    } else {
                        $discount = min($coupon->value, $plan->price);
                    }
                    $finalAmount = max(0, $plan->price - $discount);
                }
            }
        }

        $orderId = 'MAYAR-'.time().'-'.auth()->id();

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'subscription_plan_id' => $plan->id,
            'coupon_id' => $coupon ? $coupon->id : null,
            'order_id' => $orderId,
            'amount' => $finalAmount,
            'status' => 'pending',
            'payment_gateway' => 'mayar',
        ]);

        if ($coupon) {
            $coupon->increment('used_count');
        }

        $result = $this->mayar->createPaymentLink([
            'name' => 'Subscription - '.$plan->name,
            'description' => 'Payment for '.$plan->name.' subscription',
            'amount' => $finalAmount,
            'redirect_url' => route('payment.success'),
            'notes' => $orderId,
            'expired_at' => now()->addHours(24)->toIso8601String(),
        ]);

        if ($result['success']) {
            $payment->update([
                'payment_url' => $result['data']['link'],
                'gateway_transaction_id' => $result['data']['id'],
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $result['data']['link'],
                'order_id' => $orderId,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to create payment link',
        ], 500);
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();

        Log::info('Mayar webhook received', $payload);

        $transactionId = $payload['data']['id'] ?? null;
        $status = $payload['data']['transactionStatus'] ?? $payload['data']['status'] ?? null;

        if (! $transactionId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $payment = Payment::where('gateway_transaction_id', $transactionId)
            ->orWhere('order_id', $payload['data']['notes'] ?? '')
            ->first();

        if (! $payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        if (in_array(strtolower($status), ['paid', 'settlement', 'capture', 'success'])) {
            $plan = SubscriptionPlan::find($payment->subscription_plan_id);

            if (! $plan) {
                return response()->json(['message' => 'Plan not found'], 404);
            }

            $subscription = Subscription::where('user_id', $payment->user_id)->first();

            if ($subscription && $subscription->end_date && $subscription->end_date->isFuture()) {
                $startDate = $subscription->start_date;
                $endDate = $subscription->end_date->addDays($plan->duration);
            } else {
                $startDate = now();
                $endDate = now()->addDays($plan->duration);
            }

            Subscription::updateOrCreate(
                ['user_id' => $payment->user_id],
                [
                    'subscription_plan_id' => $plan->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'is_active' => true,
                ]
            );

            $payment->update([
                'status' => 'paid',
                'transaction_status' => 'paid',
                'paid_at' => now(),
            ]);
        } elseif (in_array(strtolower($status), ['failed', 'expire', 'cancel', 'deny'])) {
            $payment->update([
                'status' => 'failed',
                'transaction_status' => strtolower($status),
            ]);
        }

        return response()->json(['success' => true], 200);
    }
}
