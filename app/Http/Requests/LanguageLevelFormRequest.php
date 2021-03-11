<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LanguageLevelFormRequest extends Request
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
                    $language_level_unique = '';
                    if ($id > 0) {
                        $language_level_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "language_level" => "required", "is_default" => "required", "language_level_id" => "required_if:is_default,0", "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.', 'language_level.required' => 'Please enter Language Level.', 'is_default.required' => 'Is this Language Level default/fallback ?.', 'language_level_id.required_if' => 'Please select default/fallback Language Level.', 'is_active.required' => 'Is this Language Level active?',
        ];
    }

}
