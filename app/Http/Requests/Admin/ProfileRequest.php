<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'bn_name' => 'required',
            'mobile' => 'nullable|unique:users,mobile,'.@$this->id,
            'signature' => 'nullable|mimes:jpg,png,jpeg',
            'password' => 'nullable|min:6',
            'password_confirm' => 'required_with:password,true|same:password',
        ];
    }

    public function attributes()
    {
        return [
            'signature' => trans('user.signature'),
            'mobile' => trans('user.label_mobile'),
        ];
    }
}
