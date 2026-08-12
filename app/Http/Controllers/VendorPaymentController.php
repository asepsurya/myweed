<?php

namespace App\Http\Controllers;

use App\Models\BudgetCategory;
use App\Models\Invitation;
use App\Models\VendorPayment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VendorPaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        $payments = VendorPayment::where('invitation_id', $invitationId)
            ->where('user_id', $user->id)
            ->with('category')
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('date_from'), function ($q) use ($request) {
                $q->whereDate('scheduled_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($q) use ($request) {
                $q->whereDate('scheduled_date', '<=', $request->date_to);
            })
            ->orderby('scheduled_date')
            ->paginate(20)
            ->withQueryString();

        $categories = BudgetCategory::whereHas('budget', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->pluck('name', 'id');

        // Mark any scheduled payment past-due as overdue automatically
        VendorPayment::where('invitation_id', $invitationId)
            ->where('status', 'scheduled')
            ->whereDate('scheduled_date', '<', now())
            ->update(['status' => 'overdue']);

        return view('budget.payment.index', compact('payments', 'categories', 'invitationId'));
    }

    public function store(Request $request)
    {
        $limit = $request->user()->hasFeature('vendor_payment_limit')
            ? (int) data_get($request->user()->subscription?->plan?->features ?? [], 'vendor_payment_limit')
            : 0;

        if ($limit === 0) {
            return back()->with('warning', 'Penjadwalan pembayaran vendor membutuhkan langganan Basic atau Pro.');
        }

        $currentCount = VendorPayment::where('invitation_id', $this->resolveInvitationId($request, $request->user()))
            ->where('status', 'scheduled')
            ->count();

        if ($limit !== null && $currentCount >= $limit) {
            return back()->with('warning', "Anda telah mencapai batas maksimum {$limit} jadwal pembayaran untuk paket Basic Anda.");
        }

        $validated = $request->validate([
            'vendor_name' => ['required', 'string', 'max:255'],
            'vendor_contact' => ['nullable', 'string', 'max:255'],
            'budget_category_id' => ['nullable', Rule::exists('budget_categories', 'id')
                ->whereHas('budget', fn ($q) => $q->where('user_id', $request->user()->id))],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'in:IDR,USD,MYR,EUR'],
            'scheduled_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:scheduled_date'],
            'status' => ['in:scheduled,paid,overdue,cancelled'],
            'notes' => ['nullable', 'string'],
        ], [
            'vendor_name.required' => 'Nama vendor wajib diisi.',
            'amount.required' => 'Jumlah pembayaran wajib diisi.',
            'scheduled_date.required' => 'Tanggal penjadwalan wajib diisi.',
        ]);

        $validated['invitation_id'] = $this->resolveInvitationId($request, $request->user());
        $validated['user_id'] = $request->user()->id;
        $validated['currency'] = $validated['currency'] ?? 'IDR';
        $validated['status'] = $validated['status'] ?? 'scheduled';

        VendorPayment::create($validated);

        return back()->with('success', 'Pembayaran vendor berhasil dijadwalkan 📅');
    }

    public function markPaid(Request $request, VendorPayment $payment)
    {
        $this->authorizePayment($payment);

        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Pembayaran berhasil dicatat sebagai lunas ✅');
    }

    public function update(Request $request, VendorPayment $payment)
    {
        $this->authorizePayment($payment);

        $validated = $request->validate([
            'vendor_name' => ['required', 'string', 'max:255'],
            'vendor_contact' => ['nullable', 'string', 'max:255'],
            'budget_category_id' => ['nullable', Rule::exists('budget_categories', 'id')
                ->whereHas('budget', fn ($q) => $q->where('user_id', $request->user()->id))],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'in:IDR,USD,MYR,EUR'],
            'scheduled_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:scheduled_date'],
            'status' => ['in:scheduled,paid,overdue,cancelled'],
            'notes' => ['nullable', 'string'],
        ]);

        $payment->update($validated);

        return back()->with('success', 'Jadwal pembayaran berhasil diperbarui 📅');
    }

    public function destroy(VendorPayment $payment)
    {
        $this->authorizePayment($payment);

        $payment->delete();

        return back()->with('success', 'Jadwal pembayaran berhasil dihapus 🗑️');
    }

    private function resolveInvitationId(Request $request, $user): int
    {
        $invitationId = $request->query('invitation_id') ?: $request->input('invitation_id');

        if ($invitationId) {
            return (int) $invitationId;
        }

        return $user->isAdmin()
            ? Invitation::first()->id
            : Invitation::where('user_id', $user->id)->value('id');
    }

    private function authorizePayment(VendorPayment $payment): void
    {
        if (! auth()->user()->canAccessInvitation($payment->invitation)) {
            abort(403, 'Anda tidak memiliki akses ke jadwal pembayaran ini.');
        }
    }
}
