<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Invitation;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);
        $activeInvitationId = (int) $invitationId;

        $budget = Budget::firstOrCreate(
            ['invitation_id' => $invitationId, 'user_id' => $user->id],
            ['title' => 'Anggaran Pernikahan', 'total_amount' => 0, 'currency' => 'IDR']
        );

        $budget->load(['categories']);

        $totalSpent = 0;
        $totalRemaining = 0;
        $categories = [];

        foreach ($budget->categories as $category) {
            $spent = $category->spentAmount();
            $totalSpent += $spent;
            $remaining = $category->remainingAmount();
            $totalRemaining += $remaining > 0 ? $remaining : 0;

            $categories[] = [
                'id' => $category->id,
                'name' => $category->name,
                'colour' => $category->colour,
                'allocated' => (float) $category->allocated_amount,
                'spent' => $spent,
                'remaining' => $remaining,
                'usage_percent' => $category->usagePercent(),
                'is_over_budget' => $category->isOverBudget(),
            ];
        }

        // Vendor payments summary (next 30 days)
        $upcomingPayments = $budget->payments()
            ->whereIn('status', ['scheduled', 'overdue'])
            ->whereDate('scheduled_date', '>=', now())
            ->whereDate('scheduled_date', '<=', now()->addDays(30))
            ->orderBy('scheduled_date')
            ->limit(5)
            ->get(['id', 'vendor_name', 'amount', 'scheduled_date', 'status']);

        $overdueCount = $budget->payments()
            ->whereIn('status', ['scheduled', 'overdue'])
            ->whereDate('scheduled_date', '<', now())
            ->count();

        $invitations = $this->invitationsForDropdown($user);

        return view('budget.dashboard', compact(
            'budget',
            'categories',
            'totalSpent',
            'totalRemaining',
            'upcomingPayments',
            'overdueCount',
            'invitations',
            'activeInvitationId'
        ));
    }

    public function update(Request $request, Budget $budget)
    {
        $this->authorizeBudget($budget);

        if (! $request->user()->hasFeature('budget_management')) {
            return back()->with('warning', 'Fitur manajemen anggaran membutuhkan langganan yang lebih tinggi.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'in:IDR,USD,MYR,EUR'],
        ]);

        $budget->update($validated);

        return back()->with('success', 'Anggaran berhasil diperbarui 💰');
    }

    private function resolveInvitationId(Request $request, $user): int
    {
        $invitationId = $request->query('invitation_id') ?: $request->input('invitation_id');

        if ($invitationId) {
            return (int) $invitationId;
        }

        if ($user->isAdmin()) {
            return Invitation::first()->id;
        }

        return Invitation::where('user_id', $user->id)
            ->orWhere('partner_user_id', $user->id)
            ->first()?->id ?? 0;
    }

    private function invitationsForDropdown($user)
    {
        if ($user->isAdmin()) {
            return Invitation::all();
        }

        $query = Invitation::where('user_id', $user->id)
            ->orWhere('partner_user_id', $user->id);

        return $query->get();
    }

    private function authorizeBudget(Budget $budget): void
    {
        if (! auth()->user()->canAccessInvitation($budget->invitation)) {
            abort(403, 'Anda tidak memiliki akses ke anggaran ini.');
        }
    }
}
