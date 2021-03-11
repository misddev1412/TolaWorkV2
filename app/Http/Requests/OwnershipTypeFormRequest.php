<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OwnershipTypeFormRequest extends Request
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
                    $ownership_type_unique = '';
                    if ($id > 0) {
                        $ownership_type_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "ownership_type" => "required", "is_default" => "required", "ownership_type_id" => "required_if:is_default,0", "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.', 'ownership_type.required' => 'Please enter Ownership Type.', 'is_default.required' => 'Is this Ownership Type default/fallback ?.', 'ownership_type_id.required_if' => 'Please select default/fallback Ownership Type.', 'is_active.required' => 'Is this Ownership Type active?',
        ];
    }

}
