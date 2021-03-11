<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class JobExperienceFormRequest extends Request
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
                    $job_experience_unique = '';
                    if ($id > 0) {
                        $job_experience_unique = ',id,' . $id;
                    }
                    return [
                        'job_experience' => 'required|unique:job_experiences' . $job_experience_unique,
                        'job_experience_id' => 'required_if:is_default,0',
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
            'job_experience.required' => 'Please enter Job Experience.',
            'job_experience_id.required_if' => 'Please select default/fallback Job Experience.',
            'is_default.required' => 'Is this Job Experience default?',
            'is_active.required' => 'Please select status.',
            'lang.required' => 'Please select language.',
        ];
    }

}
