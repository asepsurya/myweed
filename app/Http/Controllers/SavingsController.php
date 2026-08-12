<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\SavingsContribution;
use App\Models\SavingsGoal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SavingsController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);
        $activeInvitationId = (int) $invitationId;

        $goals = SavingsGoal::where('invitation_id', $invitationId)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('is_shared', true);
            })
            ->with('contributions')
            ->latest()
            ->get();

        $totalSaved = $goals->sum(function ($g) {
            return $g->totalSaved();
        });

        $totalTarget = $goals->sum('target_amount');
        $overallProgress = $totalTarget > 0 ? round(($totalSaved / $totalTarget) * 100, 1) : 0;

        $nextAuto = $this->nextAutoContribution($goals);

        $contributors = User::whereIn('id', SavingsContribution::where('invitation_id', $invitationId)
            ->pluck('contributor_id')
            ->unique())
            ->get();

        $invitations = $this->invitationsFor($user);

        return view('savings.dashboard', compact(
            'goals',
            'totalSaved',
            'totalTarget',
            'overallProgress',
            'nextAuto',
            'contributors',
            'invitations',
            'activeInvitationId'
        ));
    }

    public function projection(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);
        $activeInvitationId = (int) $invitationId;

        $goals = SavingsGoal::where('invitation_id', $invitationId)
            ->where('is_active', true)
            ->get();

        $projections = $goals->map(function ($goal) {
            return [
                'goal' => $goal,
                'saved' => $goal->totalSaved(),
                'remaining' => $goal->remainingAmount(),
                'days_left' => $goal->daysRemaining(),
                'daily_required' => $goal->dailyRequired(),
                'is_on_track' => $goal->isOnTrack(),
            ];
        });

        $invitations = $this->invitationsFor($user);

        return view('savings.projection', compact('projections', 'invitations', 'activeInvitationId'));
    }

    private function resolveInvitationId(Request $request, $user): int
    {
        $invitationId = $request->query('invitation_id');

        if ($invitationId) {
            return (int) $invitationId;
        }

        return $user->isAdmin()
            ? Invitation::first()->id
            : Invitation::where('user_id', $user->id)->first()?->id;
    }

    private function invitationsFor($user)
    {
        return $user->isAdmin()
            ? Invitation::all()
            : Invitation::where('user_id', $user->id)
                ->orWhere('partner_user_id', $user->id)
                ->get();
    }

    private function nextAutoContribution($goals)
    {
        $next = null;

        foreach ($goals as $goal) {
            $rule = $goal->auto_savings_rule;
            if (! $goal->is_active || ! $rule || $goal->progressPercent() >= 100) {
                continue;
            }

            $frequency = $rule['frequency'] ?? null;
            $amount = $rule['amount'] ?? 0;
            if (! $frequency || $amount <= 0) {
                continue;
            }

            $nextRun = $this->calculateNextRun($frequency, $rule);

            if (is_null($next) || Carbon\Carbon::parse($nextRun)->lt($next['date'])) {
                $next = [
                    'goal' => $goal->name,
                    'date' => $nextRun,
                    'amount' => $amount,
                ];
            }
        }

        return $next;
    }

    private function calculateNextRun(string $frequency, array $rule): string
    {
        $now = now();

        return match ($frequency) {
            'daily' => $now->addDay()->toDateString(),
            'weekly' => $now->addDays(7 - $now->dayOfWeek)->toDateString(),
            'monthly' => $now->addMonth()->toDateString(),
            'custom' => $now->addDays($rule['interval_days'] ?? 7)->toDateString(),
            default => $now->addDay()->toDateString(),
        };
    }
}
