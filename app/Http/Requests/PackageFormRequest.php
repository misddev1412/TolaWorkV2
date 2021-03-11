<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PackageFormRequest extends Request
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
                    return [
                        "package_title" => "required",
                        "package_price" => "required",
                        "package_num_days" => "required",
                        "package_num_listings" => "required",
                        "package_for" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'package_title.required' => 'Package Title is required',
            'package_price.required' => 'Package price is required',
            'package_num_days.required' => 'Package num days required',
            'package_num_listings.required' => 'Package num listings required',
            'package_for.required' => 'Please select package for',
        ];
    }

}
