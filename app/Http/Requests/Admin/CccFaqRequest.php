<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CccFaqRequest extends FormRequest
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
            'question' => 'required|unique:ccc_faqs,question,'.@$this->ccc_faq->id,
            'answer' => 'required',
            'order' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'question' => trans('cccFaq.question'),
            'answer' => trans('cccFaq.answer'),
            'order' => trans('cccFaq.order'),
        ];
    }
}
