<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetExpense;
use App\Models\Invitation;
use App\Models\SavingsContribution;
use App\Models\SavingsGoal;
use App\Models\VendorPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancialDashboardController extends Controller
{
    public function index(Request $request)
    {
        if (! $request->user()->hasFeature('budget_management')) {
            return back()->with('warning', 'Fitur Ikhtisar Keuangan membutuhkan langganan Basic atau Pro.');
        }

        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        $budget = Budget::where('invitation_id', $invitationId)->first();
        $savingsGoals = SavingsGoal::where('invitation_id', $invitationId)->get();
        $vendorPayments = VendorPayment::where('invitation_id', $invitationId)
            ->whereIn('status', ['scheduled', 'overdue'])
            ->whereDate('scheduled_date', '>=', now())
            ->whereDate('scheduled_date', '<=', now()->addDays(30))
            ->orderBy('scheduled_date')
            ->limit(5)
            ->get();

        $totalSpent = $budget ? $budget->spentAmount() : 0;
        $totalSaved = (float) SavingsContribution::where('invitation_id', $invitationId)
            ->where('is_automatic', false)
            ->sum('amount');

        $categories = $budget ? $budget->categories->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'colour' => $cat->colour,
                'allocated' => (float) $cat->allocated_amount,
                'spent' => $cat->spentAmount(),
                'remaining' => $cat->remainingAmount(),
                'usage_percent' => $cat->usagePercent(),
                'is_over_budget' => $cat->isOverBudget(),
            ];
        }) : [];

        $goals = $savingsGoals->map(function ($goal) {
            return [
                'id' => $goal->id,
                'name' => $goal->name,
                'colour' => $goal->colour,
                'target' => (float) $goal->target_amount,
                'saved' => $goal->totalSaved(),
                'remaining' => $goal->remainingAmount(),
                'progress_percent' => $goal->progressPercent(),
                'deadline' => $goal->deadline ? $goal->deadline->format('Y-m-d') : null,
                'currency' => $goal->currency,
                'days_remaining' => $goal->daysRemaining(),
            ];
        });

        // Next auto-contribution
        $nextAuto = null;
        foreach ($savingsGoals as $goal) {
            $rule = $goal->auto_savings_rule;
            if (! $goal->is_active || ! $rule || $goal->progressPercent() >= 100) {
                continue;
            }

            $frequency = $rule['frequency'] ?? null;
            $amount = $rule['amount'] ?? 0;
            if (! $frequency || $amount <= 0) {
                continue;
            }

            $nextRun = $this->nextRunDate($goal);
            if (is_null($nextAuto) || Carbon::parse($nextRun)->lt($nextAuto['date'])) {
                $nextAuto = [
                    'goal' => $goal->name,
                    'date' => $nextRun,
                    'amount' => $amount,
                ];
            }
        }

        // Recent activity (combined contributions + expenses)
        $activity = $this->recentActivity($invitationId, $user);

        $data = [
            'budget' => [
                'total_amount' => (float) ($budget?->total_amount ?? 0),
                'total_spent' => $totalSpent,
                'total_remaining' => (float) ($budget?->total_amount ?? 0) - $totalSpent,
                'usage_percent' => $budget ? $budget->usagePercent() : 0,
                'is_over_budget' => $budget ? $budget->isOverBudget() : false,
                'categories' => $categories,
            ],
            'savings' => [
                'total_saved' => $totalSaved,
                'total_target' => $savingsGoals->sum('target_amount'),
                'progress_percent' => $savingsGoals->sum('target_amount') > 0
                    ? round(($totalSaved / $savingsGoals->sum('target_amount')) * 100, 1)
                    : 0,
                'goals' => $goals,
                'next_auto_contribution' => $nextAuto,
            ],
            'payments' => [
                'upcoming' => $vendorPayments->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'vendor' => $p->vendor_name,
                        'amount' => (float) $p->amount,
                        'scheduled_date' => $p->scheduled_date->format('Y-m-d'),
                        'status' => $p->status,
                    ];
                }),
            ],
            'money_available' => $totalSaved + ((float) ($budget?->total_amount ?? 0) - $totalSpent),
            'activity' => $activity,
        ];

        $invitations = $user->isAdmin()
            ? Invitation::all()
            : Invitation::where('user_id', $user->id)
                ->orWhere('partner_user_id', $user->id)
                ->get();

        return view('financial-overview.index', [
            'financialData' => $data,
            'invitations' => $invitations,
            'activeInvitationId' => $invitationId,
        ]);
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

    private function nextRunDate(SavingsGoal $goal): string
    {
        $rule = $goal->auto_savings_rule;
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

    private function recentActivity(int $invitationId, $user): array
    {
        $contributions = SavingsContribution::where('invitation_id', $invitationId)
            ->with('contributor')
            ->latest('contributed_at')
            ->limit(3)
            ->get()
            ->map(function ($c) {
                return [
                    'type' => 'contribution',
                    'user' => $c->contributor?->name ?? 'Anda',
                    'amount' => (float) $c->amount,
                    'ago' => Carbon::parse($c->contributed_at)->diffForHumans(),
                    'detail' => $c->goal?->name ?? '',
                ];
            });

        $expenses = BudgetExpense::where('invitation_id', $invitationId)
            ->where('user_id', $user->id)
            ->with('category')
            ->latest('expense_date')
            ->limit(3)
            ->get()
            ->map(function ($e) {
                return [
                    'type' => 'expense',
                    'user' => $e->user?->name ?? 'Anda',
                    'amount' => (float) $e->amount,
                    'ago' => Carbon::parse($e->expense_date)->diffForHumans(),
                    'detail' => $e->category?->name ?? '',
                ];
            });

        $combined = $contributions->merge($expenses)->sortByDesc(function ($item) {
            return $item['ago'];
        })->take(6);

        return $combined->values()->toArray();
    }
}
