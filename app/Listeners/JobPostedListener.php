<?php

namespace App\Listeners;

use Mail;
use App\Events\JobPosted;
use App\Mail\JobPostedMailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobPostedListener implements ShouldQueue
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CompanyRegistered  $event
     * @return void
     */
    public function handle(JobPosted $event)
    {
        Mail::send(new JobPostedMailable($event->job));
    }

}
