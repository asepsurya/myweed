<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\SavingsContribution;
use App\Models\SavingsGoal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SavingsAutomationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        $goals = SavingsGoal::where('invitation_id', $invitationId)
            ->where('is_active', true)
            ->get()
            ->map(function ($goal) {
                $rule = $goal->auto_savings_rule;
                $hasRule = (bool) $rule;

                return [
                    'id' => $goal->id,
                    'name' => $goal->name,
                    'target_amount' => $goal->target_amount,
                    'saved' => $goal->totalSaved(),
                    'progress_percent' => $goal->progressPercent(),
                    'has_rule' => $hasRule,
                    'rule' => $rule,
                    'next_run' => $hasRule ? $this->nextRunDate($goal) : null,
                    'deadline' => $goal->deadline,
                ];
            });

        return view('savings.automation.index', compact('goals', 'invitationId'));
    }

    public function updateRule(Request $request)
    {
        $user = $request->user();
        $goal = SavingsGoal::findOrFail($request->goal_id);

        if (! auth()->user()->canAccessInvitation($goal->invitation)) {
            abort(403);
        }

        if (! $user->hasFeature('auto_savings_rules')) {
            return back()->with('warning', 'Aturan tabungan otomatis membutuhkan langganan Basic atau Pro.');
        }

        $action = $request->input('action', 'save');

        if ($action === 'disable') {
            $goal->update(['auto_savings_rule' => null]);

            return back()->with('success', 'Aturan tabungan otomatis dimatikan.');
        }

        $validated = $request->validate([
            'goal_id' => ['required', 'exists:savings_goals,id'],
            'frequency' => ['required', 'in:daily,weekly,monthly,custom'],
            'amount' => ['required', 'numeric', 'min:1'],
            'day_of_week' => ['nullable', 'integer', 'min:0', 'max:6'],
            'day_of_month' => ['nullable', 'integer', 'min:1', 'max:31'],
            'interval_days' => ['nullable', 'integer', 'min:1'],
        ]);

        $goal->update([
            'auto_savings_rule' => [
                'frequency' => $validated['frequency'],
                'amount' => $validated['amount'],
                'day_of_week' => $validated['day_of_week'],
                'day_of_month' => $validated['day_of_month'],
                'interval_days' => $validated['interval_days'],
            ],
        ]);

        return back()->with('success', 'Aturan tabungan otomatis berhasil diperbarui 🔄');
    }

    public function runPending(Request $request)
    {
        $date = $request->input('date') ?? now()->toDateString();

        $goals = SavingsGoal::where('is_active', true)
            ->whereNotNull('auto_savings_rule')
            ->get();

        $processed = 0;
        $created = 0;

        foreach ($goals as $goal) {
            $rule = $goal->auto_savings_rule;
            if (! $rule || $goal->progressPercent() >= 100) {
                continue;
            }

            $nextRun = $this->nextRunDate($goal);
            if (Carbon::parse($nextRun)->is($date)) {
                $processed++;

                if ($goal->progressPercent() < 100) {
                    $contribution = SavingsContribution::create([
                        'savings_goal_id' => $goal->id,
                        'invitation_id' => $goal->invitation_id,
                        'contributor_id' => $goal->user_id,
                        'user_id' => $goal->user_id,
                        'amount' => $rule['amount'] ?? 0,
                        'currency' => $goal->currency ?? 'IDR',
                        'method' => 'auto',
                        'contributed_at' => now(),
                        'is_automatic' => true,
                        'note' => 'Tabungan otomatis - '.($rule['frequency'] ?? 'recurring'),
                    ]);
                    $created++;
                }
            }
        }

        return response()->json([
            'success' => true,
            'processed' => $processed,
            'created' => $created,
            'message' => "Diproses {$processed} target, {$created} setoran otomatis dibuat.",
        ]);
    }

    private function nextRunDate(SavingsGoal $goal): ?string
    {
        $rule = $goal->auto_savings_rule;
        if (! $rule) {
            return null;
        }

        $frequency = $rule['frequency'] ?? 'daily';
        $now = now();

        return match ($frequency) {
            'daily' => $now->addDay()->toDateString(),
            'weekly' => $now->addDays(7 - $now->dayOfWeek)->toDateString(),
            'monthly' => $now->addMonth()->toDateString(),
            'custom' => $now->addDays($rule['interval_days'] ?? 7)->toDateString(),
            default => $now->addDay()->toDateString(),
        };
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
}
