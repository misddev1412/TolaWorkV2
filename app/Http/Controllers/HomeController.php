<?php

namespace App\Http\Controllers;

use App\Traits\Cron;
use App\Job;
use App\FavouriteCompany;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    use Cron;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->runCheckPackageValidity();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matchingJobs = Job::where('functional_area_id', auth()->user()->industry_id)->paginate(7);
		$followers = FavouriteCompany::where('user_id', auth()->user()->id)->get();
        $chart='';
        return view('home', compact('chart', 'matchingJobs', 'followers'));
    }

}
