<?php

namespace App\Notifications;

use App\Models\SavingsContributor;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SavingsContributorInvitationNotification extends Notification
{
    use Queueable;

    public SavingsContributor $contributor;
    public User $inviter;

    public function __construct(SavingsContributor $contributor, User $inviter)
    {
        $this->contributor = $contributor;
        $this->inviter = $inviter;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $acceptUrl = route('savings.contributor.accept', $this->contributor->invite_token);

        return (new MailMessage)
            ->subject('Undangan Menjadi Kontributor Tabungan — ' . ($this->inviter->name ?? 'RuangUndang.id'))
            ->view('notifications.savings-contributor-invitation', [
                'acceptUrl' => $acceptUrl,
                'inviterName' => $this->inviter->name,
                'contributorName' => $this->contributor->name,
            ]);
    }
}
