<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Payment;
use Midtrans\Notification;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class subscriptionPlanController extends Controller
{
     public function index()
    {
        $plans = SubscriptionPlan::all();
        return view('dashboard.subscriptions.index', compact('plans'));
    }
    public function subscribe($planId)
    {
        // $plan = SubscriptionPlan::findOrFail($planId);

        // Subscription::updateOrCreate(
        //     ['user_id' => auth()->id()],
        //     [
        //         'subscription_plan_id' => $plan->id,
        //         'start_date' => now(),
        //         'end_date' => now()->addDays($plan->duration),
        //         'is_active' => true
        //     ]
        // );

        // return redirect()->back()->with('success', 'Berhasil berlangganan!');
        $plan = SubscriptionPlan::findOrFail($planId);
        if($plan->slug == 'basic'){
            Subscription::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'subscription_plan_id' => 1,
                    'start_date' => now(),
                    'end_date' => now()->addDays($plan->duration),
                    'is_active' => true
                ]
            );
             return redirect()->back()->with('success', 'Berhasil berlangganan!');
        }else{
            $orderId = 'SUB-' . time() . '-' . auth()->id();

            $payment = Payment::create([
                'user_id' => auth()->id(),
                'subscription_plan_id' => $plan->id,
                'order_id' => $orderId,
                'amount' => $plan->price,
                'status' => 'pending'
            ]);

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $plan->price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],

            ];

            $snapToken = Snap::getSnapToken($params);

            return view('dashboard.payment.checkout', compact('snapToken', 'plan'));
        }

    }

    public function callback(Request $request)
    {
        Log::info('MIDTRANS CALLBACK HIT', $request->all());

        // Ambil notifikasi Midtrans
        $notification = new Notification();

        $orderId = $notification->order_id;
        $status  = $notification->transaction_status;

        // Cari payment (JANGAN firstOrFail)
        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        if (in_array($status, ['settlement', 'capture'])) {

            $plan = SubscriptionPlan::find($payment->subscription_plan_id);

            if (!$plan) {
                return response()->json(['message' => 'Plan not found'], 404);
            }

            $subscription = Subscription::where('user_id', $payment->user_id)->first();

            if ($subscription && $subscription->end_date && $subscription->end_date->isFuture()) {
                $startDate = $subscription->start_date;
                $endDate   = $subscription->end_date->addDays($plan->duration);
            } else {
                $startDate = now();
                $endDate   = now()->addDays($plan->duration);
            }

            Subscription::updateOrCreate(
                ['user_id' => $payment->user_id], // ✅ BENAR
                [
                    'subscription_plan_id' => $plan->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'is_active' => true
                ]
            );

            $payment->update(['status' => 'paid']);
        }

        // WAJIB return cepat
        return response()->json(['success' => true], 200);
    }
    public function success()
    {
        $orderId = $request->get('order_id');

        $payment = Payment::with('subscriptionPlan')
            ->where('order_id', $orderId)
            ->first();

        return view('payment.success', compact('payment'));
    }

    public function pending()
    {
        return view('payment.pending');
    }

    public function failed()
    {
        return view('payment.failed');
    }

    public function paymentIndex(Request $request){
        $query = Payment::with('subscriptionPlan');

        // user biasa
        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('order_id', 'like', "%{$request->search}%");
        }

        $payments = $query->latest()->get();

         return view('payment.index', compact('payments'));
    }

}
