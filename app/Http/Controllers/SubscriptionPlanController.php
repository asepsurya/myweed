<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Notifications\SubscriptionSuccessNotification;
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
            'invitation_limit' => 'required|integer|min:1',
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

        $validated['features'] = $this->buildFeatureMatrix($request);

        SubscriptionPlan::create($validated);

        return redirect()->route('subscription-plans.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('dashboard.subscription-plans.edit', compact('subscriptionPlan'));
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subscription_plans,slug,' . $subscriptionPlan->id,
            'price' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'invitation_limit' => 'required|integer|min:1',
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

        $validated['features'] = $this->buildFeatureMatrix($request);

        $subscriptionPlan->update($validated);

        return redirect()->route('subscription-plans.index')->with('success', 'Paket berhasil diperbarui.');
    }

    private function buildFeatureMatrix(Request $request): array
    {
        $booleanKeys = [
            'all_themes',
            'edit_guest_name',
            'rsvp_messages',
            'maps_location',
            'unlimited_recipients',
            'countdown_calendar',
            'gallery',
            'virtual_gift',
            'shareable',
            'background_music',
            'gift_accounts',
            'streaming_video',
            'auto_scroll',
            'custom_music',
            'love_story',
            'custom_theme_color',
            'admin_setup',
            'website_builder',
        ];

        $numericKeys = ['gallery_limit'];

        $features = [];

        foreach ($booleanKeys as $key) {
            $features[$key] = $request->has('features.' . $key);
        }

        foreach ($numericKeys as $key) {
            $value = $request->input('features.' . $key . '_value');

            if ($value !== null && $value !== '') {
                $features[$key] = is_numeric($value) ? (int) $value : 0;
            } else {
                $features[$key] = $request->has('features.' . $key) ? 0 : 0;
            }
        }

        return $features;
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return redirect()->route('subscribe.page')->with('success', 'Paket berhasil dihapus.');
    }

    public function subscribe($planId, Request $request)
    {
        $plan = SubscriptionPlan::findOrFail($planId);

        if (!$request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('error', 'Silakan verifikasi email Anda sebelum melakukan langganan.');
        }

        $couponCode = $request->query('coupon');

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

            $user = User::find(auth()->id());
            $user->notify(new SubscriptionSuccessNotification($plan, null, 'free'));

            return redirect()->back()->with('success', 'Berhasil berlangganan paket gratis!');
        }

        return view('dashboard.payment.checkout', compact('plan'));
    }

    public function initiatePayment(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'coupon' => 'nullable|string',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $couponCode = $request->coupon;
        $coupon = null;
        $discount = 0;
        $finalAmount = $plan->price;

        if ($couponCode && !$plan->is_free) {
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

        if ($plan->is_free || $finalAmount <= 0) {
            $orderId = 'FREE-' . time() . '-' . auth()->id();

            $payment = Payment::create([
                'user_id' => auth()->id(),
                'subscription_plan_id' => $plan->id,
                'coupon_id' => $coupon ? $coupon->id : null,
                'order_id' => $orderId,
                'amount' => 0,
                'status' => 'paid',
                'payment_gateway' => 'midtrans',
                'paid_at' => now(),
            ]);

            Subscription::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'subscription_plan_id' => $plan->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($plan->duration),
                    'is_active' => true,
                ]
            );

            $user = User::find(auth()->id());
            $user->notify(new SubscriptionSuccessNotification($plan, $payment, 'paid'));

            return response()->json([
                'snap_token' => null,
                'order_id' => $orderId,
                'final_amount' => 0,
                'discount' => $discount,
                'coupon_code' => $coupon ? $coupon->code : null,
                'redirect' => route('dashboard'),
            ]);
        }

        $orderId = 'SUB-' . time() . '-' . auth()->id();

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'subscription_plan_id' => $plan->id,
            'coupon_id' => $coupon ? $coupon->id : null,
            'order_id' => $orderId,
            'amount' => $finalAmount,
            'status' => 'pending',
            'payment_gateway' => 'midtrans',
        ]);

        if ($coupon) {
            $coupon->increment('used_count');
        }

        try {
            $baseUrl = rtrim(config('app.url'), '/');
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $finalAmount,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                'finish_redirect_url' => $baseUrl.'/api/payment/success',
                'pending_redirect_url' => $baseUrl.'/api/payment/pending?order_id='.$orderId,
                'error_redirect_url' => $baseUrl.'/api/payment/failed',
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'final_amount' => $finalAmount,
                'discount' => $discount,
                'coupon_code' => $coupon ? $coupon->code : null,
            ]);
        } catch (\Throwable $e) {
            Log::error('Midtrans Snap token failed', [
                'message' => $e->getMessage(),
                'order_id' => $orderId,
            ]);

            return response()->json([
                'snap_token' => null,
                'order_id' => $orderId,
                'final_amount' => $finalAmount,
                'discount' => $discount,
                'coupon_code' => $coupon ? $coupon->code : null,
                'error' => 'Gagal membuat token pembayaran. Silakan coba lagi.',
            ], 500);
        }
    }

    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'amount' => 'required|integer|min:0',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))
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

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Kupon tidak valid atau sudah kadaluarsa.']);
        }

        if ($coupon->min_amount && $request->amount < $coupon->min_amount) {
            return response()->json(['valid' => false, 'message' => 'Minimal pembelian untuk kupon ini adalah Rp ' . number_format($coupon->min_amount, 0, ',', '.') . '.']);
        }

        if ($coupon->type === 'percentage') {
            $discount = (int) floor($request->amount * $coupon->value / 100);
        } else {
            $discount = min($coupon->value, $request->amount);
        }

        return response()->json([
            'valid' => true,
            'coupon' => $coupon->code,
            'discount' => $discount,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ]);
    }

    public function callback(Request $request)
    {
        Log::info('MIDTRANS CALLBACK HIT', $request->all());

        $notification = new Notification;

        $orderId = $notification->order_id;
        $status = $notification->transaction_status;

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
                'transaction_status' => $status,
                'payment_type' => $notification->payment_type,
                'gateway_transaction_id' => $notification->transaction_id,
                'payload' => $request->all(),
            ]);

            $user = User::find($payment->user_id);
            $user->notify(new SubscriptionSuccessNotification($plan, $payment, 'paid'));
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

    public function invoice(Request $request)
    {
        $orderId = $request->query('order_id');

        $payment = Payment::with(['subscriptionPlan', 'coupon', 'user'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        if (!auth()->user()->hasRole('admin') && $payment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payment.invoice', compact('payment'));
    }

    public function invoicePdf(Request $request)
    {
        $orderId = $request->query('order_id');

        $payment = Payment::with(['subscriptionPlan', 'coupon', 'user'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        if (!auth()->user()->hasRole('admin') && $payment->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('payment.invoice', compact('payment'));

        return $pdf->download('invoice-'.$payment->order_id.'.pdf');
    }

    public function paymentStatus(Request $request)
    {
        $query = Payment::with('subscriptionPlan');

        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }

        $payments = $query->latest()->get();

        $paidPayments = $payments->where('status', 'paid');
        $unpaidPayments = $payments->whereIn('status', ['pending', 'failed']);

        $totalPaid = $paidPayments->sum('amount');
        $totalUnpaid = $unpaidPayments->sum('amount');

        return view('payment.status', compact('payments', 'paidPayments', 'unpaidPayments', 'totalPaid', 'totalUnpaid'));
    }

    public function paymentIndex(Request $request)
    {
        $query = Payment::with('subscriptionPlan');

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

    public function userIndex(Request $request)
    {
        $query = User::with('subscription.plan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('plan')) {
            $query->whereHas('subscription', function ($q) use ($request) {
                $q->where('subscription_plan_id', $request->plan);
            });
        }

        $users = $query->latest()->paginate(20);
        $plans = SubscriptionPlan::all();

        return view('dashboard.subscription-plans.users', compact('users', 'plans'));
    }

    public function updateUserPlan(Request $request, User $user)
    {
        $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'duration' => 'nullable|integer|min:1',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->subscription_plan_id);
        $duration = (int) ($request->duration ?? $plan->duration);

        $subscription = $user->subscription;
        if ($subscription && $subscription->end_date && $subscription->end_date->isFuture()) {
            $startDate = $subscription->start_date;
            $endDate = $subscription->end_date->addDays($duration);
        } else {
            $startDate = now();
            $endDate = now()->addDays($duration);
        }

        Subscription::updateOrCreate(
            ['user_id' => $user->id],
            [
                'subscription_plan_id' => $plan->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'is_active' => true,
            ]
        );

        return back()->with('success', 'Paket langganan pengguna berhasil diperbarui.');
    }

    public function cancelUserSubscription(User $user)
    {
        $subscription = $user->subscription;

        if ($subscription) {
            $subscription->update([
                'is_active' => false,
                'end_date' => now(),
            ]);
        }

        return back()->with('success', 'Langganan pengguna berhasil dibatalkan.');
    }

    public function cancel(Request $request)
    {
        $user = $request->user();
        $subscription = $user->subscription;

        if (!$subscription || !$subscription->end_date || !$subscription->end_date->isFuture()) {
            return redirect()->route('subscribe.page')->with('error', 'Tidak ada langganan aktif yang dapat dibatalkan.');
        }

        $subscription->update([
            'is_active' => false,
            'end_date' => now(),
        ]);

        return redirect()->route('subscribe.page')->with('success', 'Langganan Anda berhasil dibatalkan.');
    }
}
