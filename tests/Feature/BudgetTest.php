<?php

use App\Models\Budget;
use App\Models\BudgetCategory;
use App\Models\BudgetExpense;
use App\Models\VendorPayment;

test('budget computes spent amount correctly', function () {
    $budget = Budget::factory()->create(['total_amount' => 50000000]);
    $category = BudgetCategory::factory()->create([
        'budget_id' => $budget->id,
        'allocated_amount' => 20000000,
    ]);

    BudgetExpense::factory()->create([
        'budget_category_id' => $category->id,
        'amount' => 15000000,
    ]);
    BudgetExpense::factory()->create([
        'budget_category_id' => $category->id,
        'amount' => 5000000,
    ]);

    $budget = $budget->fresh();

    expect($budget->spentAmount())->toBe(20000000.0)
        ->and($budget->remainingAmount())->toBe(30000000.0)
        ->and($budget->usagePercent())->toBe(40.0)
        ->and($budget->isOverBudget())->toBeFalse();
});

test('budget detects over-budget status', function () {
    $budget = Budget::factory()->create(['total_amount' => 10000000]);
    $category = BudgetCategory::factory()->create([
        'budget_id' => $budget->id,
        'allocated_amount' => 10000000,
    ]);

    BudgetExpense::factory()->create([
        'budget_category_id' => $category->id,
        'amount' => 12000000,
    ]);

    $budget = $budget->fresh();

    expect($budget->isOverBudget())->toBeTrue()
        ->and($budget->usagePercent())->toBe(120.0);
});

test('budget handles zero total gracefully', function () {
    $budget = Budget::factory()->create(['total_amount' => 0]);

    expect($budget->usagePercent())->toBe(0.0)
        ->and($budget->isOverBudget())->toBeFalse();
});

test('budget category computes spent and remaining', function () {
    $budget = Budget::factory()->create();
    $cat = BudgetCategory::factory()->create([
        'budget_id' => $budget->id,
        'allocated_amount' => 5000000,
    ]);

    BudgetExpense::factory()->create([
        'budget_category_id' => $cat->id,
        'amount' => 3000000,
    ]);
    BudgetExpense::factory()->create([
        'budget_category_id' => $cat->id,
        'amount' => 2500000,
    ]);

    $cat = $cat->fresh();

    expect($cat->spentAmount())->toBe(5500000.0)
        ->and($cat->remainingAmount())->toBe(-500000.0)
        ->and($cat->isOverBudget())->toBeTrue()
        ->and($cat->usagePercent())->toBe(110.0);
});

test('vendor payment detects overdue', function () {
    $payment = VendorPayment::factory()->create([
        'scheduled_date' => now()->subDays(5),
        'status' => 'scheduled',
    ]);

    expect($payment->isOverdue())->toBeTrue();
});

test('vendor payment status labels and badges', function () {
    $paid = VendorPayment::factory()->create(['status' => 'paid']);
    $scheduled = VendorPayment::factory()->create(['status' => 'scheduled']);
    $overdue = VendorPayment::factory()->create(['status' => 'overdue']);

    expect($paid->status_label)->toBe('Dibayar')
        ->and($scheduled->status_label)->toBe('Terjadwal')
        ->and($overdue->status_label)->toBe('Terlambat');
});
