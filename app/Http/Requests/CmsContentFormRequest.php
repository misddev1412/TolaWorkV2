<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CmsContentFormRequest extends Request
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
        $id = (int) $this->input('id', 0);
        $id_str = '';
        if ($id > 0) {
            $id_str = ',' . $id;
        }
        return [
            'page_id' => 'required',
            'page_title' => 'required',
            'page_content' => 'required',
            'lang' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'page_id.required' => 'Please select page.',
            'page_title.required' => 'Please enter page title.',
            'page_content.required' => 'Please enter page content.',
            'lang.required' => 'Please select language.',
        ];
    }

}
