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

use Tzsk\Payu\Concerns\Attributes;
use Tzsk\Payu\Concerns\Customer;
use Tzsk\Payu\Concerns\Transaction;
use Tzsk\Payu\Facades\Payu;

class PayuController extends Controller
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
        /*         * ****************************************** */
        $this->middleware(function ($request, $next) {
            if (Auth::guard('company')->check()) {
                $this->redirectTo = 'company.home';
            }
            return $next($request);
        });
        /*         * ****************************************** */
    }

    public function orderPackage(Request $request)
    {
        $package = Package::findOrFail($request->package_id);

        $order_amount = $package->package_price;

        /*         * ************************ */
        $buyer_id = '';
        $buyer_name = '';
        if (Auth::guard('company')->check()) {
            $buyer_id = Auth::guard('company')->user()->id;
            $buyer_name = Auth::guard('company')->user()->name . '(' . Auth::guard('company')->user()->email . ')';
            $buyer_email = Auth::guard('company')->user()->email;
        }
        if (Auth::check()) {
            $buyer_id = Auth::user()->id;
            $buyer_name = Auth::user()->getName() . '(' . Auth::user()->email . ')';
            $buyer_email = Auth::user()->email;
        }
        $package_for = ($package->package_for == 'employer') ? __('Employer') : __('Job Seeker');
        $description = $package_for . ' ' . $buyer_name . ' - ' . $buyer_id . ' ' . __('Package') . ':' . $package->package_title;
        /*         * ************************ */


        $customer = Customer::make()->firstName($buyer_name)->email($buyer_email);



        $attributes = Attributes::make()->udf1($package->id);

        $transaction = Transaction::make()->charge($order_amount)->for($package->package_title)->with($attributes)->to($customer);

        $payu =  Payu::initiate($transaction)->redirect(route('payu.order.package.status',['type='.$request->type]));

        return $payu;
    }

    public function orderPackageStatus(Request $request){
       
       $transaction = Payu::capture();

       if($transaction->response('status')=='success'){

        $package_id = $transaction->response('udf1');

        $package = Package::findOrFail($package_id);
        
        if (Auth::guard('company')->check()) {

                $company = Auth::guard('company')->user();

                    if($request->type=='new'){
                        $this->addCompanyPackage($company, $package);
                    }else{
                        $this->updateCompanyPackage($company, $package);
                    }
                }
            if (Auth::check()) {

                $user = Auth::user();
                if($request->type=='new'){
                    $this->addJobSeekerPackage($user, $package);
                }else{
                    $this->updateJobSeekerPackage($user, $package);
                }
                

            }

            flash(__('You have successfully subscribed to selected package'))->success();

            return Redirect::route($this->redirectTo);
       }
    }


}
