<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GenderFormRequest extends Request
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
                    $gender_unique = '';
                    if ($id > 0) {
                        $gender_unique = ',id,' . $id;
                    }
                    return [
                        'gender' => 'required|unique:genders' . $gender_unique,
                        'gender_id' => 'required_if:is_default,0',
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
            'gender.required' => 'Please enter Gender.',
            'gender_id.required_if' => 'Please select default/fallback Gender.',
            'is_default.required' => 'Is this Gender default?',
            'is_active.required' => 'Please select status.',
            'lang.required' => 'Please select language.',
        ];
    }

}
