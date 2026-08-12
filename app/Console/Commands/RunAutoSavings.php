<?php

namespace App\Console\Commands;

use App\Models\SavingsContribution;
use App\Models\SavingsGoal;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RunAutoSavings extends Command
{
    protected $signature = 'savings:run-auto';

    protected $description = 'Process all daily/weekly/monthly auto-savings contributions that are due today';

    public function handle()
    {
        $today = now()->toDateString();
        $goals = SavingsGoal::where('is_active', true)
            ->whereNotNull('auto_savings_rule')
            ->with('invitation')
            ->get();

        $processed = 0;
        $created = 0;

        foreach ($goals as $goal) {
            $rule = $goal->auto_savings_rule;
            if (! $rule) {
                continue;
            }

            $nextRun = $this->nextRunDate($goal);
            if (Carbon::parse($nextRun)->toDateString() !== $today) {
                continue;
            }

            // Skip if goal is already fully funded
            if ($goal->progressPercent() >= 100) {
                $processed++;

                continue;
            }

            $amount = $rule['amount'] ?? 0;
            if ($amount <= 0) {
                continue;
            }

            // Don't exceed the target
            $remaining = $goal->remainingAmount();
            $contributionAmount = min($amount, $remaining);

            SavingsContribution::create([
                'savings_goal_id' => $goal->id,
                'invitation_id' => $goal->invitation_id,
                'contributor_id' => $goal->user_id,
                'user_id' => $goal->user_id,
                'amount' => $contributionAmount,
                'currency' => $goal->currency ?? 'IDR',
                'method' => 'auto',
                'contributed_at' => now(),
                'is_automatic' => true,
                'note' => 'Tabungan otomatis - '.($rule['frequency'] ?? 'recurring'),
            ]);

            $processed++;
            $created++;

            if ($goal->progressPercent() >= 100) {
                $this->info("Goal '{$goal->name}' has been fully funded!");
            }
        }

        $this->info("{$processed} goal(s) processed, {$created} auto-contribution(s) created for {$today}.");
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
}
