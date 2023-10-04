<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobPostNotificationToAlumniAndStudent extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $jobPostInfo;
    public function __construct($jobPostInfo)
    {
        $this->jobPostInfo = $jobPostInfo;
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
            ->greeting('Hello, Job seekers!')
            ->subject('New Job Post Available')
            ->line('A new job post is available for review.')
            ->line('Job Title: ' . $this->jobPostInfo->job_title)
            ->line('Posted By: ' . $this->jobPostInfo->user->name)
            ->action('View Job Post', 'https://jobs1.ewubd.edu/job-details?jobId=' . $this->jobPostInfo->id)
            ->line('Please review and take necessary action.')
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
