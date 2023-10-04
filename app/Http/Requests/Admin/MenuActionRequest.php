<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuActionRequest extends FormRequest
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
            'icon' => 'nullable',
            'slug' => 'required|unique:menu_actions,slug,'.@$this->menu_action->id,
            'order_by' => 'required',
            'status' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'icon' => trans('menu_action/attribute.icon'),
            'district_id' => trans('fire_station.district_id'),
            'slug' => trans('menu_action/attribute.slug'),
            'order_by' => trans('menu_action/attribute.order_by'),
        ];
    }


}
