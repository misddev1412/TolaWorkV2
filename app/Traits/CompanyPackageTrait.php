<?php

namespace App\Traits;

use DB;
use Carbon\Carbon;
use App\Company;

trait CompanyPackageTrait
{
	
	public function addCompanyPackage($company, $package)
	{
		$now = Carbon::now();
		$company->package_id = $package->id;
		$company->package_start_date = $now;
		$company->package_end_date = $now->addDays($package->package_num_days);
		$company->jobs_quota = $package->package_num_listings;
		$company->availed_jobs_quota = 0;
		$company->update();
	}
	
	public function updateCompanyPackage($company, $package)
	{
		$package_end_date = $company->package_end_date;
		$current_end_date = Carbon::createFromDate($package_end_date->format('Y'),$package_end_date->format('m'),$package_end_date->format('d'));
		
		$company->package_id = $package->id;
		$company->package_end_date = $current_end_date->addDays($package->package_num_days);
		$company->jobs_quota = ($company->jobs_quota-$company->availed_jobs_quota) + $package->package_num_listings;
		$company->availed_jobs_quota = 0;
		$company->update();
	}
	
}
