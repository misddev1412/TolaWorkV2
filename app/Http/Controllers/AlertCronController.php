<?php

namespace App\Http\Controllers;
use App\Job;
use App\Alert;
use App\Industry;
use DB;
use Mail;
use App\Mail\AlertJobsMail;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class AlertCronController extends Controller
{

    public function index(){
    	$alerts = Alert::get();
    	if(null!==($alerts)){
    		foreach ($alerts as $key => $alert) {
    			$search = $alert->search_title;
    			$country_id = $alert->country_id;
    			$state_id = $alert->state_id;
    			$city_id = $alert->city_id;
    			$functional_area_id = $alert->functional_area_id;
    		   	$query = Job::select('*');
    		   	$query->where('created_at', '>=', Carbon::now()->subDay());
	           	if ($search != '') {
	                     $query->Where('title', 'like', '%' . $search . '%');
	            }
	            if ($country_id != '') {
	                
	                $query->where('country_id',$country_id);
	                       
	            }
	            if ($state_id != '') {
	                
	                $query->where('state_id',$state_id);
	                       
	            }
	            if ($city_id != '') {
	                
	                $query->where('city_id',$city_id);
	                       
	            }
	            if ($functional_area_id	!= '') {
	                
	                $query->where('functional_area_id',$functional_area_id);
	                       
	            }

	            
                $query->orderBy('jobs.id', 'DESC'); 
                

            	$jobs = $query->active()->take(10)->get();

            	if(null!==($jobs) && count($jobs)>0){
            		if($search_location != '') {
            			$loca = $search_location;
            		}else{
            			$loca = 'United Kingdom';
            		}
			        $data['email'] = $alert->email;
			        $data['subject'] = count($jobs).' new '.$alert->search_title.' jobs in '.$loca;
			        $data['jobs'] = $jobs;


			        Mail::send(new AlertJobsMail($data));
            	}

            	
    		}
    	}
    }

}
