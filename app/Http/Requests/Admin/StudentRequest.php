<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


class StudentRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'userInfos.name' => 'required',
            'userInfos.username' => 'required|unique:users,username,' . @$this->student->user->id,
            'userInfos.mobile' => 'required|digits:11|unique:users,mobile,' . @$this->student->user->id,
            'userInfos.phone_no' => 'required',
            'userInfos.nid' => 'required|unique:users,nid,' . @$this->student->user->id,
            'userInfos.dob' => 'required',
            'userInfos.email' => 'required|email|unique:users,email,' . @$this->student->user->id,
            'userInfos.password' => 'required',

            "ewu_id_no" => "required",
            "skill_ids" => "required",
            "profile_objective" => "required",
            "first_name" => "required",
            "middle_name" => "required",
            "last_name" => "required",
            'email' => 'required|unique:students,email,'.@$this->student->id,
            'personal_contact_number' => 'required|unique:students,personal_contact_number,'.@$this->student->id,
            "dob" => "required",
        ];
    }
}
