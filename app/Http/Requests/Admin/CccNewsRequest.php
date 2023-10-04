<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CccNewsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'max:2000'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'published' => ['required']
        ];
    }
}
