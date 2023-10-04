<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ContentRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    /*public function __construct(Request $request)
    {
        if ($request->method() == 'PATCH'){
            $request->request->add(['updated_by' => \Auth::id()]);
        } else if ($request->method() == 'POST') {
            $request->request->add(['created_by' => \Auth::id()]);
        }

    }*/
    public function rules()
    {
        return [
            'name' => 'nullable|unique:contents,name,'.@$this->route('content')->id,
        ];
    }
}
