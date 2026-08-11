<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Notification;
use Midtrans\Snap;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::all();

        return view('dashboard.subscriptions.index', compact('plans'));
    }

    public function adminIndex()
    {
        $plans = SubscriptionPlan::all();

        return view('dashboard.subscription-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('dashboard.subscription-plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subscription_plans,slug',
            'price' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_free' => 'nullable|boolean',
        ]);

        $validated['is_free'] = $request->has('is_free');
        $validated['price'] = $validated['is_free'] ? 0 : $validated['price'];

        if ($request->filled('description')) {
            $validated['description'] = json_encode(
                array_filter(array_map('trim', explode("\n", $request->description)))
            );
        } else {
            $validated['description'] = json_encode([]);
        }

        SubscriptionPlan::create($validated);

        return redirect()->route('subscribe.page')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('dashboard.subscription-plans.edit', compact('subscriptionPlan'));
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subscription_plans,slug,'.$subscriptionPlan->id,
            'price' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_free' => 'nullable|boolean',
        ]);

        $validated['is_free'] = $request->has('is_free');
        $validated['price'] = $validated['is_free'] ? 0 : $validated['price'];

        if ($request->filled('description')) {
            $validated['description'] = json_encode(
                array_filter(array_map('trim', explode("\n", $request->description)))
            );
        } else {
            $validated['description'] = json_encode([]);
        }

        $subscriptionPlan->update($validated);

        return redirect()->route('subscribe.page')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return redirect()->route('subscribe.page')->with('success', 'Paket berhasil dihapus.');
    }

    public function subscribe($planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);

        if ($plan->is_free) {
            Subscription::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'subscription_plan_id' => $plan->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($plan->duration),
                    'is_active' => true,
                ]
            );

            return redirect()->back()->with('success', 'Berhasil berlangganan paket gratis!');
        } else {
            $orderId = 'SUB-'.time().'-'.auth()->id();

            $payment = Payment::create([
                'user_id' => auth()->id(),
                'subscription_plan_id' => $plan->id,
                'order_id' => $orderId,
                'amount' => $plan->price,
                'status' => 'pending',
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

        $notification = new Notification;

        $orderId = $notification->order_id;
        $status = $notification->transaction_status;

        $payment = Payment::where('order_id', $orderId)->first();

        if (! $payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        if (in_array($status, ['settlement', 'capture'])) {

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

            $payment->update(['status' => 'paid']);
        }

        return response()->json(['success' => true], 200);
    }

    public function success(Request $request)
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

    public function paymentIndex(Request $request)
    {
        $query = Payment::with('subscriptionPlan');

        if (! auth()->user()->hasRole('admin')) {
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
