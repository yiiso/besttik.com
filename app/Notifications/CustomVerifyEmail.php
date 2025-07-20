<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends VerifyEmail
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(__('messages.verify_email_subject', ['app' => config('app.name')]))
            ->greeting(__('messages.verify_email_greeting', ['name' => $notifiable->name]))
            ->line(__('messages.verify_email_line1'))
            ->action(__('messages.verify_email_action'), $verificationUrl)
            ->line(__('messages.verify_email_line2'))
            ->line(__('messages.verify_email_line3'))
            ->salutation(__('messages.email_signature', ['app' => config('app.name')]));
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}