<?php

namespace App\Notifications;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PartnerInvitationNotification extends Notification
{
    use Queueable;

    public Invitation $invitation;
    public User $inviter;
    public string $token;
    public bool $canEdit;

    public function __construct(Invitation $invitation, User $inviter, string $token, bool $canEdit)
    {
        $this->invitation = $invitation;
        $this->inviter = $inviter;
        $this->token = $token;
        $this->canEdit = $canEdit;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $acceptUrl = route('partner.accept', $this->token);
        $title = trim(($this->invitation->groom_name ?? '') . ' & ' . ($this->invitation->bride_name ?? ''));
        if ($title === '&') {
            $title = 'Undangan Pernikahan';
        }

        return (new MailMessage)
            ->subject('Undangan Kelola Pasangan — ' . $title)
            ->view('notifications.partner-invitation', [
                'acceptUrl' => $acceptUrl,
                'inviterName' => $this->inviter->name,
                'invitationTitle' => $title,
                'canEdit' => $this->canEdit,
                'inviterPlan' => $this->inviter->subscription?->plan,
            ]);
    }
}
