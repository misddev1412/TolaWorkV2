<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminFormRequest extends Request
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
        $pass_required = 'required|min:3|max:100';
        $id_str = '';
        if ($id > 0) {
            $id_str = ',' . $id;
            $pass_required = '';
        }
        //echo $id_str;exit;
        return [
            'name' => 'required|unique:admins,name' . $id_str . '|max:50',
            'email' => 'required|unique:admins,email' . $id_str . '|email|max:100',
            'password' => $pass_required,
            'role_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'The name has already been taken.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'email.required' => 'Email is required',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This Email has already been taken.',
            'name.max' => 'The email may not be greater than 100 characters.',
            'password.required' => 'Password is required',
            'password.min' => 'The password may be more than 3 characters long.',
            'password.max' => 'The password may not be greater than 100 characters.',
            'role_id.required' => 'Please Select Role',
        ];
    }

}
