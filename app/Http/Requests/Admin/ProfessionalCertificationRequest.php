<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfessionalCertificationRequest extends FormRequest
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
                'title' => 'nullable|min:3|max:300|unique:professional_certifications,title,'.@$this->professional_certification->id,
                // "description" => "required|min:3",
                "organization" => "required",
                "duration" => "required|numeric",
            ];
    }
}
