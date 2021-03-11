<?php

namespace App\Providers;

use App\SiteSetting;
use App\Language;
use Illuminate\Support\ServiceProvider;

class CustomConfigServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		if ($settings = SiteSetting::findOrFail(1272)) {
			

            $this->app['config']['mail'] = [
                'driver' => $settings->mail_driver,
                'host' => $settings->mail_host,
                'port' => $settings->mail_port,
                'from' => [
                    'address' => $settings->mail_from_address,
                    'name' => $settings->mail_from_name
                ],
                'recieve_to' => [
                    'address' => $settings->mail_to_address,
                    'name' => $settings->mail_to_name
                ],
                'encryption' => $settings->mail_encryption,
                'username' => $settings->mail_username,
                'password' => $settings->mail_password,
                'sendmail' => $settings->mail_sendmail,
                'pretend' => $settings->mail_pretend
            ];

            $this->app['config']['services'] = [
                'mailgun' => [
                    'domain' => $settings->mailgun_domain,
                    'secret' => $settings->mailgun_secret,
                ],
                'mandrill' => [
                    'secret' => $settings->mandrill_secret,
                ],
                'sparkpost' => [
                    'secret' => $settings->sparkpost_secret,
                ],
                'ses' => [
                    'key' => $settings->ses_key,
                    'secret' => $settings->ses_secret,
                    'region' => $settings->ses_region, // e.g. us-east-1
                ],
            ];
        
			

            $this->app['config']['captcha'] = [
                'sitekey' => $settings->nocaptcha_sitekey,
                'secret' => $settings->nocaptcha_secret,
                'options' => ['timeout' => 2.0,],
            ];

            $this->app['config']['services'] = [
                'facebook' => [
                    'client_id' => $settings->facebook_app_id,
                    'client_secret' => $settings->facebeek_app_secret,
                    'redirect' => url('login/jobseeker/facebook/callback'),
                ],
                'twitter' => [
                    'client_id' => $settings->twitter_app_id,
                    'client_secret' => $settings->twitter_app_secret,
                    'redirect' => url('login/jobseeker/twitter/callback'),
                ],
                'google' => [
                    'client_id' => $settings->google_app_id,
                    'client_secret' => $settings->google_app_secret,
                    'redirect' => url('login/jobseeker/google/callback'),
                ],
            ];

            $this->app['config']['paypal'] = [ 
				'client_id' => env('PAYPAL_CLIENT_ID',$settings->paypal_client_id),
				'secret' => env('PAYPAL_SECRET',$settings->paypal_secret),
				'settings' => array(
					'mode' => env('PAYPAL_MODE',$settings->paypal_live_sandbox),
					'http.ConnectionTimeOut' => 1000,
					'log.LogEnabled' => true,
					'log.FileName' => storage_path() . '/logs/paypal.log',
					'log.LogLevel' => 'ERROR'
				),
			];
			
			$this->app['config']['stripe'] = [ 
				'stripe_key' => env('stripe_key',$settings->stripe_key),
				'stripe_secret' => env('stripe_secret',$settings->stripe_secret),
			];
			
			$this->app['config']['jobseeker'] = [ 
				'is_jobseeker_package_active' => $settings->is_jobseeker_package_active,
			];									
        
		}

        $this->app['config']['default_lang'] = 'en';
        if(null !== $lang = Language::where('is_default', '=', 1)->first()){
			if ($lang !== null) {
				$this->app['config']['default_lang'] = $lang->iso_code;
			}
		}
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
