<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmploymentHistoryRequest extends FormRequest
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
            "EmploymentHistory.*.company_name"=>"required",
            "EmploymentHistory.*.company_business"=>"required",
            "EmploymentHistory.*.designation"=>"required",
            "EmploymentHistory.*.department"=>"required",
            "EmploymentHistory.*.start_date"=>"required",
            "EmploymentHistory.*.todate"=>"required",
            "EmploymentHistory.*.responsibilities"=>"required",
            "EmploymentHistory.*.skill_ids"=>"required",
            "EmploymentHistory.*.duration"=>"required",
            "EmploymentHistory.*.job_location"=>"required",
        ];
    }
}
