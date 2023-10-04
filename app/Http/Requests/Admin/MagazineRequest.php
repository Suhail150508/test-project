<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MagazineRequest extends FormRequest
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


    public function rules()
    {
        return [
            "name" => 'nullable|min:3|max:100|unique:magazines,name'.@$this->magazine->id,
            "title" => "required|min:5|max:200",
            "sort_description" => "required|min:5",
            "description" => "required|min:5",
            "about" => "required|min:5|max:1000",
           "publish_date" =>  "required",
        ];
    }
}
