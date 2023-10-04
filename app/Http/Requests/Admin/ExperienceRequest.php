<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ExperienceRequest extends FormRequest
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
            'title' => 'required',
            'employment_type' => 'nullable',
            'company_name' => 'required',
            'country_id' => 'nullable',
            'division_id' => 'nullable',
            'district_id' => 'nullable',
            'location_type' => 'nullable',
            'start_date' => 'required',
            'end_date' => 'nullable',
            'description' => 'nullable',
        ];
    }
}
