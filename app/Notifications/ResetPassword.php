<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Password — RuangUndang')
            ->view('notifications.reset-password', [
                'resetUrl' => $resetUrl,
                'userName' => $notifiable->name,
                'logoUrl' => 'https://ruangundang.my.id/assets/logo-new.png',
                'brandName' => 'RuangUndang',
            ]);
    }
}
