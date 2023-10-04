<?php

namespace App\Http\Resources;

use App\Models\Endorsement;
use App\Http\Resources\ExperienceResource;
use App\Http\Resources\ExperienceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class AlumniResource extends JsonResource
{
    public function toArray($request)
    {
        if($request->place == 'header') {
            return [
                'id' => $this->id,
                'ewu_id_no' => $this->ewu_id_no,
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'blood_group' => $this->blood_group,
                'organization' => $this->organization,
                'designation_department' => $this->designation_department,
                'occupation' => $this->occupation,
                'doj' => $this->doj,
                'profile_image' => $this->alumni ? $this->alumni->source : null,
                'background_image' => $this->backgroundImage ? $this->backgroundImage->source : null,

                'name' => $this->user ? $this->user->name : null,
                'username' => $this->user ? $this->user->username : null,
                'auth_email' => $this->user ? $this->user->email : null,
            ];
        } else {
            return [
                "alumni" => [
                    'id' => $this->id,
                    // basic info
                    'ewu_id_no' => $this->ewu_id_no,
                    'title' => $this->title,
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'last_name' => $this->last_name,
                    'nid' => $this->nid,
                    'dob' => $this->dob,
                    'gender' => $this->gender,
                    'blood_group' => $this->blood_group,
                    'about' => $this->about,
                    'profile_image' => $this->alumni ? $this->alumni->source : null,
                    'background_image' => $this->backgroundImage ? $this->backgroundImage->source : null,

                    // contact number
                    'personal_email' => $this->personal_email,
                    'university_email' => $this->university_email,
                    'company_email' => $this->company_email,
                    'personal_contact_number' => $this->personal_contact_number,
                    'official_contact_number' => '',
                    'facebook_profile_link' => $this->facebook_profile_link,
                    'linkedin_profile_link' => $this->linkedin_profile_link,

                    // address info
                    'country' => $this->country,
                    'country_id' => $this->country ? $this->country->id : '',
                    'division' => $this->division,
                    'division_id' => $this->division ? $this->division->id : '',
                    'district' => $this->district,
                    'district_id' => $this->district ? $this->district->id : '',

                    // educational info
                    'department' => $this->department ? $this->department : '',
                    'department_name' => $this->department_name ? $this->department_name : '',
                    'department_id' => $this->department ? $this->department->id : '',
                    'program_type' => $this->program_type,
                    'program_name' => $this->program_name,
                    'program' => $this->program,
                    'passing_year' => $this->passing_year,
                    'passing_semister' => '',
                    'passing_semester' => $this->passing_semester,
                    'convocation_year' => $this->convocation_year,
                    'educations' => $this->educations,

                    // professional info
                    'organization' => $this->organization,
                    'designation_department' => $this->designation_department,
                    'occupation' => $this->occupation,
                    'doj' => $this->doj,
                    'industry' => $this->industry,
                    // 'experiences' => $this->experiences,
                    'experiences' => new ExperienceCollection($this->experiences),

                    // others info
                    'achievements' => $this->achievements,
                    'skills' => $this->skills(),
                    'presentation_skill_rating' => $this->presentation_skill_rating,
                    'communication_skill_rating' => $this->communication_skill_rating,
                    'english_skill_rating' => $this->english_skill_rating,
                    'block_status' => $this->block_status,
                    'status' => $this->status,
                    'is_feature' => $this->is_feature,

                    // login info
                    'username' => $this->user->username,
                    'auth_email' => $this->user->email,
                    'email' => $this->user->email,
                    'password' => $this->user->password,
                ],
                "message" => trans($request->update ? 'alumni.updated' : 'alumni.created'),
                "wrongCurrentPassword" => $request->errorMsgForCurrentPassword,
            ];
        }
    }

    private function skills()
    {
        $skills = $this->skills;
        foreach ($skills as $key => $skill) {
            $endorsement_count = Endorsement::where('user_id', $this->id)->where('activity_type', get_class($skill))->where('activity_id', $skill->id)->count();
            $skill['endorsement_count'] = $endorsement_count;
            $endorsers = Endorsement::with('user', 'user.alumni')->where('user_id', $this->id)->where('activity_type', get_class($skill))->where('activity_id', $skill->id)->get();
            $skill['endorsers'] = $endorsers;
        }

        return $skills;
    }
}
