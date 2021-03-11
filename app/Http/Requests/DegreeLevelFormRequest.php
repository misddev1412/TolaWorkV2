<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DegreeLevelFormRequest extends Request
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
                    $degree_level_unique = '';
                    if ($id > 0) {
                        $degree_level_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "degree_level" => "required|unique:degree_levels$degree_level_unique", "is_default" => "required", "degree_level_id" => "required_if:is_default,0", "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.', 'degree_level.required' => 'Degree Level required.', 'is_default.required' => 'Is this Degree Level default?', 'degree_level_id.required_if' => 'Please select default/fallback Degree Level.', 'is_active.required' => 'Is this Degree Level active?',
        ];
    }

}
