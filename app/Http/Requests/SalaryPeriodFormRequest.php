<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SalaryPeriodFormRequest extends Request
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
                    $salary_period_unique = '';
                    if ($id > 0) {
                        $salary_period_unique = ',id,' . $id;
                    }
                    return [
                        'salary_period' => 'required|unique:salary_periods' . $salary_period_unique,
                        'salary_period_id' => 'required_if:is_default,0',
                        'is_active' => 'required',
                        'is_default' => 'required',
                        'lang' => 'required',
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'salary_period.required' => 'Please enter salary period.',
            'salary_period_id.required_if' => 'Please select default/fallback salary period.',
            'is_default.required' => 'Is this salary period default?',
            'is_active.required' => 'Please select status.',
            'lang.required' => 'Please select language.',
        ];
    }

}
