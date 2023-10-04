<?php

namespace App\Http\Requests\Admin;

use App\Models\Employee;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'name' => 'nullable|string',
            // 'bn_name' => 'required',
            'company_name' => 'required',
            'year_of_stablishment' => 'required',
            'industry_type' => 'required',
            'company_size' => 'nullable',
            'division_id' => 'required',
            'district_id' => 'nullable',
            'thana_id' => 'nullable',
            'password' => 'required',
            // 'username' => 'required|unique:users,username,'.@$this->job_employeer->id,
            'email' => 'required|email|unique:employees,email,'.@$this->job_employeer->id,
            'contact_number' => 'required|unique:employees,contact_number,'.@$this->job_employeer->id,
            'business' => 'required',

            // 'fire_station_id' => 'nullable|integer',
            // 'old_pin' => 'required|string|min:4|max:8|unique:employees,old_pin,'.@$this->employee->id,
            // 'new_pin' => 'nullable|string|min:4|max:8|unique:employees,new_pin,'.@$this->employee->id,
            // 'religion' => 'nullable|in:'.implode(',',array_keys(Employee::religions())),
            // 'gender' => 'nullable|in:'.implode(',',array_keys(Employee::genders())),
            // 'id_card' => 'nullable|unique:employees,id_card,'.@$this->employee->id,
            // 'nid' => 'nullable|unique:employees,nid,'.@$this->employee->id,
            // 'birth_date' => 'nullable|date_format:d-m-Y',
            // 'profile_picture' => 'nullable',
            // 'signature' => 'nullable',
            // 'mobile' => 'nullable|unique:employees,mobile,'.@$this->employee->id,
            // 'email' => 'nullable|email|unique:employees,email,'.@$this->employee->id,
        ];
    }

    public function attributes()
    {
        return [
            // 'designation_id' => trans('employee.designation_id'),
            // 'fire_station_id' => trans('employee.fire_station_id'),
            // 'old_pin' => trans('employee.old_pin'),
            // 'new_pin' => trans('employee.new_pin'),
            // 'religion' => trans('employee.religion'),
            // 'gender' => trans('employee.gender'),
            // 'id_card' => trans('employee.id_card'),
            // 'nid' => trans('employee.nid'),
            // 'birth_date' => trans('employee.birth_date'),
            // 'profile_picture' => trans('employee.profile_picture'),
            // 'signature' => trans('employee.signature'),
            // 'mobile' => trans('employee.mobile'),
            // 'email' => trans('employee.email'),
        ];
    }
}
