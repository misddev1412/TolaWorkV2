<?php

namespace App\Events;

use App\Job;
use Illuminate\Queue\SerializesModels;

class JobPosted
{

    use SerializesModels;

    public $job;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

}
