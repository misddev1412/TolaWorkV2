<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MajorSubjectFormRequest extends Request
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
                    $major_subject_unique = '';
                    if ($id > 0) {
                        $major_subject_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "major_subject" => "required|unique:major_subjects$major_subject_unique", "is_default" => "required", "major_subject_id" => "required_if:is_default,0", "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.', 'major_subject.required' => 'Major Subject required.', 'is_default.required' => 'Is this Major Subject default?', 'major_subject_id.required_if' => 'Please select default/fallback Major Subject.', 'is_active.required' => 'Is this Major Subject active?',
        ];
    }

}
