<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileCvFormRequest extends Request
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
                    $cv_file = ($id > 0) ? '' : 'required|';
                    return [
                        "title" => "required",
                        "is_default" => "required",
                        "cv_file" => $cv_file . 'mimes:doc,docx,docm,zip,pdf',
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'title.required' => 'Please enter CV title.',
            'is_default.required' => 'Is this CV default?',
            'cv_file.required' => 'Please select CV file.',
            'cv_file.mimes' => 'Only PDF and DOC files can be uploaded.',
        ];
    }

}
