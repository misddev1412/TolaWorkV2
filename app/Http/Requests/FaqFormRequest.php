<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FaqFormRequest extends Request
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
        return [
            'faq_question' => 'required',
            'faq_answer' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'faq_question.required' => 'Please enter question.',
            'faq_answer.required' => 'Please enter answer.'
        ];
    }

}
