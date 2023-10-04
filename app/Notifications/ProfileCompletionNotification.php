<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileCompletionNotification extends Notification
{
    use Queueable;

    public $redirect_rul;
    public $sender_id;
    public $sender_name;
    public $profile_completion_percentage_amount;

    public function __construct($redirect_rul, $sender_id, $sender_name, $profile_completion_percentage_amount)
    {
        $this->redirect_rul = $redirect_rul;
        $this->sender_id = $sender_id;
        $this->sender_name = $sender_name;
        $this->profile_completion_percentage_amount = $profile_completion_percentage_amount;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Hello,')
            ->action('View Profile', url('https://alumni.ewubd.edu'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'redirect_rul' => $this->redirect_rul,
            'sender_id' => $this->sender_id,
            'sender_name' => $this->sender_name,
            'profile_completion_percentage' => $this->profile_completion_percentage_amount,
            'message' => $this->sender_name .' informed you to update your profile',
        ];
    }
}
