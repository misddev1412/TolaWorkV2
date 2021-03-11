<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportAbuse extends Mailable
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
        return $this->from($this->data['your_email'], $this->data['your_name'])
                        ->replyTo($this->data['your_email'], $this->data['your_name'])
                        ->to(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->subject($this->data['your_name'] . '" has reported a "' . config('app.name') . '" link')
                        ->view('emails.report_abuse_message')
                        ->with($this->data);
    }

}
