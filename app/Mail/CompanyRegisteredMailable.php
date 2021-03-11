<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyRegisteredMailable extends Mailable
{

    use SerializesModels;

    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company)
    {
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->subject('Employer/Company "' . $this->company->name . '" has been registered on "' . config('app.name'))
                        ->view('emails.company_registered_message')
                        ->with(
                                [
                                    'name' => $this->company->name,
                                    'email' => $this->company->email,
                                    'link' => route('company.detail', $this->company->slug),
                                    'link_admin' => route('edit.company', ['id' => $this->company->id])
                                ]
        );
    }

}
