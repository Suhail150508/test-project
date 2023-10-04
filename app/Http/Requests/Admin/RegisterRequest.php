<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function withValidator(Validator $validator)
    {
        $messages = $validator->messages();

        foreach ($messages->all() as $message)
        {
            Toastr::error($message, trans('settings.failed'), ['timeOut' => 10000]);
        }

        return $validator->errors()->all();
    }

    public function rules()
    {
        return [
            'role_id' => 'required|exists:App\Models\Role,id',
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'mobile' => 'nullable|numeric|unique:users,mobile',
            'phone' => 'nullable|numeric|unique:users,phone',
            'nid' => 'nullable|unique:users,nid',
            'dob' => 'nullable',
            'address' => 'nullable',
            'is_admin' => 'nullable',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ];
    }
}
