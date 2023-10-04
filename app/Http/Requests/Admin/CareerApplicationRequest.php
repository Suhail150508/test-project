<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CareerApplicationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'brief_profile' => 'required',
            'present_salary' => 'required|integer',
            'expected_salary' => 'required|integer',
            'available_for' => 'required',
            'looking_for' => 'required',
        ];
    }
}
