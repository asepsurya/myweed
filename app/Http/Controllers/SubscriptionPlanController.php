<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Payment;
use Midtrans\Notification;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Http\Controllers\Controller;

class SubscriptionPlanController extends Controller
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

    public function callback(Request $request)
    {
        $notification = new Notification();

        $orderId = $notification->order_id;
        $status = $notification->transaction_status;

        $payment = Payment::where('order_id', $orderId)->firstOrFail();

        if (in_array($status, ['settlement', 'capture'])) {

            $plan = SubscriptionPlan::find($payment->subscription_plan_id);

            $subscription = Subscription::where('user_id', $payment->user_id)->first();

            if ($subscription && $subscription->end_date?->isFuture()) {
                $startDate = $subscription->start_date;
                $endDate = $subscription->end_date->addDays($plan->duration);
            } else {
                $startDate = now();
                $endDate = now()->addDays($plan->duration);
            }

              Subscription::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'subscription_plan_id' => $plan->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($plan->duration),
                    'is_active' => true
                ]
                );

            $payment->update(['status' => 'paid']);
        }

        return response()->json(['success' => true]);
    }
}
