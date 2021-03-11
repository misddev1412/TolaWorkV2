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
/** All Paypal Details class * */
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class OrderController extends Controller
{
	use CompanyPackageTrait;
	use JobSeekerPackageTrait;
	
    private $_api_context;
	private $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {       		
        /** setup PayPal api context * */
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
		
		/*********************************************/		
		$this->middleware(function ($request, $next) {
            if(Auth::guard('company')->check()){
				$this->redirectTo = 'company.home';				
			}
            return $next($request);
        });
		/*********************************************/
		
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param IlluminateHttpRequest $request
     * @return IlluminateHttpResponse
     */
    public function orderPackage(Request $request, $package_id)
    {
		$package = Package::findOrFail($package_id);
		
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
		
		$payer = new Payer();
		/***************************/
        $payer->setPaymentMethod('paypal');
        /***************************/
		$item_1 = new Item();
        $item_1->setName($package_for.' '.__('Package').' : '.$package->package_title) /** item name * */
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($order_amount);/** unit price * */
        /***************************/
		$item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal($order_amount);
        /***************************/
		$transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription($description);
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status', $package_id)) /** Specify return URL * */
                ->setCancelUrl(URL::route('payment.status', $package_id));
        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; * */
        try {
            $payment->create($this->_api_context);
        } catch (PayPalExceptionPPConnectionException $ex) {
            if (Config::get('app.debug')) {
                flash('Connection timeout');
                return Redirect::route($this->redirectTo);
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; * */
                /** $err_data = json_decode($ex->getData(), true); * */
                /** exit; * */
            } else {
                flash(__('Some error occur, sorry for inconvenient'));
                return Redirect::route($this->redirectTo);
                /** die('Some error occur, sorry for inconvenient'); * */
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session * */
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal * */
            return Redirect::away($redirect_url);
        }
        flash(__('Unknown error occurred'));
        return Redirect::route($this->redirectTo);
    }
	
	public function orderUpgradePackage(Request $request, $package_id)
    {
		
		$package = Package::findOrFail($package_id);
		
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
		
		$payer = new Payer();
		/***************************/
        $payer->setPaymentMethod('paypal');
        /***************************/
		$item_1 = new Item();
        $item_1->setName($package_for.' '.__('Upgrade Package').' : '.$package->package_title) /** item name * */
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($order_amount);/** unit price * */
        /***************************/
		$item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal($order_amount);
        /***************************/
		$transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription($description);
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('upgrade.payment.status', $package_id)) /** Specify return URL * */
                ->setCancelUrl(URL::route('upgrade.payment.status', $package_id));
        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; * */
        try {
            $payment->create($this->_api_context);
        } catch (PayPalExceptionPPConnectionException $ex) {
            if (Config::get('app.debug')) {
                flash('Connection timeout');
                return Redirect::route($this->redirectTo);
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; * */
                /** $err_data = json_decode($ex->getData(), true); * */
                /** exit; * */
            } else {
                flash(__('Some error occur, sorry for inconvenient'));
                return Redirect::route($this->redirectTo);
                /** die('Some error occur, sorry for inconvenient'); * */
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session * */
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal * */
            return Redirect::away($redirect_url);
        }
        flash(__('Unknown error occurred'));
        return Redirect::route($this->redirectTo);
    }


    public function getUpgradePaymentStatus(Request $request, $package_id)
    {
		
		$package = Package::findOrFail($package_id);
		
        /** Get the payment ID before session clear * */
        $payment_id = $request->get('paymentId');//Session::get('paypal_payment_id');
        /** clear the session payment ID * */
        Session::forget('paypal_payment_id');
        if (empty($request->get('PayerID')) || empty($request->get('token'))) {
            flash(__('Subscription failed'));
            return Redirect::route($this->redirectTo);
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary * */
        /** to execute a PayPal account payment. * */
        /** The payer_id is added to the request query parameters * */
        /** when the user is redirected from paypal back to your site * */
        $execution = new PaymentExecution();
        $execution->setPayerId($request->get('PayerID'));
        /*         * Execute the payment * */
        $result = $payment->execute($execution, $this->_api_context);
        /** dd($result);exit; /** DEBUG RESULT, remove it later * */
        if ($result->getState() == 'approved') {
            /** it's all right * */
            /** Here Write your database logic like that insert record or value in database if you want * */
			
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
        }
        flash(__('Subscription failed'));
        return Redirect::route($this->redirectTo);
    }
	
	public function getPaymentStatus(Request $request, $package_id)
    {
		$package = Package::findOrFail($package_id);
		/**********************************************/
		
        /** Get the payment ID before session clear * */
        $payment_id = $request->get('paymentId');//Session::get('paypal_payment_id');
        /** clear the session payment ID * */
        Session::forget('paypal_payment_id');
        if (empty($request->get('PayerID')) || empty($request->get('token'))) {
            flash(__('Subscription failed'));
            return Redirect::route($this->redirectTo);
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary * */
        /** to execute a PayPal account payment. * */
        /** The payer_id is added to the request query parameters * */
        /** when the user is redirected from paypal back to your site * */
        $execution = new PaymentExecution();
        $execution->setPayerId($request->get('PayerID'));
        /*         * Execute the payment * */
        $result = $payment->execute($execution, $this->_api_context);
        /** dd($result);exit; /** DEBUG RESULT, remove it later * */
        if ($result->getState() == 'approved') {
            /** it's all right * */
            /** Here Write your database logic like that insert record or value in database if you want * */
			
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
        }
        flash(__('Subscription failed'));
        return Redirect::route($this->redirectTo);
    }

}