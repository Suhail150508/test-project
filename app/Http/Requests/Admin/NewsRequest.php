<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
//            'title' => 'required|unique:news,title,'.@$this->news->id,
//            'order_place' => 'required|unique:news,order_place,'.@$this->news->id,
        ];
    }

    public function attributes()
    {
        return [
            'title' => trans('news.title'),
        ];
    }
}
