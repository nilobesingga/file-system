<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewStatementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $portalUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct($portalUrl)
    {
        $this->portalUrl = $portalUrl ?? url('/dashboard'); // Default to dashboard if no URL provided
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('New Account Statement Available')
        ->view('vendor.notifications.email', [
            'userName' => $notifiable->name,
            'portalUrl' => $this->portalUrl,
        ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
