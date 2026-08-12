<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\SavingsGoal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SavingsGoalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        $goals = SavingsGoal::where('invitation_id', $invitationId)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('is_shared', true);
            })
            ->withCount('contributions')
            ->withSum('contributions', 'amount')
            ->latest()
            ->get();

        return view('savings.goal.index', compact('goals', 'invitationId'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);
        $contributors = $this->contributorsFor($invitationId);

        return view('savings.goal.create', compact('contributors', 'invitationId'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (! $user->isAdmin()) {
            $goalLimit = (int) data_get($user->subscription?->plan?->features ?? [], 'savings_goals');

            if ($goalLimit === 0) {
                return back()->with('warning', 'Target tabungan membutuhkan langganan Basic atau Pro.');
            }

            $currentCount = SavingsGoal::where('invitation_id', $this->resolveInvitationId($request, $user))->count();

            if ($goalLimit !== null && $currentCount >= $goalLimit) {
                return back()->with('warning', "Anda telah mencapai batas maksimum {$goalLimit} target untuk paket Anda.");
            }
        }

        $validated = $this->validateGoal($request);
        $validated['invitation_id'] = $this->resolveInvitationId($request, $user);
        $validated['user_id'] = $user->id;

        SavingsGoal::create($validated);

        return redirect()->route('savings.goal.index')->with('success', 'Target tabungan berhasil dibuat 🎯');
    }

    public function edit(SavingsGoal $goal)
    {
        $this->authorizeGoal($goal);
        $invitationId = $goal->invitation_id;
        $contributors = $this->contributorsFor($invitationId);

        return view('savings.goal.create', compact('goal', 'contributors', 'invitationId'));
    }

    public function update(Request $request, SavingsGoal $goal)
    {
        $this->authorizeGoal($goal);

        $validated = $this->validateGoal($request);

        $goal->update($validated);

        return redirect()->route('savings.goal.index')->with('success', 'Target tabungan berhasil diperbarui 🎯');
    }

    public function destroy(SavingsGoal $goal)
    {
        $this->authorizeGoal($goal);

        $goal->delete();

        return back()->with('success', 'Target tabungan berhasil dihapus 🗑️');
    }

    public function toggleActive(SavingsGoal $goal)
    {
        $this->authorizeGoal($goal);

        $goal->update(['is_active' => ! $goal->is_active]);

        return back()->with('success', 'Status target berhasil diubah.');
    }

    private function validateGoal(Request $request): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'target_amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'in:IDR,USD,MYR,EUR'],
            'deadline' => ['required', 'date'],
            'colour' => ['nullable', 'string', 'max:7'],
            'description' => ['nullable', 'string'],
            'is_shared' => ['boolean'],
        ];

        if ($request->has('auto_frequency')) {
            $rules['auto_frequency'] = ['nullable', Rule::in(['daily', 'weekly', 'monthly', 'custom'])];
            $rules['auto_amount'] = ['nullable', 'numeric', 'min:0'];
            $rules['auto_interval_days'] = ['nullable', 'integer', 'min:1'];
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Nama target wajib diisi.',
            'target_amount.required' => 'Jumlah target wajib diisi.',
            'deadline.required' => 'Tanggal deadline wajib diisi.',
        ]);

        if ($request->has('auto_frequency') && $request->filled('auto_frequency')) {
            $validated['auto_savings_rule'] = [
                'frequency' => $request->auto_frequency,
                'amount' => $request->auto_amount,
                'interval_days' => $request->auto_interval_days,
                'day_of_week' => $request->auto_day_of_week,
                'day_of_month' => $request->auto_day_of_month,
            ];
            unset($validated['auto_frequency'], $validated['auto_amount'], $validated['auto_interval_days'], $validated['auto_day_of_week'], $validated['auto_day_of_month']);
        }

        $validated['currency'] = $validated['currency'] ?? 'IDR';
        $validated['colour'] = $validated['colour'] ?? '#C6A962';
        $validated['is_shared'] = (bool) $request->input('is_shared', true);

        return $validated;
    }

    private function resolveInvitationId(Request $request, $user): int
    {
        $invitationId = $request->query('invitation_id') ?: $request->input('invitation_id');

        if ($invitationId) {
            return (int) $invitationId;
        }

        return $user->isAdmin()
            ? Invitation::first()->id
            : Invitation::where('user_id', $user->id)->first()?->id;
    }

    private function contributorsFor(int $invitationId)
    {
        $inv = Invitation::findOrFail($invitationId);

        return User::whereIn('id', [$inv->user_id, $inv->partner_user_id])
            ->get();
    }

    private function authorizeGoal(SavingsGoal $goal): void
    {
        if (! auth()->user()->canAccessInvitation($goal->invitation)) {
            abort(403, 'Anda tidak memiliki akses ke target tabungan ini.');
        }
    }
}
