<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmailToFriendFormRequest extends Request
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
            'friend_name' => 'required|max:100',
            'friend_email' => 'required|email|max:100',
            'your_name' => 'required|max:100',
            'your_email' => 'required|email|max:100',
            'listing_url' => 'required|url',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'friend_name.required' => 'Friend\'s Name is required',
            'friend_email.required' => 'Friend\'s E-mail address is required',
            'friend_email.email' => 'Friend\'s Valid e-mail address is required',
            'your_name.required' => 'Your name is required',
            'your_email.required' => 'Your email address is required',
            'your_email.email' => 'Your Valid e-mail address is required',
            'listing_url.required' => 'Listing url is required',
            'listing_url.url' => 'Listing url must be a valid URL',
        ];
    }

}
