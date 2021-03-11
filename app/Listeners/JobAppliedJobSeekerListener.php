<?php

namespace App\Listeners;

use Mail;
use App\Events\JobApplied;
use App\Mail\JobAppliedJobSeekerMailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobAppliedJobSeekerListener implements ShouldQueue
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
    public function handle(JobApplied $event)
    {
        Mail::send(new JobAppliedJobSeekerMailable($event->job, $event->jobApply));
    }

}
