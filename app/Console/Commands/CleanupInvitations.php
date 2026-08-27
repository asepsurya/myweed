<?php

namespace App\Console\Commands;

use App\Jobs\ExpireInvitationJob;
use App\Jobs\MoveExpiredToTrashJob;
use App\Jobs\PermanentDeleteInvitationJob;
use App\Models\Invitation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanupInvitations extends Command
{
    protected $signature = 'invitations:cleanup
                            {step : Step to run: expire, trash, delete, retry}
                            {--chunk=100 : Number of invitations per batch}';

    protected $description = 'Process invitation lifecycle: expire, trash, delete, or retry failed deletions';

    public function handle(): void
    {
        $step = $this->argument('step');
        $chunkSize = (int) $this->option('chunk');

        match ($step) {
            'expire' => $this->expirePublishedInvitations($chunkSize),
            'trash' => $this->moveExpiredToTrash($chunkSize),
            'delete' => $this->scheduleDeletions($chunkSize),
            'retry' => $this->retryFailedDeletions($chunkSize),
            default => $this->error("Unknown step: {$step}. Use: expire, trash, delete, retry"),
        };
    }

    protected function expirePublishedInvitations(int $chunkSize): void
    {
        $count = 0;

        Invitation::where('status', Invitation::STATUS_PUBLISHED)
            ->where('is_default', false)
            ->chunkById($chunkSize, function ($invitations) use (&$count) {
                foreach ($invitations as $invitation) {
                    if ($invitation->user && ! $invitation->user->isSubscribed()) {
                        ExpireInvitationJob::dispatch($invitation->id);
                        $count++;
                    }
                }
            });

        $this->info("Dispatched {$count} expiration jobs.");
        Log::info('CLEANUP_EXPIRE_RAN', ['dispatched' => $count]);
    }

    protected function moveExpiredToTrash(int $chunkSize): void
    {
        $count = 0;

        Invitation::where('status', Invitation::STATUS_EXPIRED)
            ->where('is_default', false)
            ->where('retention_until', '<=', now())
            ->chunkById($chunkSize, function ($invitations) use (&$count) {
                foreach ($invitations as $invitation) {
                    MoveExpiredToTrashJob::dispatch($invitation->id);
                    $count++;
                }
            });

        $this->info("Dispatched {$count} trash transition jobs.");
        Log::info('CLEANUP_TRASH_RAN', ['dispatched' => $count]);
    }

    protected function scheduleDeletions(int $chunkSize): void
    {
        $count = 0;

        Invitation::where('status', Invitation::STATUS_TRASH)
            ->where('is_default', false)
            ->where('retention_until', '<=', now())
            ->chunkById($chunkSize, function ($invitations) use (&$count) {
                foreach ($invitations as $invitation) {
                    if ($invitation->deletion_attempts >= Invitation::MAX_DELETION_ATTEMPTS) {
                        continue;
                    }

                    PermanentDeleteInvitationJob::dispatch($invitation->id);
                    $count++;
                }
            });

        $this->info("Dispatched {$count} permanent deletion jobs.");
        Log::info('CLEANUP_DELETE_RAN', ['dispatched' => $count]);
    }

    protected function retryFailedDeletions(int $chunkSize): void
    {
        $count = 0;

        Invitation::where('status', Invitation::STATUS_TRASH)
            ->where('is_default', false)
            ->where('deletion_attempts', '>', 0)
            ->where('deletion_attempts', '<', Invitation::MAX_DELETION_ATTEMPTS)
            ->chunkById($chunkSize, function ($invitations) use (&$count) {
                foreach ($invitations as $invitation) {
                    PermanentDeleteInvitationJob::dispatch($invitation->id);
                    $count++;
                }
            });

        $this->info("Dispatched {$count} retry deletion jobs.");
        Log::info('CLEANUP_RETRY_RAN', ['dispatched' => $count]);
    }
}
