<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\JobPortalUser;

class JobPortalUserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($resume) {
                return [
                    'id' => $resume->id,
                    'user_id' => $resume->user_id,
                    'first_name' => $resume->first_name,
                    'major_title' => $resume->major_title,
                    'minor_title' => $resume->minor_title,
                    'convocation_year' => $resume->convocation_year,
                    'middle_name' => $resume->middle_name,
                    'last_name' => $resume->last_name,
                    'gender' => $resume->gender,
                    'blood_group' => $resume->blood_group,
                    'special_qualfication' => $resume->special_qualfication,
                    'email' => $resume->email,
                    'ewu_id_no' => $resume->ewu_id_no,
                    'user_rating' => $resume->userRating?$resume->userRating:"",
                    'career_application' => $resume->careerApplication?$resume->careerApplication:" ",
                    'present_salary' => $resume->career_application?$resume->career_application->present_salary:" ",
                    'profile_image' => $resume->resumeImage ? $resume->resumeImage->source : null,
                    'resume_cv' => $resume->resume_cv ? $resume->resume_cv : '',
                    'resume_video' => $resume->resume_video ? $resume->resume_video : '',
                ];
            }),

        ];
    }
}

