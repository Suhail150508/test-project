<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobProfileRequest extends FormRequest
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
        if (request()->auth_id){
            return [
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'nullable',
                'blood_group' => 'nullable',
                'date_of_birth' => 'nullable',
                'personal_number' => 'required',
                'office_number' => 'nullable',
                'nid' => 'required|unique:users,nid,'.@$this->user->id,
                'address' => 'required',
                'gender' => 'required',
                'ewu_id_no' => 'required',
                'employment_status' => 'required',
            ];
        } else{
            return [
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'nullable',
                'blood_group' => 'nullable',
                'date_of_birth' => 'nullable',
                'personal_number' => 'required',
                'office_number' => 'nullable',
                'nid' => 'required|unique:users,nid,'.@$this->user->id,
                'address' => 'required',
                'email' => 'required|email|unique:users,email,'.@$this->user->id,
                'username' => 'required|unique:users,username,'.@$this->user->id,
                'password' => 'required',
                'gender' => 'required',
                'ewu_id_no' => 'required',
                'employment_status' => 'required',
            ];
        }


    }
}
