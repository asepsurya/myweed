<?php

namespace App\Jobs;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExpireInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $invitationId)
    {
    }

    public function handle(): void
    {
        $invitation = Invitation::where('id', $this->invitationId)
            ->where('status', Invitation::STATUS_PUBLISHED)
            ->first();

        if (! $invitation) {
            Log::info('INVITATION_EXPIRED_SKIP', [
                'invitation_id' => $this->invitationId,
                'reason' => 'not_found_or_not_published',
            ]);

            return;
        }

        if ($invitation->is_default) {
            return;
        }

        if ($invitation->user && $invitation->user->isSubscribed()) {
            return;
        }

        $updated = $invitation->markAsExpired();

        if ($updated) {
            Log::info('INVITATION_EXPIRED', [
                'invitation_id' => $invitation->id,
                'public_id' => $invitation->public_id,
                'user_id' => $invitation->user_id,
                'expired_at' => $invitation->expired_at,
                'retention_until' => $invitation->retention_until,
            ]);
        }
    }
}
