<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationVerificationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user;
    public $password;
    public $verification_link;

    public function __construct($user, $password,$verification_link)
    {
        $this->user = $user;
        $this->password = $password;
        $this->verification_link = $verification_link;
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
            ->subject(trans('settings.registration_email_subject'))
            ->greeting('')
            ->line(trans('settings.mr').' '.$this->user->bn_name)
            ->line(trans('settings.registration_message'))
            ->line(trans('user.label_email').": ".$this->user->email)
            ->line(trans('user.label_username').": ".$this->user->username)
            ->line(trans('user.label_password').": ".$this->password)
                    ->action(trans('settings.click_here'),$this->verification_link)
                    ->line(trans('login.password_reset_expire_time'))
                    ->line(trans(''))
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
