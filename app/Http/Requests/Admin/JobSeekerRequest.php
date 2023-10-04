<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class JobSeekerRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    protected function withValidator(Validator $validator)
    {
        $messages = $validator->messages();

        foreach ($messages->all() as $message)
        {
            Toastr::error($message, trans('settings.failed'), ['timeOut' => 10000]);
        }

        return $validator->errors()->all();
    }

    public function rules()
    {
        return [

            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'blood_group' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            // 'department_id' => 'required',
            'major_id' => 'required',
            'minor_id' => 'required',
            'cgpa' => 'required|numeric',
            'passing_year' => 'required|numeric',
            'ssc_result' => 'required|numeric',
            'hsc_result' => 'required|numeric',
            // 'skill_ids' => 'required',
            // 'co_curricular_activity_ids' => 'required',
            // 'training_ids' => 'required',
            // 'workshop_ids' => 'required',
            // 'achievement_ids' => 'required',
            'experience_year' => 'required|numeric',
            'father_name' => 'required',
            'father_occupation' => 'required',
            'mother_name' => 'required',
            'mother_occupation' => 'required',
            'designation' => 'required',
            'current_organization' => 'required',
            'personal_contact' => 'required',
            'office_contact' => 'required',
            'job_application_status' => 'required',  
            'linkedin_profile_link' => 'required',
            'fb_profile_link' => 'required',
            'email' => 'required|email|unique:job_seekers,email,'.@$this->jobSeeker->id,
           

            // 'profile_objective' => 'required',
            // 'ewu_id_no' => 'required',
            // 'first_name' => 'required|min:2',
            // 'last_name' => 'required|min:2',
            // 'email' => 'required|email|unique:job_seekers,email,'.@$this->jobSeeker->id,
            // 'gender' => 'required',
            // 'department_id' => 'required',
            // 'job_interested_area_ids' => 'required',
            // 'skill_ids' => 'required',
            // 'professional_interest_ids' => 'required',
            // 'personal_contact_number' => 'required|digits:11|unique:job_seekers,personal_contact_number,'.@$this->jobSeeker->id,
            // 'contact_number_office' => 'nullable|digits:11|unique:job_seekers,contact_number_office,'.@$this->jobSeeker->id,

        ];
    }

    public function attributes()
    {
        return [
            'profile_objective' => trans('job_seeker.profile_objective'),
            'ewu_id_no' => trans('job_seeker.ewu_id_no'),
            'first_name' => trans('job_seeker.first_name'),
            'last_name' => trans('job_seeker.last_name'),
            'email' => trans('job_seeker.email'),
            'gender' => trans('job_seeker.gender'),
            'department_id' => trans('job_seeker.department_id'),
            'job_interested_area_ids' => trans('job_seeker.job_interested_area_ids'),
            'skill_ids' => trans('job_seeker.skill_ids'),
            'professional_interest_ids' => trans('job_seeker.professional_interest_ids'),
            'personal_contact_number' => trans('job_seeker.personal_contact_number'),
            'contact_number_office' => trans('job_seeker.contact_number_office')
        ];
    }
}
