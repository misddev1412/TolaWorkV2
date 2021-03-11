<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MaritalStatusFormRequest extends Request
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
                    $marital_status_unique = '';
                    if ($id > 0) {
                        $marital_status_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "marital_status" => "required", "is_default" => "required", "marital_status_id" => "required_if:is_default,0", "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.', 'marital_status.required' => 'Please enter Marital Status.', 'is_default.required' => 'Is this Marital Status default/fallback ?.', 'marital_status_id.required_if' => 'Please select default/fallback Marital Status.', 'is_active.required' => 'Is this Marital Status active?',
        ];
    }

}
