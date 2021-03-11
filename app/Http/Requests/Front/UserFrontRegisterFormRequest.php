<?php

namespace App\Http\Requests\Front;

use Auth;
use App\Http\Requests\Request;

class UserFrontRegisterFormRequest extends Request
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
            'first_name' => 'required|max:80',
            'middle_name' => 'max:80',
            'last_name' => 'required|max:80',
            'email' => 'required|unique:users,email|email|max:100',
            'password' => 'required|confirmed|min:6|max:50',
			'terms_of_use' => 'required',
			'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('First Name is required'),
'middle_name.required' => __('Middle Name is required'),
'last_name.required' => __('Last Name is required'),
'email.required' => __('Email is required'),
'email.email' => __('The email must be a valid email address'),
'email.unique' => __('This Email has already been taken'),
'password.required' => __('Password is required'),
'password.min' => __('The password should be more than 3 characters long'),
'terms_of_use.required' => __('Please accept terms of use'),
'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
'g-recaptcha-response.captcha' => __('Captcha error! try again later or contact site admin'),
        ];
    }

}
