<?php

use App\Models\Invitation;
use App\Models\SavingsContribution;
use App\Models\SavingsGoal;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'user']);
});

it('allows admin to view savings dashboard', function () {
    $user = User::factory()->create();
    $user->forceFill(['role' => 'admin'])->save();
    $user->assignRole('admin');

    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    SavingsGoal::factory()->create([
        'invitation_id' => $invitation->id,
        'user_id' => $user->id,
        'target_amount' => 10000000,
    ]);

    $response = $this->actingAs($user)->get('/savings');
    $response->assertOk();
});

it('allows admin to create a savings goal', function () {
    $user = User::factory()->create();
    $user->forceFill(['role' => 'admin'])->save();
    $user->assignRole('admin');

    $invitation = Invitation::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->post('/savings/goals', [
        'name' => 'Test Goal',
        'target_amount' => 5000000,
        'currency' => 'IDR',
        'deadline' => now()->addDays(30)->format('Y-m-d'),
        'colour' => '#FF0000',
        'description' => 'Test description',
        'is_shared' => true,
    ]);

    $response->assertRedirect('/savings/goals');
    $this->assertDatabaseHas('savings_goals', [
        'name' => 'Test Goal',
        'target_amount' => 5000000,
        'invitation_id' => $invitation->id,
    ]);
});

it('allows admin to add a contribution', function () {
    $user = User::factory()->create();
    $user->forceFill(['role' => 'admin'])->save();
    $user->assignRole('admin');

    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $goal = SavingsGoal::factory()->create([
        'invitation_id' => $invitation->id,
        'user_id' => $user->id,
        'target_amount' => 10000000,
    ]);

    $response = $this->actingAs($user)->post('/savings/contributions', [
        'savings_goal_id' => $goal->id,
        'contributor_id' => $user->id,
        'amount' => 5000000,
        'method' => 'transfer',
        'contributed_at' => now()->format('Y-m-d'),
    ]);

    $response->assertRedirect('/savings/contributions');
    $this->assertDatabaseHas('savings_contributions', [
        'savings_goal_id' => $goal->id,
        'amount' => 5000000,
    ]);
});

it('calculates milestone on contribution store', function () {
    $user = User::factory()->create();
    $user->forceFill(['role' => 'admin'])->save();
    $user->assignRole('admin');

    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $goal = SavingsGoal::factory()->create([
        'invitation_id' => $invitation->id,
        'user_id' => $user->id,
        'target_amount' => 10000000,
    ]);

    SavingsContribution::factory()->create([
        'savings_goal_id' => $goal->id,
        'amount' => 1000000,
    ]);

    $goal->refresh();
    expect($goal->milestone())->toBeNull();
});

it('blocks non-admin from accessing savings without subscription', function () {
    $user = User::factory()->create();
    $user->forceFill(['role' => 'user'])->save();
    $user->assignRole('user');

    $response = $this->actingAs($user)->get('/savings');
    $response->assertRedirect('/subscription-plans');
});
