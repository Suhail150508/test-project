<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;
    private $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->data['text'])
            ->greeting('Welcome '.$this->data['name'])
            ->line(@$this->data['line1'])
            ->line(@$this->data['line2'])
            ->line($this->data['body'])
            ->action($this->data['text'], $this->data['url'])
            ->line($this->data['thanks']);
    }

    public function toDatabase($notifiable)
    {
        info($this->id);
        return [
            'id' => $this->id,
            'name' => $this->data['name'],
            'text' => $this->data['text'],
            'body' => $this->data['body'],
            'thanks' => $this->data['thanks'],
            'url' => $this->data['url'],
            'time' => $this->data['time'],
        ];
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
            'id' => $this->data['id'],
            'name' => $this->data['name'],
            'text' => $this->data['text'],
            'body' => $this->data['body'],
            'thanks' => $this->data['thanks'],
            'url' => $this->data['url'],
            'time' => $this->data['time'],
        ];
    }
}
