<?php

namespace App\Notifications;

use App\Models\Payment;
use App\Models\SubscriptionPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionSuccessNotification extends Notification
{
    use Queueable;

    public function __construct(
        public SubscriptionPlan $plan,
        public ?Payment $payment = null,
        public string $type = 'paid'
    ) {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $subject = 'Invoice Langganan — ' . $this->plan->name;

        if ($this->type === 'free') {
            $invoiceNumber = 'INV-FREE-' . now()->format('Ymd') . '-' . $notifiable->id;
            $invoiceDate = now()->format('d F Y');

            return (new MailMessage)
                ->subject($subject)
                ->view('notifications.subscription-success-free', [
                    'notifiable' => $notifiable,
                    'plan' => $this->plan,
                    'invoiceNumber' => $invoiceNumber,
                    'invoiceDate' => $invoiceDate,
                ]);
        }

        $invoiceNumber = $this->payment->order_id ?? 'INV-' . now()->format('Ymd') . '-' . $notifiable->id;
        $invoiceDate = $this->payment->paid_at ? $this->payment->paid_at->format('d F Y') : now()->format('d F Y');

        return (new MailMessage)
            ->subject($subject)
            ->view('notifications.subscription-success', [
                'notifiable' => $notifiable,
                'plan' => $this->plan,
                'payment' => $this->payment,
                'invoiceNumber' => $invoiceNumber,
                'invoiceDate' => $invoiceDate,
            ]);
    }
}
