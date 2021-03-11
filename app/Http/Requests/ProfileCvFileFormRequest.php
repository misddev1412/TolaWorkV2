<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileCvFileFormRequest extends Request
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
                        "cv_file" => 'required|mimes:doc,docx,docm,zip,pdf',
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'cv_file.required' => 'Please select CV file.',
            'cv_file.mimes' => 'Only PDF and DOC files can be uploaded.',
        ];
    }

}
