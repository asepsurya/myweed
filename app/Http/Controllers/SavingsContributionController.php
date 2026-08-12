<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\SavingsContribution;
use App\Models\SavingsGoal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SavingsContributionController extends Controller
{
    private const METHODS = ['transfer', 'e-wallet', 'cash', 'card'];

    public function index(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        $contributions = SavingsContribution::where('invitation_id', $invitationId)
            ->whereIn('invitation_id', function ($q) use ($user) {
                $q->select('id')
                    ->from('invitations')
                    ->where(function ($sq) use ($user) {
                        $sq->where('user_id', $user->id)
                            ->orWhere('partner_user_id', $user->id);
                    });
            })
            ->with(['goal', 'contributor'])
            ->when($request->filled('goal_id'), function ($q) use ($request) {
                $q->where('savings_goal_id', $request->goal_id);
            })
            ->when($request->filled('contributor_id'), function ($q) use ($request) {
                $q->where('contributor_id', $request->contributor_id);
            })
            ->latest('contributed_at')
            ->paginate(20)
            ->withQueryString();

        $goals = SavingsGoal::where('invitation_id', $invitationId)->pluck('name', 'id');
        $contributors = User::whereIn('id', SavingsContribution::where('invitation_id', $invitationId)
            ->pluck('contributor_id')->unique())
            ->get();

        return view('savings.contribution.index', compact('contributions', 'goals', 'contributors', 'invitationId'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (! $user->hasFeature('savings_multi_user')) {
            return back()->with('warning', 'Multi-user tabungan membutuhkan langganan Basic atau Pro.');
        }

        $contributors = $this->contributorsFor($this->resolveInvitationId($request, $user));

        $validated = $request->validate([
            'savings_goal_id' => ['required', Rule::exists('savings_goals', 'id')
                ->where('invitation_id', $this->resolveInvitationId($request, $user))],
            'contributor_id' => ['required', Rule::in($contributors->pluck('id')->toArray())],
            'amount' => ['required', 'numeric', 'min:1'],
            'currency' => ['nullable', 'in:IDR,USD,MYR,EUR'],
            'method' => ['required', Rule::in(self::METHODS)],
            'contributed_at' => ['nullable', 'date'],
            'note' => ['nullable', 'string', 'max:500'],
        ], [
            'savings_goal_id.required' => 'Target tabungan wajib dipilih.',
            'amount.required' => 'Jumlah setoran wajib diisi.',
            'contributor_id.required' => 'Kontributor wajib dipilih.',
        ]);

        $validated['invitation_id'] = $this->resolveInvitationId($request, $user);
        $validated['user_id'] = $user->id;
        $validated['currency'] = $validated['currency'] ?? 'IDR';
        $validated['contributed_at'] = $validated['contributed_at'] ?? now();

        $contribution = SavingsContribution::create($validated);

        $goal = SavingsGoal::find($validated['savings_goal_id']);
        $milestone = $goal?->milestone();

        $message = 'Setoran berhasil dicatat 🎉';
        if ($milestone === 'complete') {
            $message = 'Selamat! Target tabungan '.$goal->name.' telah tercapai penuh 🎉🎊';
        } elseif ($milestone === '90_percent') {
            $message = 'Setoran berhasil dicatat! 🎯 Hampir mencapai target '.$goal->name.'.';
        }

        return redirect()->route('savings.contribution.index')->with('success', $message);
    }

    public function edit(SavingsContribution $contribution)
    {
        $this->authorizeContribution($contribution);
        $goals = SavingsGoal::where('invitation_id', $contribution->invitation_id)->pluck('name', 'id');
        $contributors = $this->contributorsFor($contribution->invitation_id);

        return view('savings.contribution.edit', compact('contribution', 'goals', 'contributors'));
    }

    public function update(Request $request, SavingsContribution $contribution)
    {
        $this->authorizeContribution($contribution);

        $contributors = $this->contributorsFor($contribution->invitation_id);

        $validated = $request->validate([
            'savings_goal_id' => ['required', Rule::exists('savings_goals', 'id')
                ->where('invitation_id', $contribution->invitation_id)],
            'contributor_id' => ['required', Rule::in($contributors->pluck('id')->toArray())],
            'amount' => ['required', 'numeric', 'min:1'],
            'currency' => ['nullable', 'in:IDR,USD,MYR,EUR'],
            'method' => ['required', Rule::in(self::METHODS)],
            'contributed_at' => ['nullable', 'date'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['currency'] = $validated['currency'] ?? 'IDR';

        $contribution->update($validated);

        return redirect()->route('savings.contribution.index')->with('success', 'Setoran berhasil diperbarui 🎉');
    }

    public function destroy(SavingsContribution $contribution)
    {
        $this->authorizeContribution($contribution);

        $contribution->delete();

        return back()->with('success', 'Setoran berhasil dihapus 🗑️');
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

    private function contributorsFor(int $invitationId)
    {
        $inv = Invitation::findOrFail($invitationId);

        return User::whereIn('id', [$inv->user_id, $inv->partner_user_id])
            ->get();
    }

    private function authorizeContribution(SavingsContribution $contribution): void
    {
        if (! auth()->user()->canAccessInvitation($contribution->invitation)) {
            abort(403, 'Anda tidak memiliki akses ke setoran ini.');
        }
    }
}
