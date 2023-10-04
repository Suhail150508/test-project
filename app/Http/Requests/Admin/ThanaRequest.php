<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ThanaRequest extends FormRequest
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
            'name' => 'nullable|unique:thanas,name,'.@$this->thana->id,
            'bn_name' => 'required|unique:thanas,bn_name,'.@$this->thana->id,
            'division_id' => 'required',
            'district_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'district_id' => trans('fire_station.district_id'),
            'division_id' => trans('district.code'),
        ];
    }
}
