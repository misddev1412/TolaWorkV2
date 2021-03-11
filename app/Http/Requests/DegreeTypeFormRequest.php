<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DegreeTypeFormRequest extends Request
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
                    $degree_type_unique = '';
                    if ($id > 0) {
                        $degree_type_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "degree_level_id" => "required", "degree_type" => "required|unique:degree_types$degree_type_unique", "is_default" => "required", "degree_type_id" => "required_if:is_default,0", "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.', 'degree_level_id.required' => 'Degree Level required.', 'degree_type.required' => 'Degree Type required.', 'is_default.required' => 'Is this Degree Type default?', 'degree_type_id.required_if' => 'Please select default/fallback Degree Type.', 'is_active.required' => 'Is this Degree Type active?',
        ];
    }

}
