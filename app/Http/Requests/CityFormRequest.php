<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CityFormRequest extends Request
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
                    $city_unique = '';
                    if ($id > 0) {
                        $city_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "state_id" => "required", "city" => "required", "is_default" => "required", "city_id" => "required_if:is_default,0", "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.', 'state_id.required' => 'Please select State.', 'city.required' => 'Please enter City Name.', 'is_default.required' => 'Is this city default/fallback ?.', 'city_id.required_if' => 'Please select default/fallback City.', 'is_active.required' => 'Is this City active?',
        ];
    }

}
