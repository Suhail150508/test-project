<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AlumniCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($alumni) {
                return [
                    'id' => $alumni->id,
                    // basic info
                    'ewu_id_no' => $alumni->ewu_id_no,
                    'title' => $alumni->title,
                    'first_name' => $alumni->first_name,
                    'middle_name' => $alumni->middle_name,
                    'last_name' => $alumni->last_name,
                    'nid' => $alumni->nid,
                    'dob' => $alumni->dob,
                    'gender' => $alumni->gender,
                    'blood_group' => $alumni->blood_group,
                    'about' => $alumni->about,
                    'profile_image' => $alumni->alumni ? $alumni->alumni->source : null,
                    'background_image' => $alumni->backgroundImage ? $alumni->backgroundImage->source : null,

                    // contact info
                    'personal_email' => $alumni->personal_email,
                    'university_email' => $alumni->university_email,
                    'company_email' => $alumni->company_email,
                    'personal_contact_number' => $alumni->personal_contact_number,
                    'official_contact_number' => '',
                    'facebook_profile_link' => $alumni->facebook_profile_link,
                    'linkedin_profile_link' => $alumni->linkedin_profile_link,

                    // address info
                    'country' => $alumni->country,
                    'country_id' => $alumni->country ? $alumni->country->id : '',
                    'division' => $alumni->division,
                    'division_id' => $alumni->division ? $alumni->division->id : '',
                    'district' => $alumni->district,
                    'district_id' => $alumni->district ? $alumni->district->id : '',

                    // education info
                    'department' => $alumni->department,
                    'department_name' => $alumni->department_name,
                    'department_id' => $alumni->department ? $alumni->department->id : '',
                    'program' => $alumni->program,
                    'passing_year' => $alumni->passing_year,
                    'passing_semister' => '',
                    'convocation_year' => $alumni->convocation_year,
                    'education' => $alumni->educations,

                    // professional info
                    'organization' => $alumni->organization,
                    'designation_department' => $alumni->designation_department,
                    'occupation' => $alumni->occupation,
                    'doj' => $alumni->doj,
                    'industry' => $alumni->industry,
                    'experience' => $alumni->experiences,

                    // others info
                    'user' => $alumni->user,
                    'achievement' => $alumni->achievements,
                    'skill' => $alumni->skills,
                    'presentation_skill_rating' => $alumni->presentation_skill_rating,
                    'communication_skill_rating' => $alumni->communication_skill_rating,
                    'english_skill_rating' => $alumni->english_skill_rating,
                    'block_status' => $alumni->block_status,
                    'status' => $alumni->status,
                    'is_feature' => $alumni->is_feature,
                    'reg_type' => $alumni->reg_type,
                    'reg_status' => $alumni->reg_status,
                    'approve_remark' => $alumni->approve_remark,
                    'reject_remark' => $alumni->reject_remark,

                    // login info
                    'username' =>$alumni->user ? $alumni->user->username : '',
                    'auth_email' =>$alumni->user ? $alumni->user->email : '',
                ];
            })
        ];
    }
}
