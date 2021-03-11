<?php

namespace App\Http\Controllers;

use App\Traits\Cron;
use App\Http\Controllers\Controller;

class CronController extends Controller
{

    use App\Traits\Cron;

    public function checkPackageValidity()
    {
        $this->runCheckPackageValidity();
    }

}
