<?php

namespace App\Jobs;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MoveExpiredToTrashJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $invitationId)
    {
    }

    public function handle(): void
    {
        $invitation = Invitation::where('id', $this->invitationId)
            ->where('status', Invitation::STATUS_EXPIRED)
            ->first();

        if (! $invitation) {
            Log::info('INVITATION_TRASH_SKIP', [
                'invitation_id' => $this->invitationId,
                'reason' => 'not_found_or_not_expired',
            ]);

            return;
        }

        if ($invitation->is_default) {
            return;
        }

        if ($invitation->retention_until && $invitation->retention_until->isFuture()) {
            return;
        }

        $invitation->status = Invitation::STATUS_TRASH;
        $invitation->save();

        Log::info('INVITATION_MOVED_TO_TRASH', [
            'invitation_id' => $invitation->id,
            'public_id' => $invitation->public_id,
            'user_id' => $invitation->user_id,
            'retention_until' => $invitation->retention_until,
        ]);
    }
}
