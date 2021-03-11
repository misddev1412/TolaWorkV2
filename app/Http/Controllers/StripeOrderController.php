<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use Config;
use App\Package;
use App\User;
use Carbon\Carbon;
use Cake\Chronos\Chronos;
use App\Traits\CompanyPackageTrait;
use App\Traits\JobSeekerPackageTrait;
/** All Stripe Details class * */
use Stripe\Stripe;
use Stripe\Charge;

class StripeOrderController extends Controller
{
	use CompanyPackageTrait;
	use JobSeekerPackageTrait;
	
    private $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {       		
        /*********************************************/		
		$this->middleware(function ($request, $next) {
            if(Auth::guard('company')->check()){
				$this->redirectTo = 'company.home';				
			}
            return $next($request);
        });
		/*********************************************/
    }
	
	public function stripeOrderForm($package_id, $new_or_upgrade)
	{
		$package = Package::findOrFail($package_id);
		return view('order.pay_with_stripe')
				->with('package', $package)
				->with('package_id', $package_id)
				->with('new_or_upgrade', $new_or_upgrade);
	}

    /**
     * Store a details of payment with paypal.
     *
     * @param IlluminateHttpRequest $request
     * @return IlluminateHttpResponse
     */
    public function stripeOrderPackage(Request $request)
    {
		$package = Package::findOrFail($request->package_id);
		
		$order_amount = $package->package_price;
		
		/***************************/
		$buyer_id = '';
		$buyer_name = '';
		if(Auth::guard('company')->check()){
			$buyer_id = Auth::guard('company')->user()->id;
			$buyer_name = Auth::guard('company')->user()->name.'('.Auth::guard('company')->user()->email.')';			
		}
		if(Auth::check()){
			$buyer_id = Auth::user()->id;
			$buyer_name = Auth::user()->getName().'('.Auth::user()->email.')';
		}
		$package_for = ($package->package_for == 'employer')? __('Employer'):__('Job Seeker');
		$description = $package_for.' '.$buyer_name.' - '.$buyer_id.' '.__('Package').':'.$package->package_title;
		/***************************/
		Stripe::setApiKey(Config::get('stripe.stripe_secret'));
            try {
				$charge = Charge::create(array(
					"amount" => $order_amount*100,
					"currency" => "USD",
					"source" => $request->input('stripeToken'), // obtained with Stripe.js
					"description" => $description
				));
				if($charge['status'] == 'succeeded') {
                    /**
                    * Write Here Your Database insert logic.
                    */
					if(Auth::guard('company')->check()){
						$company = Auth::guard('company')->user();
						$this->addCompanyPackage($company, $package);
					}
					if(Auth::check()){				
						$user = Auth::user();
						$this->addJobSeekerPackage($user, $package);				
					}
					
					flash(__('You have successfully subscribed to selected package'))->success();
					return Redirect::route($this->redirectTo);					
                } else {
                    flash(__('Package subscription failed'));
                    return Redirect::route($this->redirectTo);
                }
            } catch (Exception $e) {
				flash($e->getMessage());
                return Redirect::route($this->redirectTo);
            }
    }
	
	public function StripeOrderUpgradePackage(Request $request)
    {
		
		$package = Package::findOrFail($request->package_id);
		
		$order_amount = $package->package_price;
		
		/***************************/
		$buyer_id = '';
		$buyer_name = '';
		if(Auth::guard('company')->check()){
			$buyer_id = Auth::guard('company')->user()->id;
			$buyer_name = Auth::guard('company')->user()->name.'('.Auth::guard('company')->user()->email.')';			
		}
		if(Auth::check()){
			$buyer_id = Auth::user()->id;
			$buyer_name = Auth::user()->getName().'('.Auth::user()->email.')';
		}
		/****************************/
		
		$package_for = ($package->package_for == 'employer')? __('Employer'):__('Job Seeker');
		$description = $package_for.' '.$buyer_name.' - '.$buyer_id.' '.__('Upgrade Package').':'.$package->package_title;
		/***************************/
		Stripe::setApiKey(Config::get('stripe.stripe_secret'));
            try {
				$charge = Charge::create(array(
					"amount" => $order_amount*100,
					"currency" => "USD",
					"source" => $request->input('stripeToken'), // obtained with Stripe.js
					"description" => $description
				));
		        if($charge['status'] == 'succeeded') {
                    /**
                    * Write Here Your Database insert logic.
                    */
					if(Auth::guard('company')->check()){
						$company = Auth::guard('company')->user();
						$this->updateCompanyPackage($company, $package);				
					}
					if(Auth::check()){
						$user = Auth::user();
						$this->updateJobSeekerPackage($user, $package);				
					}
					
					flash(__('You have successfully subscribed to selected package'))->success();
					return Redirect::route($this->redirectTo);					
                } else {
                    flash(__('Package subscription failed'));
                    return Redirect::route($this->redirectTo);
                }
            } catch (Exception $e) {
				flash($e->getMessage());
                return Redirect::route($this->redirectTo);
            }
    }	

}