<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LanguageFormRequest extends Request
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
                    $language_unique = '';
                    if ($id > 0) {
                        $language_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "native" => "required", "iso_code" => "required", "is_active" => "required", "is_rtl" => "required", "is_default" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please enter language.', 'native.required' => 'Native required.', 'iso_code.required' => 'ISO Code required.', 'is_active.required' => 'Is this Language active?', 'is_rtl.required' => 'Is this Language RTL?', 'is_default.required' => 'Is this language default?',
        ];
    }

}
