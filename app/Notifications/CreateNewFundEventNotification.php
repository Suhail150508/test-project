<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateNewFundEventNotification extends Notification
{
    use Queueable;

    public $redirect_rul;
    public $sender_id;
    public $sender_name;
    public $amount;

    public function __construct($redirect_rul, $sender_id, $sender_name, $amount)
    {
        $this->redirect_rul = $redirect_rul;
        $this->sender_id = $sender_id;
        $this->sender_name = $sender_name;
        $this->amount = $amount;
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
            'amount' => $this->amount,
            'message' => $this->sender_name .' created a new fund event',
        ];
    }
}
