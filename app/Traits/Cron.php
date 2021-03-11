<?php

namespace App\Traits;

use Mail;
use DB;
use Carbon\Carbon;
use App\User;
use App\Company;
use App\Package;
use App\SiteSetting;

trait Cron
{

    private function runCheckPackageValidity()
    {
        $now = Carbon::now();

        if ((bool) config('student.is_student_package_active')) {
            $user_ids = User::select('id')->where('package_end_date', '<', $now)->pluck('id')->toArray();
            if (count($user_ids) > 0) {
                DB::table('users')->whereIn('id', $user_ids)->update(array('package_id' => 0, 'package_start_date' => null, 'package_end_date' => null, 'jobs_quota' => 0, 'availed_jobs_quota' => 0));
            }
        }

        $company_ids = Company::select('id')->where('package_end_date', '<', $now)->pluck('id')->toArray();
        if (count($company_ids) > 0) {
            DB::table('companies')->whereIn('id', $company_ids)->update(array('package_id' => 0, 'package_start_date' => null, 'package_end_date' => null, 'jobs_quota' => 0, 'availed_jobs_quota' => 0));
        }
    }

}
