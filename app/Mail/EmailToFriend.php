<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailToFriend extends Mailable
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
                        ->to($this->data['friend_email'], $this->data['friend_name'])
                        ->subject(__('Your friend') . ' ' . $this->data['your_name'] . ' ' . __('has shared a link with you'))
                        ->view('emails.send_to_friend_message')
                        ->with($this->data);
    }

}
