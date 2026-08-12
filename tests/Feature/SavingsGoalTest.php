<?php

use App\Models\SavingsContribution;
use App\Models\SavingsGoal;

test('savings goal computes progress correctly', function () {
    $goal = SavingsGoal::factory()->create(['target_amount' => 10000000]);

    SavingsContribution::factory()->create([
        'savings_goal_id' => $goal->id,
        'amount' => 4000000,
    ]);
    SavingsContribution::factory()->create([
        'savings_goal_id' => $goal->id,
        'amount' => 3000000,
    ]);

    $goal = $goal->fresh();

    expect($goal->totalSaved())->toBe(7000000.0)
        ->and($goal->remainingAmount())->toBe(3000000.0)
        ->and($goal->progressPercent())->toBe(70.0);
});

test('savings goal caps progress at 100 percent', function () {
    $goal = SavingsGoal::factory()->create(['target_amount' => 5000000]);

    SavingsContribution::factory()->create([
        'savings_goal_id' => $goal->id,
        'amount' => 6000000,
    ]);

    $goal = $goal->fresh();

    expect($goal->progressPercent())->toBe(100.0);
});

test('savings goal calculates days remaining and daily required', function () {
    $goal = SavingsGoal::factory()->create([
        'target_amount' => 10000000,
        'deadline' => now()->addDays(10)->toDateString(),
    ]);

    SavingsContribution::factory()->create([
        'savings_goal_id' => $goal->id,
        'amount' => 4000000,
    ]);

    $goal = $goal->fresh();
    $daysRemaining = $goal->daysRemaining();

    expect($goal->remainingAmount())->toBe(6000000.0)
        ->and($daysRemaining)->toBeGreaterThanOrEqual(9)
        ->and($daysRemaining)->toBeLessThanOrEqual(11)
        ->and($goal->dailyRequired())->toBe(round(6000000 / $daysRemaining, 2));
});

test('savings goal determines on-track status', function () {
    $goal = SavingsGoal::factory()->create([
        'target_amount' => 10000000,
        'deadline' => now()->addDays(10)->toDateString(),
    ]);

    SavingsContribution::factory()->create([
        'savings_goal_id' => $goal->id,
        'amount' => 1000000,
    ]);

    $goal = $goal->fresh();

    expect($goal->progressPercent())->toBe(10.0)
        ->and($goal->isOnTrack())->toBeFalse();
});

test('savings goal detects milestone achievements', function () {
    $goal = SavingsGoal::factory()->create(['target_amount' => 10000000]);

    expect($goal->milestone())->toBeNull();

    SavingsContribution::factory()->create([
        'savings_goal_id' => $goal->id,
        'amount' => 7500000,
    ]);
    $goal->refresh();
    expect($goal->milestone())->toBe('75_percent');

    SavingsContribution::factory()->create([
        'savings_goal_id' => $goal->id,
        'amount' => 1500000,
    ]);
    $goal->refresh();
    expect($goal->milestone())->toBe('90_percent');
});
