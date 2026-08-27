<?php

use App\Jobs\ExpireInvitationJob;
use App\Jobs\MoveExpiredToTrashJob;
use App\Jobs\PermanentDeleteInvitationJob;
use App\Models\Invitation;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('r2');
    Storage::fake('public');
});

it('does not expire active invitations with active subscription', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create(['is_free' => false]);
    Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(5),
        'end_date' => now()->addDays(25),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    ExpireInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->refresh();
    expect($invitation->status)->toBe(Invitation::STATUS_PUBLISHED);
});

it('marks published invitation as expired when subscription ended', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create();
    Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(40),
        'end_date' => now()->subDays(10),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    ExpireInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->refresh();
    expect($invitation->status)->toBe(Invitation::STATUS_EXPIRED);
    expect($invitation->expired_at)->not->toBeNull();
    expect($invitation->retention_until)->not->toBeNull();
    expect($invitation->retention_until)->toBeGreaterThan($invitation->expired_at);
});

it('does not move expired invitation to trash before retention period', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create();
    Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(40),
        'end_date' => now()->subDays(10),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    ExpireInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->refresh();
    MoveExpiredToTrashJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->refresh();
    expect($invitation->status)->toBe(Invitation::STATUS_EXPIRED);
});

it('moves expired invitation to trash after retention period', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create();
    Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(40),
        'end_date' => now()->subDays(10),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    ExpireInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->update(['retention_until' => now()->subDay()]);

    MoveExpiredToTrashJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->refresh();
    expect($invitation->status)->toBe(Invitation::STATUS_TRASH);
});

it('restores expired invitation successfully', function () {
    $invitation = Invitation::factory()->create([
        'status' => Invitation::STATUS_EXPIRED,
        'expired_at' => now()->subDays(2),
        'retention_until' => now()->addDays(5),
    ]);

    $result = $invitation->restore();

    expect($result)->toBeTrue();
    expect($invitation->status)->toBe(Invitation::STATUS_PUBLISHED);
    expect($invitation->expired_at)->toBeNull();
    expect($invitation->retention_until)->toBeNull();
});

it('does not permanently delete invitation before retention expires', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create();
    Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(40),
        'end_date' => now()->subDays(10),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    ExpireInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->update([
        'status' => Invitation::STATUS_TRASH,
        'retention_until' => now()->addDays(3),
    ]);

    PermanentDeleteInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->refresh();
    expect($invitation->status)->toBe(Invitation::STATUS_TRASH);
    expect(Invitation::find($invitation->id))->not->toBeNull();
});

it('permanently deletes invitation after retention period', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create();
    Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(40),
        'end_date' => now()->subDays(10),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    ExpireInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->update([
        'status' => Invitation::STATUS_TRASH,
        'retention_until' => now()->subDay(),
    ]);

    PermanentDeleteInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    expect(Invitation::find($invitation->id))->toBeNull();
});

it('skips deletion if user resubscribed before job runs', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create();
    Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(40),
        'end_date' => now()->subDays(10),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    ExpireInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->update([
        'status' => Invitation::STATUS_TRASH,
        'retention_until' => now()->subDay(),
    ]);

    $user->subscription->update([
        'end_date' => now()->addDays(30),
        'is_active' => true,
    ]);

    PermanentDeleteInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->refresh();
    expect($invitation->status)->toBe(Invitation::STATUS_PUBLISHED);
    expect(Invitation::find($invitation->id))->not->toBeNull();
});

it('handles missing r2 files gracefully', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create();
    Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(40),
        'end_date' => now()->subDays(10),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
        'foto_pria' => 'nonexistent/file.webp',
    ]);

    ExpireInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->update([
        'status' => Invitation::STATUS_TRASH,
        'retention_until' => now()->subDay(),
    ]);

    PermanentDeleteInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    expect(Invitation::find($invitation->id))->toBeNull();
});

it('retries deletion when r2 deletion fails', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create();
    Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(40),
        'end_date' => now()->subDays(10),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
        'foto_pria' => 'invitations/test/pria.webp',
    ]);

    ExpireInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->update([
        'status' => Invitation::STATUS_TRASH,
        'retention_until' => now()->subDay(),
    ]);

    $mock = Mockery::mock(\App\Services\R2StorageService::class);
    $mock->shouldReceive('deleteInvitationAssets')
        ->andReturn([
            'success' => [],
            'failed' => ['invitations/test/pria.webp'],
            'total' => 1,
            'deleted_dirs' => [],
        ]);

    $this->app->instance(\App\Services\R2StorageService::class, $mock);

    try {
        PermanentDeleteInvitationJob::dispatch($invitation->id);
        $this->artisan('queue:work --stop-when-empty');
    } catch (\Throwable $e) {
        // Job is expected to throw on partial failure so queue retries it
    }

    $invitation->refresh();
    expect($invitation->deletion_attempts)->toBeGreaterThan(0);
    expect($invitation->status)->toBe(Invitation::STATUS_TRASH);
    expect(Invitation::find($invitation->id))->not->toBeNull();
});

it('is idempotent when job runs twice', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create();
    Subscription::create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(40),
        'end_date' => now()->subDays(10),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    ExpireInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    $invitation->update([
        'status' => Invitation::STATUS_TRASH,
        'retention_until' => now()->subDay(),
    ]);

    PermanentDeleteInvitationJob::dispatch($invitation->id);
    PermanentDeleteInvitationJob::dispatch($invitation->id);
    $this->artisan('queue:work --stop-when-empty');

    expect(Invitation::find($invitation->id))->toBeNull();
});

it('does not delete invitation owned by another user', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create();
    Subscription::create([
        'user_id' => $owner->id,
        'subscription_plan_id' => $plan->id,
        'start_date' => now()->subDays(40),
        'end_date' => now()->subDays(10),
        'is_active' => true,
    ]);

    $invitation = Invitation::factory()->create([
        'user_id' => $owner->id,
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    $response = $this->actingAs($intruder)
        ->post(route('invitation.restore', $invitation));

    $response->assertStatus(403);
    $invitation->refresh();
    expect($invitation->status)->toBe(Invitation::STATUS_PUBLISHED);
});

it('allows admin to force delete invitation', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $invitation = Invitation::factory()->create([
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    $response = $this->actingAs($admin)
        ->delete(route('invitation.force-delete', $invitation));

    $response->assertRedirect();
    $response->assertSessionHas('success');
});

it('prevents non-admin from force deleting', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'status' => Invitation::STATUS_PUBLISHED,
    ]);

    $response = $this->actingAs($user)
        ->delete(route('invitation.force-delete', $invitation));

    $response->assertStatus(403);
});
