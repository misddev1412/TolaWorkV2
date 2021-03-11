<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;

class ApplyJobFormRequest extends Request
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
                    return [
                        "cv_id" => "required",
                        "current_salary" => "required|max:11",
                        "expected_salary" => "required|max:11",
                        "salary_currency" => "required|max:5",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'cv_id.required' => __('Please select CV'),
            'current_salary.required' => __('Please enter current salary'),
            'expected_salary.required' => __('Please enter expected salary'),
            'salary_currency.required' => __('Please enter salary currency'),
        ];
    }

}
