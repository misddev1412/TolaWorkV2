<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SliderFormRequest extends Request
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
                    $slider_unique = '';
					$slider_image = 'required';
                    if ($id > 0) {
                        $slider_unique = ',id,' . $id;
						$slider_image = '';
                    }
                    return [
                        "id" => "",
						"lang" => "required",
						"slider_heading" => "required|unique:sliders$slider_unique",
						"slider_description" => "required",
						"slider_image" => $slider_image,
						"slider_link" => "required",
						"slider_link_text" => "required",
						"is_default" => "required",
						"slider_id" => "required_if:is_default,0",
						"is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.', 'slider.required' => 'Slider required.', 'is_default.required' => 'Is this Slider default?', 'slider_id.required_if' => 'Please select default/fallback Slider.', 'is_active.required' => 'Is this Slider active?',
        ];
    }

}
