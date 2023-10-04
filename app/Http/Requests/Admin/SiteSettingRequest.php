<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SiteSettingRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'contact_number'=>'required',
            'contact_email'=>'required',
            'address'=>'required',
        ];
    }
}
