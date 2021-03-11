<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use File;
use Carbon\Carbon;
use ImgUploader;
use Redirect;
use App\Country;
use App\CountryDetail;
use App\SiteSetting;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\SiteSettingFormRequest;
use App\Http\Controllers\Controller;
use App\Helpers\DataArrayHelper;

class SiteSettingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function editSiteSetting()
    {

        $id = 1272;
        $countries = DataArrayHelper::defaultCountriesArray();
        $currency_codes = CountryDetail::select('countries_details.code')->orderBy('countries_details.code')->pluck('countries_details.code', 'countries_details.code')->toArray();
        $mail_drivers = [
            'smtp' => 'SMTP',
            'mail' => 'Mail',
            'sendmail' => 'SendMail',
            'mailgun' => 'MailGun',
            'mandrill' => 'Mandrill',
            'ses' => 'Amazon SES',
            'sparkpost' => 'Sparkpost'
        ];

        $siteSetting = SiteSetting::findOrFail($id);
        return view('admin.site_setting.edit')
                        ->with('siteSetting', $siteSetting)
                        ->with('mail_drivers', $mail_drivers)
                        ->with('countries', $countries)
                        ->with('currency_codes', $currency_codes);
    }

    public function updateSiteSetting(SiteSettingFormRequest $request)
    {

        $id = 1272;
        $siteSetting = SiteSetting::findOrFail($id);

        if ($request->hasFile('image')) {
            $this->deleteSiteSettingImage($id);
            $image_name = $request->input('site_name');
            $fileName = ImgUploader::UploadImage('sitesetting_images', $request->file('image'), $image_name);
            $siteSetting->site_logo = $fileName;
        }

        $siteSetting->site_name = $request->input('site_name');
        $siteSetting->site_slogan = $request->input('site_slogan');
        $siteSetting->site_phone_primary = $request->input('site_phone_primary');
        $siteSetting->site_phone_secondary = $request->input('site_phone_secondary');
        $siteSetting->mail_from_address = $request->input('mail_from_address');
        $siteSetting->mail_from_name = $request->input('mail_from_name');
        $siteSetting->mail_to_address = $request->input('mail_to_address');
        $siteSetting->mail_to_name = $request->input('mail_to_name');
        $siteSetting->default_country_id = $request->input('default_country_id');
        $siteSetting->country_specific_site = $request->input('country_specific_site');
		$siteSetting->default_currency_code = $request->input('default_currency_code');
        $siteSetting->site_street_address = $request->input('site_street_address');
        $siteSetting->site_google_map = $request->input('site_google_map');
        $siteSetting->mail_driver = $request->input('mail_driver');
        $siteSetting->mail_host = $request->input('mail_host');
        $siteSetting->mail_port = $request->input('mail_port');
        $siteSetting->mail_encryption = $request->input('mail_encryption');
        $siteSetting->mail_username = $request->input('mail_username');
        $siteSetting->mail_password = $request->input('mail_password');
        $siteSetting->mail_sendmail = $request->input('mail_sendmail');
        $siteSetting->mail_pretend = $request->input('mail_pretend');
        $siteSetting->mailgun_domain = $request->input('mailgun_domain');
        $siteSetting->mailgun_secret = $request->input('mailgun_secret');
        $siteSetting->mandrill_secret = $request->input('mandrill_secret');
        $siteSetting->sparkpost_secret = $request->input('sparkpost_secret');
        $siteSetting->ses_key = $request->input('ses_key');
        $siteSetting->ses_secret = $request->input('ses_secret');
        $siteSetting->ses_region = $request->input('ses_region');

        $siteSetting->facebook_address = $request->input('facebook_address');
        $siteSetting->twitter_address = $request->input('twitter_address');
        $siteSetting->google_plus_address = $request->input('google_plus_address');
        $siteSetting->youtube_address = $request->input('youtube_address');
        $siteSetting->instagram_address = $request->input('instagram_address');
        $siteSetting->pinterest_address = $request->input('pinterest_address');
        $siteSetting->linkedin_address = $request->input('linkedin_address');
        $siteSetting->tumblr_address = $request->input('tumblr_address');
        $siteSetting->flickr_address = $request->input('flickr_address');

        $siteSetting->index_page_below_top_employes_ad = $request->input('index_page_below_top_employes_ad');
        $siteSetting->above_footer_ad = $request->input('above_footer_ad');
        $siteSetting->dashboard_page_ad = $request->input('dashboard_page_ad');
        $siteSetting->cms_page_ad = $request->input('cms_page_ad');
        $siteSetting->listing_page_vertical_ad = $request->input('listing_page_vertical_ad');
        $siteSetting->listing_page_horizontal_ad = $request->input('listing_page_horizontal_ad');


        $siteSetting->nocaptcha_sitekey = $request->input('nocaptcha_sitekey');
        $siteSetting->nocaptcha_secret = $request->input('nocaptcha_secret');
        $siteSetting->facebook_app_id = $request->input('facebook_app_id');
        $siteSetting->facebeek_app_secret = $request->input('facebeek_app_secret');
        $siteSetting->google_app_id = $request->input('google_app_id');
        $siteSetting->google_app_secret = $request->input('google_app_secret');
        $siteSetting->twitter_app_id = $request->input('twitter_app_id');
        $siteSetting->twitter_app_secret = $request->input('twitter_app_secret');
        $siteSetting->paypal_account = $request->input('paypal_account');
        $siteSetting->paypal_client_id = $request->input('paypal_client_id');
        $siteSetting->paypal_secret = $request->input('paypal_secret');
        $siteSetting->paypal_live_sandbox = $request->input('paypal_live_sandbox');		
		$siteSetting->stripe_key = $request->input('stripe_key');
        $siteSetting->stripe_secret = $request->input('stripe_secret');
        $siteSetting->is_stripe_active = $request->input('is_stripe_active');
		$siteSetting->is_jobseeker_package_active = $request->input('is_jobseeker_package_active');
		
        $siteSetting->update();

        flash('Site Setting has been updated!')->success();
        return \Redirect::route('edit.site.setting');
    }

    private function deleteSiteSettingImage($id)
    {
        try {
            $siteSetting = SiteSetting::findOrFail($id);
            $image = $siteSetting->image;
            if (!empty($image)) {
                File::delete(ImgUploader::real_public_path() . 'sitesetting_images/thumb/' . $image);
                File::delete(ImgUploader::real_public_path() . 'sitesetting_images/mid/' . $image);
                File::delete(ImgUploader::real_public_path() . 'sitesetting_images/' . $image);
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

}
