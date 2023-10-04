<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
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
            'title' => 'required|unique:trainings,title,'.@$this->training->id,
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => trans('training.title'),
            'duration_in_days' => trans('training.duration_in_days'),
        ];
    }
}
