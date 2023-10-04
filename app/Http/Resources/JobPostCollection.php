<?php

namespace App\Http\Resources;
use App\Models\JobCategory;
use App\Models\JobSubCategory;
use Carbon\Carbon;


use Illuminate\Http\Resources\Json\ResourceCollection;

class JobPostCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($jobpost) {
                return [
                    'id' => $jobpost->id,
                    'job_category_id' => $jobpost->job_category_id,
                    'job_sub_category_id' => $jobpost->job_sub_category_id,
                    // 'division_id' => $jobpost->address->division_id,
                    'headline' => $jobpost->headline,
                    'job_title' => $jobpost->job_title,
                    'job_details' => $jobpost->job_details,
                    'job_code' => $jobpost->job_code,
                    'company_name' => $jobpost->company_name,
                    'company_details' => $jobpost->company_details,
                    'company_address' => $jobpost->company_address,
                    'no_of_vacancies' => $jobpost->no_of_vacancies,
                    'employment_status' => $jobpost->employment_status,
                    'resume_receiver_email' => $jobpost->resume_receiver_email,
                    'job_responsibilities' => $jobpost->job_responsibilities,
                    'min_salary' => $jobpost->min_salary,
                    'job_workplace' => $jobpost->job_workplace,
                    'max_salary' => $jobpost->max_salary,
                    'festival_bonuses' => $jobpost->festival_bonuses,
                    'gender' => $jobpost->gender,
                    'min_experience' => $jobpost->min_experience,
                    'min_academic_level' => $jobpost->min_academic_level,
                    'status' => $jobpost->status,
                    'application_publish_date' => $jobpost->job_publish_date,
                    'application_deadline' => $jobpost->job_deadline,
                    'current_date' => Carbon::now()->format('Y-m-d'),
                    'is_approved' => $jobpost->is_approved,
                    'job_applications' => $jobpost->job_applications->count(),
                    'logo' => $jobpost->websiteLogo?$jobpost->websiteLogo->source:"",
                    'document' => $jobpost->document ? $jobpost->document->source : "",
                ];
            }),
            'jobcategories' => JobCategory::query()->get(),
            'jobsubcategories' => JobSubCategory::query()->get(),
        ];
    }
}
