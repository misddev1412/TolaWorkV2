<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class JobTitleFormRequest extends Request
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
                    $job_title_unique = '';
                    if ($id > 0) {
                        $job_title_unique = ',id,' . $id;
                    }
                    return [
                        'job_title' => 'required|unique:job_titles' . $job_title_unique,
                        'job_title_id' => 'required_if:is_default,0',
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
            'job_title.required' => 'Please enter Job Title.',
            'job_title_id.required_if' => 'Please select default/fallback Job Title.',
            'is_default.required' => 'Is this Job Title default?',
            'is_active.required' => 'Please select status.',
            'lang.required' => 'Please select language.',
        ];
    }

}
