<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ResultTypeFormRequest extends Request
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
                    $result_type_unique = '';
                    if ($id > 0) {
                        $result_type_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "result_type" => "required", "is_default" => "required", "result_type_id" => "required_if:is_default,0", "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.', 'result_type.required' => 'Please enter Result Type.', 'is_default.required' => 'Is this Result Type default/fallback ?.', 'result_type_id.required_if' => 'Please select default/fallback Result Type.', 'is_active.required' => 'Is this Result Type active?',
        ];
    }

}
