<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageSendMail extends Mailable
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
        dd($this->data);
        return $this->from(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
            ->subject('Canidate "' . $this->data['seeker_name'] . '" has sent new message on "' . config('app.name'))
            ->to($this->data['email'], $this->data['name'])
            ->view('emails.send_email_message')
            ->with($this->data);
    }
}
