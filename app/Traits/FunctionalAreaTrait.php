<?php

namespace App\Traits;

use DB;
use App\Job;
use Carbon\Carbon;

trait FunctionalAreaTrait
{

    private function getFunctionalAreaIdsAndNumJobs($limit = 16)
    {
        return Job::select('functional_area_id', DB::raw('COUNT(jobs.functional_area_id) AS num_jobs'))
						->where('expiry_date', '>' ,Carbon::now())
                        ->groupBy('functional_area_id')
                        ->notExpire()
                        ->active()
                        ->orderBy('num_jobs', 'DESC')
                        ->limit($limit)
                        ->get();
    }

}
