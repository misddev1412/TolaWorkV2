<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CareerLevelFormRequest extends Request
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
                    $career_level_unique = '';
                    if ($id > 0) {
                        $career_level_unique = ',id,' . $id;
                    }
                    return [
                        'career_level' => "required|unique:career_levels$career_level_unique",
                        'career_level_id' => 'required_if:is_default,0',
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
            'career_level.required' => 'Please enter Career Level.',
            'career_level_id.required_if' => 'Please select default/fallback Career Level.',
            'is_default.required' => 'Is this Career Level default?',
            'is_active.required' => 'Please select status.',
            'lang.required' => 'Please select language.',
        ];
    }

}
