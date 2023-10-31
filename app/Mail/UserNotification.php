<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email_subject;
    public $email_view_file;
    public $data;

    public function __construct(array $email_variables, $email_subject, $email_view_file = 'general')
    {
        $this->data = $email_variables;
        $this->email_view_file = $email_view_file;
        $this->email_subject = $email_subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->email_subject)
            ->view("emails.{$this->email_view_file}");
    }
}
