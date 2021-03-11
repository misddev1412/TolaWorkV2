<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompanyFormRequest extends Request
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
        switch ($this->method()) {
            case 'PUT':
            case 'POST': {
                    $id = (int) $this->input('id', 0);
                    $unique_id = ($id > 0) ? ',' . $id : '';
                    $password = ($id > 0) ? "" : "required";
                    $logo = ($id > 0) ? "" : "required";
                    return [
                        "id" => "",
                        "name" => "required",
                        "email" => "required",
                        "password" => $password,
                        "ceo" => "required",
                        "industry_id" => "required",
                        "ownership_type_id" => "required",
                        "description" => "required",
                        "location" => "required",
                        //"map" => "required",
                        "no_of_offices" => "required",
                        "website" => "required|url",
                        "no_of_employees" => "required",
                        "established_in" => "required",
                        "fax" => "required",
                        "phone" => "required",
                        "logo" => $logo,
                        "country_id" => "required",
                        "state_id" => "required",
                        "city_id" => "required",
                        "is_active" => "required",
                        "is_featured" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Company Name is required',
            'email.required' => 'Company Email is required',
            'password.required' => 'Password is required',
            'ceo.required' => 'Company\'s CEO name is required',
            'industry_id.required' => 'Please select Industry',
            'ownership_type_id.required' => 'Please select Ownership Type',
            'description.required' => 'Company Details required',
            'location.required' => 'Company location required',
            'map.required' => 'Company Google Map location required',
            'no_of_offices.required' => 'Number of offices required',
            'website.required' => 'Company website required',
            'website.url' => 'Complete url of company website required',
            'no_of_employees.required' => 'Number of employees required',
            'established_in.required' => 'Company established in year required',
            'fax.required' => 'Fax number required',
            'phone.required' => 'Phone number required',
            'logo.required' => 'Company logo is required',
            'country_id.required' => 'Please select country',
            'state_id.required' => 'Please select state',
            'city_id.required' => 'Please select city',
            'is_active.required' => 'Is this Company Acive?',
            'is_featured.required' => 'Is this Company featured?',
        ];
    }

}
