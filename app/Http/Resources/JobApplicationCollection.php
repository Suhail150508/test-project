<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JobApplicationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($jobapplication) {
                return [
                    'id' => $jobapplication->id,
                    'user_id' => $jobapplication->user_id,
                    'first_name' => $jobapplication->resume->first_name,
                    'middle_name' => $jobapplication->resume->middle_name,
                    'last_name' => $jobapplication->resume->last_name,
                    'job_title' => $jobapplication->job_post->job_title,
                    'email' => $jobapplication->resume->email,
                    'gender' => $jobapplication->resume->gender,
                    'special_qualfication' => $jobapplication->resume->special_qualfication,
                    'cover_letter' => $jobapplication->cover_letter,
                    'file' => $jobapplication->file ?: null,
                    'job_post' => $jobapplication->job_post,
                    'job_status' => $jobapplication->job_status,
                    'applyed_date' => $jobapplication->applyed_date,
                    'withdraw_status' => $jobapplication->withdraw_status,
                    'withdraw_reson' => $jobapplication->withdraw_reson,
                ];
            })
        ];
    }
}
