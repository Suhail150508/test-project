<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $token;
    public $link;
    public function __construct($token)
    {
        $this->token = $token;
        $this->link = url('/').route('password.reset',['token' => $this->token, 'email' => request('email')], false);

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(trans('passwords.password_reset'))
                    ->greeting('')
                    ->line(trans('passwords.password_reset_receive'))
                    ->action(trans('passwords.password_reset'),$this->link)
                    ->line(trans('passwords.password_reset_expire_time'))
                    ->line(trans('passwords.password_reset_not_want'))
                    ->salutation('')
                    ->salutation('');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
