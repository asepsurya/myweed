<?php

use App\Models\Budget;
use App\Models\BudgetCategory;
use App\Models\Invitation;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'user']);
});

it('allows admin to view budget dashboard', function () {
    $user = User::factory()->create();
    $user->forceFill(['role' => 'admin'])->save();
    $user->assignRole('admin');

    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    Budget::factory()->create([
        'invitation_id' => $invitation->id,
        'user_id' => $user->id,
        'total_amount' => 10000000,
    ]);

    $response = $this->actingAs($user)->get('/budget');
    $response->assertOk();
});

it('shows budget categories', function () {
    $user = User::factory()->create();
    $user->forceFill(['role' => 'admin'])->save();
    $user->assignRole('admin');

    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $budget = Budget::factory()->create([
        'invitation_id' => $invitation->id,
        'user_id' => $user->id,
    ]);

    BudgetCategory::factory()->create(['budget_id' => $budget->id, 'allocated_amount' => 5000000, 'name' => 'Venue']);

    $response = $this->actingAs($user)->get('/budget/categories');
    $response->assertOk();
    $response->assertSee('Venue');
});

it('allows admin to create budget expense', function () {
    $user = User::factory()->create();
    $user->forceFill(['role' => 'admin'])->save();
    $user->assignRole('admin');

    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $budget = Budget::factory()->create([
        'invitation_id' => $invitation->id,
        'user_id' => $user->id,
    ]);
    $category = BudgetCategory::factory()->create([
        'budget_id' => $budget->id,
        'allocated_amount' => 10000000,
    ]);

    $response = $this->actingAs($user)->post('/budget/expenses', [
        'budget_category_id' => $category->id,
        'vendor_name' => 'Test Vendor',
        'amount' => 5000000,
        'expense_date' => now()->format('Y-m-d'),
        'payment_method' => 'transfer',
        'is_paid' => true,
    ]);

    $response->assertRedirect('/budget/expenses');
    $this->assertDatabaseHas('budget_expenses', [
        'budget_category_id' => $category->id,
        'vendor_name' => 'Test Vendor',
        'amount' => 5000000,
    ]);
});

it('allows admin to update budget', function () {
    $user = User::factory()->create();
    $user->forceFill(['role' => 'admin'])->save();
    $user->assignRole('admin');

    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $budget = Budget::factory()->create([
        'invitation_id' => $invitation->id,
        'user_id' => $user->id,
        'total_amount' => 1000000,
        'title' => 'Old Title',
    ]);

    $response = $this->actingAs($user)->put('/budget/'.$budget->id, [
        'title' => 'New Title',
        'total_amount' => 2000000,
        'currency' => 'IDR',
    ]);

    $response->assertRedirect();
    $budget->refresh();
    expect($budget->title)->toBe('New Title');
});

it('blocks non-admin from accessing budget without subscription', function () {
    $user = User::factory()->create();
    $user->forceFill(['role' => 'user'])->save();
    $user->assignRole('user');

    $response = $this->actingAs($user)->get('/budget');
    $response->assertRedirect('/subscription-plans');
});
