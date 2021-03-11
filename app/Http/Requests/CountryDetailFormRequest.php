<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CountryDetailFormRequest extends Request
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
                        'id' => '', 'country_id' => '', 'sort_name' => 'required', 'phone_code' => 'required', 'currency' => 'required', 'code' => 'required', 'symbol' => 'required', 'thousand_separator' => 'required', 'decimal_separator' => 'required',
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'sort_name.required' => 'TextName Stub required', 'phone_code.required' => 'TextName Stub required', 'currency.required' => 'TextName Stub required', 'code.required' => 'TextName Stub required', 'symbol.required' => 'TextName Stub required', 'thousand_separator.required' => 'TextName Stub required', 'decimal_separator.required' => 'TextName Stub required',
        ];
    }

}
