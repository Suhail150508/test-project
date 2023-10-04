<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'department_code' => 'required|unique:departments,department_code,'.@$this->department->id,
            'title' => 'required|unique:departments,title,'.@$this->department->id,
            'description' => 'required',

        ];
    }

    public function attributes()
    {
        return [
            'department_code' => trans('department.code'),
            'title' => trans('department.title'),
        ];
    }

}
