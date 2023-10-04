<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|unique:roles,name,'.@$this->role->id,
            'bn_name' => 'required|unique:roles,bn_name,'.@$this->role->id,
            'status' => 'required',
        ];
    }
}
