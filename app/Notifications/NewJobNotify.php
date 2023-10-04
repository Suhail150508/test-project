<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobNotify extends Notification implements ShouldQueue
{
    use Queueable;

    public $jobPost;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($jobPost)
    {
        $this->jobPost = $jobPost;
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
                    ->subject('New Job Available')
                    ->greeting('Hello, Subscriber')
                    ->line('There is a new job post. We hope you will like it.')
                    ->line('Job Title : '.$this->jobPost->job_title)
                    ->action('View Job', url('/'))
                    ->line('Thank you for using our application!');
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
