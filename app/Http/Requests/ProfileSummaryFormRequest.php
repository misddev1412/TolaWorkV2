<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileSummaryFormRequest extends Request
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
                    return [
                        "summary" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'summary.required' => 'Please enter Profile Summary.',
        ];
    }

}
