<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required',
            'route_name' => 'nullable|unique:menus,route_name,'.@$this->menu->id,
            'order_by' => 'required',
            'status' => 'required',
        ];
    }
}
