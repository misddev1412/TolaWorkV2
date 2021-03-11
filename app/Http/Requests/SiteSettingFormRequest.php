<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SiteSettingFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'site_name' => 'required|max:100',
            'site_slogan' => 'required|max:150',
            'image' => 'image',
            'site_phone_primary' => 'required|max:20',
            'site_phone_secondary' => 'max:20',
            'mail_host' => 'max:100',
            'mail_port' => 'max:5',
            'mail_from_address' => 'required|max:100',
            'mail_from_name' => 'required|max:100',
            'mail_to_address' => 'required|max:100',
            'mail_to_name' => 'required|max:100',
            'default_country_id' => 'required|max:150',
            'default_currency_code' => 'required|max:4',
            'site_street_address' => 'required|max:250',
            'mail_encryption' => 'max:10',
            'mail_username' => 'max:100',
            'mail_password' => 'max:100',
            'mail_sendmail' => 'max:50',
            'mail_pretend' => 'max:50',
            'mailgun_domain' => 'max:100',
            'mailgun_secret' => 'max:100',
            'mandrill_secret' => 'max:100',
            'sparkpost_secret' => 'max:100',
            'ses_key' => 'max:100',
            'ses_secret' => 'max:100',
            'ses_region' => 'max:100',
        ];
    }

    public function messages()
    {
        return [
            'site_name.required' => 'Please enter site name.',
            'site_slogan.required' => 'Please enter site slogan.',
            'image.required' => 'Please select image.',
            'site_phone_primary.required' => 'Please enter site primary phone number.',
            'mail_from_address.required' => 'Please enter site email from address.',
            'mail_from_name.required' => 'Please enter site email from name.',
            'mail_to_address.required' => 'Please enter site email to address.',
            'mail_to_name.required' => 'Please enter site email to name.',
            'default_country_id.required' => 'Please enter site default country.',
            'default_currency_code.required' => 'Please enter site default currency code.',
            'site_street_address.required' => 'Please enter site street address.',
            'image.image' => 'Only images can be uploaded.',
            'site_name.max' => 'The site name may not be more than 100 characters.',
            'site_slogan.max' => 'The site slogan may not be more than 150 characters.',
            'site_phone_primary.max' => 'The site primary phone may not be more than 20 characters.',
            'site_phone_secondary.max' => 'The site secondary phone may not be more than 20 characters.',
            'default_country.max' => 'The site default country may not be more than 150 characters.',
            'default_currency_code.max' => 'The site default currency code may not be more than 4 characters.',
            'site_street_address.max' => 'The site street address may not be more than 250 characters.',
            'mail_host.max' => 'The mail host may not be more than 100 characters.',
            'mail_port.max' => 'The mail port may not be more than 5 characters.',
            'mail_from_address.max' => 'The mail from address may not be more than 100 characters.',
            'mail_from_name.max' => 'The mail from name may not be more than 100 characters.',
            'mail_to_address.max' => 'The mail to address may not be more than 100 characters.',
            'mail_to_name.max' => 'The mail to name may not be more than 100 characters.',
            'mail_encryption.max' => 'The mail encryption may not be more than 10 characters.',
            'mail_username.max' => 'The mail username may not be more than 100 characters.',
            'mail_password.max' => 'The mail password may not be more than 100 characters.',
            'mail_sendmail.max' => 'The mail sendmail may not be more than 100 characters.',
            'mail_pretend.max' => 'The mail pretend may not be more than 50 characters.',
            'mailgun_domain.max' => 'The mailgun domain may not be more than 100 characters.',
            'mailgun_secret.max' => 'The mailgun secret may not be more than 100 characters.',
            'mandrill_secret.max' => 'The mandrill secret may not be more than 100 characters.',
            'sparkpost_secret.max' => 'The sparkpost secret may not be more than 100 characters.',
            'ses_key.max' => 'The AMAZON SES key may not be more than 100 characters.',
            'ses_secret.max' => 'The AMAZON SES secret may not be more than 100 characters.',
            'ses_region.max' => 'The AMAZON SES region may not be more than 100 characters.',
        ];
    }

}
