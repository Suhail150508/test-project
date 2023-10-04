<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'bn_name' => 'nullable',
            'username' => 'required|unique:users,username,'.@$this->user->id,
            'email' => 'nullable|unique:users,email,'.@$this->user->id,
            // 'mobile' => 'nullable|unique:users,mobile,'.@$this->user->id,
            'role_id' => 'required',
            'status' => 'required',
            'password' => 'required|min:6',
            // 'password_confirm' => 'required_with:password,true|same:password',
        ];
    }

    public function attributes()
    {
        return [
            'employer_id' => trans('user.label_employer_id'),
        ];
    }
}
