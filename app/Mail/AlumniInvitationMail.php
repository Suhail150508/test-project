<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlumniInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('alumni.invite_mail_body');
    }
}
