<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
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
            'headline' => 'required',
            'job_title' => 'required|unique:job_posts,job_title,' . @$this->job_post->id,
            'company_name' => "required",
            'job_details' => "required",
            'job_deadline' => "required",

            // "job_category_id" => "required",
            // "job_sub_category_id" => "required",
            // 'job_title' => 'required|unique:job_posts,job_title,'.@$this->job_post->id,
            // // 'job_code' => 'required|unique:job_posts,job_code,'.@$this->job_post->id,
            // "company_name" => "required",
            // // "company_logo" => "required",
            // "company_details" => "required",
            // "company_address" => "required",
            // "no_of_vacancies" => "required|numeric",
            // "employment_status" => "required",
            // "resume_receiver_email" => "required|email",
            // "job_responsibilities" => "required",
            // "job_workplace" => "required",
            // "min_salary" => "required|numeric",
            // "max_salary" => "required|numeric",
            // "festival_bonuses" => "required|numeric",
            // "gender" => "required",
            // // "min_experience" => "required",
            // "job_level" => "required",
            // "job_context" => "required",
            // "job_responsibilities" => "required",
            // // "status" => "required",
            // "job_publish_date" => "required",
            // "job_deadline" => "required",
        ];
    }
}
