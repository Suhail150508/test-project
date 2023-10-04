<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DesignationRequest extends FormRequest
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
            'name' => 'required|unique:designations,name,'.@$this->designation->id,
            'bn_name' => 'nullable|regex:/^[অ-ঔক-য়ৠঁংঃৎঅ-ঁ ]+$/|unique:designations,bn_name,'.@$this->designation->id,
        ];
    }
}
