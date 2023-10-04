<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your OTP is: ' . $this->otp)
            // ->action('Verify OTP', url('/verify-otp'))
            ->line('This OTP will expire in 2 minutes.')
            ->line("Please don't share your OTP in any one");
    }

    public function toArray($notifiable)
    {
        return [

        ];
    }
}
