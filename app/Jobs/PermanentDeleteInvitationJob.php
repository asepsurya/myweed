<?php

namespace App\Jobs;

use App\Models\Invitation;
use App\Services\R2StorageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermanentDeleteInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public $backoff = [300, 600, 1800];

    public function __construct(public int $invitationId)
    {
    }

    public function handle(R2StorageService $storage): void
    {
        $invitation = Invitation::where('id', $this->invitationId)
            ->lockForUpdate()
            ->first();

        if (! $invitation) {
            Log::info('DELETION_SKIPPED', [
                'invitation_id' => $this->invitationId,
                'reason' => 'not_found',
            ]);

            return;
        }

        if ($invitation->is_default) {
            Log::info('DELETION_SKIPPED', [
                'invitation_id' => $this->invitationId,
                'reason' => 'is_default',
            ]);

            return;
        }

        if ($invitation->status !== Invitation::STATUS_TRASH) {
            Log::info('DELETION_SKIPPED', [
                'invitation_id' => $this->invitationId,
                'reason' => 'status_changed',
                'current_status' => $invitation->status,
            ]);

            return;
        }

        if ($invitation->retention_until && $invitation->retention_until->isFuture()) {
            Log::info('DELETION_SKIPPED', [
                'invitation_id' => $this->invitationId,
                'reason' => 'retention_not_expired',
                'retention_until' => $invitation->retention_until,
            ]);

            return;
        }

        if ($invitation->user && $invitation->user->isSubscribed()) {
            $invitation->restore();

            Log::info('DELETION_SKIPPED', [
                'invitation_id' => $this->invitationId,
                'reason' => 'user_resubscribed',
            ]);

            return;
        }

        $invitation->deletion_started_at = now();
        $invitation->save();

        Log::info('DELETION_STARTED', [
            'invitation_id' => $invitation->id,
            'public_id' => $invitation->public_id,
            'user_id' => $invitation->user_id,
            'attempt' => $invitation->deletion_attempts + 1,
        ]);

        $result = $storage->deleteInvitationAssets($invitation);

        if ($result['failed']) {
            $invitation->deletion_attempts = ($invitation->deletion_attempts ?? 0) + 1;
            $invitation->deletion_error = implode(', ', $result['failed']);
            $invitation->save();

            Log::warning('DELETION_FAILED', [
                'invitation_id' => $invitation->id,
                'public_id' => $invitation->public_id,
                'failed_files' => $result['failed'],
                'attempt' => $invitation->deletion_attempts,
            ]);

            if ($invitation->deletion_attempts >= Invitation::MAX_DELETION_ATTEMPTS) {
                Log::error('DELETION_MAX_ATTEMPTS_REACHED', [
                    'invitation_id' => $invitation->id,
                    'public_id' => $invitation->public_id,
                    'attempts' => $invitation->deletion_attempts,
                ]);
            }

            throw new \RuntimeException('R2 deletion failed for '.count($result['failed']).' files.');
        }

        DB::transaction(function () use ($invitation) {
            $invitation->galleries()->delete();
            $invitation->rsvps()->delete();
            $invitation->gifts()->delete();
            $invitation->budgets()->delete();
            $invitation->savingsGoals()->delete();
            $invitation->delete();
        });

        Log::info('DELETION_COMPLETED', [
            'invitation_id' => $invitation->id,
            'public_id' => $invitation->public_id,
            'user_id' => $invitation->user_id,
            'files_deleted' => $result['total'],
            'deleted_dirs' => $result['deleted_dirs'] ?? [],
        ]);
    }
}
