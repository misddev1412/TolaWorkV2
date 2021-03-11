<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicantContactMail extends Mailable
{

    use Queueable,
        SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->data['from_email'], $this->data['from_name'])
                        ->replyTo($this->data['from_email'], $this->data['from_name'])
                        ->to($this->data['to_email'], $this->data['to_name'])
                        ->subject('Contact from : ' . $this->data['from_name'])
                        ->view('emails.send_applicant_contact_message')
                        ->with($this->data);
    }

}
