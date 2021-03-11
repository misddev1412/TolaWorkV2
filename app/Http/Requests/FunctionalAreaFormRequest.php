<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FunctionalAreaFormRequest extends Request
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
                    $functional_area_unique = '';
                    if ($id > 0) {
                        $functional_area_unique = ',id,' . $id;
                    }
                    return [
                        'functional_area' => 'required|unique:functional_areas' . $functional_area_unique,
                        'functional_area_id' => 'required_if:is_default,0',
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
            'functional_area.required' => 'Please enter Functional Area.',
            'functional_area_id.required_if' => 'Please select default/fallback Functional Area.',
            'is_default.required' => 'Is this Functional Area default?',
            'is_active.required' => 'Please select status.',
            'lang.required' => 'Please select language.',
        ];
    }

}
