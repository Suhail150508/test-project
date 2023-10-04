<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Brian2694\Toastr\Facades\Toastr;

class CountryRequest extends FormRequest
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
            'name' => 'required|nullable|unique:countries,name,'.@$this->country->id,
            'bn_name' => 'nullable|unique:countries,bn_name,'.@$this->country->id,
            'code' => 'sometimes|unique:countries,code,'.@$this->country->id,
        ];
    }

    public function attributes()
    {
        return [
            'code' => trans('country.code'),
        ];
    }

}
