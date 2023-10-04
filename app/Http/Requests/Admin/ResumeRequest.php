<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ResumeRequest extends FormRequest
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
            "first_name"=>"required",
            "middle_name"=>"required",
            "last_name"=>"required",
            "birthdate"=>"required",
            "gender"=>"required",
            "religion"=>"required",
            "marital_status"=>"required",
            'national_id' => 'nullable|unique:resumes,national_id,'.@$this->resume->id,
            "passport_number"=>'nullable|unique:resumes,passport_number,'.@$this->resume->id,
            "passport_issue_date"=>"nullable",
            "personal_number"=>"required",
            "office_number"=>"nullable",
            "email"=>'required|unique:resumes,email,'.@$this->resume->id,
            // "blood_group"=>"required",
            // "career_summary"=>"required",
            // "special_qualfication"=>"required",
            // "keyword"=>"required",
        

        ];
    }
}
