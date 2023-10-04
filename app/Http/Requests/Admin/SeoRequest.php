<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SeoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->id;
        return [
            // 'site' => [
            //     'required',
            //     Rule::unique('seos')->where(function ($query) {
            //         $query->where('module', $this->module)
            //         ->where('page', $this->page);
            //     })->ignore($id, 'id')
            // ],

            // 'module' => [
            //     'required',
            //     Rule::unique('seos')->where(function ($query) {
            //         $query->where('site', $this->site)
            //         ->where('page', $this->page);
            //     })->ignore($id, 'id')
            // ],

            // 'page' => [
            //     'required',
            //     Rule::unique('seos')->where(function ($query) {
            //         $query->where('site', $this->site)
            //         ->where('module', $this->module);
            //     })->ignore($id, 'id')
            // ],

            'site' => [
                'required',
                Rule::unique('seos')->where(function ($query) {
                    $query->where('page_url', $this->page_url);
                })->ignore($id, 'id')
            ],

            'page_url' => [
                'required',
                Rule::unique('seos')->where(function ($query) {
                    $query->where('site', $this->site);
                })->ignore($id, 'id')
            ],

            'title' => 'required',
            'keywords' => 'required',
            'description' => 'required'
        ];
    }
}
