<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AlumniRequest extends FormRequest
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
        // alumni create
        if ($this->input('valueFrom') === 'alumni_create') {
            // alumni create from admin panel
            if (request()->auth_id){
                return [
                    // basic info
                    'ewu_id_no' => 'required|unique:alumnis,ewu_id_no',
                    'title' => 'nullable',
                    'first_name' => 'required',
                    'middle_name' => 'nullable',
                    'last_name' => 'nullable',
                    'nid' => 'nullable',
                    'dob' => 'nullable',
                    'gender' => 'nullable',
                    'blood_group' => 'nullable',
                    'about' => 'nullable',
                    'image' => 'nullable',

                    // contact info
                    'personal_email' => 'required',
                    'university_email' => 'required',
                    'company_email' => 'nullable',
                    'personal_contact_number' => 'nullable|digits:11|unique:alumnis,personal_contact_number',
                    'official_contact_number' => 'nullable|digits:11',
                    'facebook_profile_link' => 'nullable',
                    'linkedin_profile_link' => 'nullable',

                    // address info
                    'country_id' => 'nullable',
                    'division_id' => 'nullable',
                    'district_id' => 'nullable',

                    // education info
                    'department_id' => 'nullable',
                    'department_name' => 'required',
                    'program_id' => 'nullable',
                    'program_type' => 'required',
                    'program_name' => 'required',
                    'passing_year' => 'nullable',
                    'passing_semester' => 'nullable',
                    'convocation_year' => 'nullable',

                    // professional info
                    'organization' => 'nullable',
                    'designation_department' => 'nullable',
                    'occupation' => 'nullable',
                    'doj' => 'nullable',
                    'experience' => 'nullable',
                    'industry' => 'nullable',
                ];
            }

            // alumni register from alumni portal
            else{
                return [
                    // basic info
                    'ewu_id_no' => 'required|unique:alumnis,ewu_id_no',
                    'title' => 'nullable',
                    'first_name' => 'required',
                    'middle_name' => 'nullable',
                    'last_name' => 'nullable',
                    'nid' => 'nullable|unique:alumnis,nid',
                    'dob' => 'nullable',
                    'gender' => 'nullable',
                    'blood_group' => 'nullable',
                    'about' => 'nullable',
                    'image' => 'nullable',

                    // contact info
                    'personal_email' => 'required',
                    'university_email' => 'required',
                    'company_email' => 'nullable',
                    'personal_contact_number' => 'required|digits:11',
                    'official_contact_number' => 'nullable|digits:11',
                    'facebook_profile_link' => 'nullable',
                    'linkedin_profile_link' => 'nullable',

                    // address info
                    'country_id' => 'nullable',
                    'division_id' => 'nullable',
                    'district_id' => 'nullable',

                    // education info
                    'department_id' => 'nullable',
                    'department_name' => 'required',
                    'program_id' => 'nullable',
                    'program_type' => 'required',
                    'program_name' => 'required',
                    'passing_year' => 'nullable',
                    'passing_semester' => 'nullable',
                    'convocation_year' => 'nullable',

                    // professional info
                    'organization' => 'nullable',
                    'designation_department' => 'nullable',
                    'occupation' => 'nullable',
                    'doj' => 'nullable',
                    'experience' => 'nullable',
                    'industry' => 'nullable',

                    // login info
                    'email' => 'required|email|unique:users,email',
                    'username' => 'required|unique:users,username',
                    'password' => 'required',
                ];
            }

        }

        // manual alumni create
        if ($this->input('valueFrom') === 'manual_alumni_create') {
            return [
                // basic info
                'ewu_id_no' => 'required|unique:alumnis,ewu_id_no',
                'title' => 'nullable',
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'nullable',
                'nid' => 'nullable|unique:alumnis,nid',
                'dob' => 'nullable',
                'gender' => 'nullable',
                'blood_group' => 'nullable',
                'about' => 'nullable',
                'image' => 'nullable',

                // contact info
                'personal_email' => 'required',
                'university_email' => 'required',
                'company_email' => 'nullable',
                'personal_contact_number' => 'required|digits:11',
                'official_contact_number' => 'nullable|digits:11',
                'facebook_profile_link' => 'nullable',
                'linkedin_profile_link' => 'nullable',

                // address info
                'country_id' => 'nullable',
                'division_id' => 'nullable',
                'district_id' => 'nullable',

                // education info
                'department_id' => 'nullable',
                'department_name' => 'required',
                'program_id' => 'nullable',
                'program_type' => 'required',
                'program_name' => 'required',
                'passing_year' => 'nullable',
                'passing_semester' => 'nullable',
                'convocation_year' => 'nullable',

                // professional info
                'organization' => 'nullable',
                'designation_department' => 'nullable',
                'occupation' => 'nullable',
                'doj' => 'nullable',
                'experience' => 'nullable',
                'industry' => 'nullable',

                // login info
                'email' => 'required|email|unique:users,email',
                'username' => 'required|unique:users,username',
                'password' => 'required',
            ];
        }

        // alumni update from admin panel
        if ($this->input('valueFrom') === 'alumni_update') {
            return [
                // basic info
                'ewu_id_no' => 'required|unique:alumnis,ewu_id_no,' . @$this->alumnus->id,
                'title' => 'nullable',
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'nullable',
                'nid' => 'nullable',
                'dob' => 'nullable',
                'gender' => 'nullable',
                'blood_group' => 'nullable',
                'about' => 'nullable',
                'image' => 'nullable',

                // contact info
                'personal_email' => 'required',
                'university_email' => 'required',
                'company_email' => 'nullable',
                'personal_contact_number' => 'nullable|digits:11',
                'official_contact_number' => 'nullable|digits:11',
                'facebook_profile_link' => 'nullable',
                'linkedin_profile_link' => 'nullable',

                // address info
                'country_id' => 'nullable',
                'division_id' => 'nullable',
                'district_id' => 'nullable',

                // education info
                'department_id' => 'nullable',
                'department_name' => 'required',
                'program_id' => 'nullable',
                'program_type' => 'required',
                'program_name' => 'required',
                'passing_year' => 'nullable',
                'passing_semester' => 'nullable',
                'convocation_year' => 'nullable',

                // professional info
                'organization' => 'nullable',
                'designation_department' => 'nullable',
                'occupation' => 'nullable',
                'doj' => 'nullable',
                'experience' => 'nullable',
                'industry' => 'nullable',

                // login info
                'email' => 'required|email|unique:users,email,' . @$this->alumnus->user_id,
                'username' => 'required|unique:users,username,' . @$this->alumnus->user_id,
                'current_password' => 'nullable|required_with:password,true|min:6',
                'password' => 'nullable|required_with:current_password,true|min:6',

                // 'password' => 'nullable|required_with:new_password,true|min:6',
                // 'new_password' => 'nullable|required_with:password,true|min:6',
                // 'password_confirm' => 'required_with:new_password,true|same:new_password',
            ];
        }

        // alumni background image update from alumni profile
        if ($this->input('valueFrom') === 'background_image') {
            return [
                'background_image' => 'required',
            ];
        }

        // alumni profile image update from alumni profile
        if ($this->input('valueFrom') === 'profile_image') {
            return [
                'profile_image' => 'required',
            ];
        }

        // alumni basic info update from alumni profile
        if ($this->input('valueFrom') === 'basic_info') {
            return [
                'ewu_id_no' => 'required|unique:alumnis,ewu_id_no,' . @$this->alumnus->id,
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'nullable',
                'dob' => 'nullable',
                'blood_group' => 'nullable',
                'country_id' => 'nullable',
                'district_id' => 'nullable',
            ];
        }

        // alumni contact info update from alumni profile
        if ($this->input('valueFrom') === 'contact_info') {
            return [
                'contact_number' => 'nullable|digits:11',
                'personal_email' => 'required',
                'university_email' => 'required',
                'company_email' => 'nullable',
                'facebook_profile_link' => 'nullable',
                'linkedin_profile_link' => 'nullable',
            ];
        }

        // alumni skill info update from alumni profile
        if ($this->input('valueFrom') === 'skill_info') {
            return [
                'skill_ids' => 'nullable',
            ];
        }

        // alumni achievement info update from alumni profile
        if ($this->input('valueFrom') === 'achievement_info') {
            return [
                'skill_ids' => 'nullable',
            ];
        }

        // alumni about info update from alumni profile
        if ($this->input('valueFrom') === 'about_info') {
            return [
                'about' => 'nullable',
            ];
        }

        // alumni username & email info update from alumni profile
        if ($this->input('valueFrom') === 'username_email_info') {
            return [
                'email' => 'nullable|email|unique:users,email,' . @$this->alumnus->user_id,
                'username' => 'nullable|unique:users,username,' . @$this->alumnus->user_id,
            ];
        }

        // alumni password info update from alumni profile
        if ($this->input('valueFrom') === 'password_info') {
            return [
                'current_password' => 'required|min:6',
                'new_password' => 'required|min:6',
                'password_confirm' => 'required_with:new_password,true|same:new_password',
            ];
        }

        // alumni rating info from admin panel
        if ($this->input('valueFrom') === 'rating_info') {
            return [
                'presentation_skill_rating' => 'nullable',
                'english_skill_rating' => 'nullable',
                'communication_skill_rating' => 'nullable',
            ];
        }

        // alumni feature checkbox info from admin panel
        if ($this->input('valueFrom') === 'feature_checkbox_info') {
            return [
                'is_feature' => 'nullable',
            ];
        }

        // alumni active inactive checkbox info from admin panel
        if ($this->input('valueFrom') === 'alumni_active_inactive_checkbox_info') {
            return [
                'status' => 'in:Active,Inactive',
            ];
        }

        // add approve remark from admin panel
        if ($this->input('valueFrom') === 'add_approve_remark') {
            return [
                'approve_remark' => 'nullable',
            ];
        }

        // add approve remark from admin panel
        if ($this->input('valueFrom') === 'add_reject_remark') {
            return [
                'reject_remark' => 'nullable',
            ];
        }
    }
}
