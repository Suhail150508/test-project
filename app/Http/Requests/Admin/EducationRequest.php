<?php

namespace App\Http\Requests\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EducationRequest extends FormRequest
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
        if ($this->input('job')) {
            return [
//                'graduation_type' => 'required',
                'jsc_examination' => 'required_with:jsc_board,jsc_roll,jsc_result,jsc_gpa,jsc_passing_year,jsc_institute',
                'jsc_board' => 'required_with:jsc_roll',
                'jsc_roll' => 'nullable|min:2|max:20',
                'jsc_gpa' => ['nullable', 'numeric', 'between:1.00,5.00'],

                'ssc_examination' => 'required_with:ssc_board,ssc_roll,ssc_result,ssc_gpa,ssc_subject,ssc_passing_year,ssc_institute',
                'ssc_board' => 'required_with:ssc_roll',
                'ssc_roll' => 'nullable|min:2|max:20',
                'ssc_gpa' => ['nullable', 'numeric', 'between:1.00,5.00'],

                'hsc_examination' => 'required_with:hsc_board,hsc_roll,hsc_result,hsc_gpa,hsc_subject,hsc_passing_year,hsc_institute',
                'hsc_board' => 'required_with:hsc_roll',
                'hsc_roll' => 'nullable|min:2|max:20',
                'hsc_gpa' => ['nullable', 'numeric', 'between:1.00,5.00'],

                'graduation_examination' => 'required_with:graduation_course_duration,graduation_result,graduation_gpa,graduation_subject,graduation_passing_year,graduation_institute',
                'graduation_gpa' => ['nullable', 'numeric', 'between:1.00,5.00'],

                'masters_examination' => 'required_with:masters_course_duration,masters_result,masters_gpa,masters_subject,masters_passing_year,masters_institute',
                'masters_gpa' => ['nullable', 'numeric', 'between:1.00,5.00'],
            ];
        } else {
            return [
                'school' => 'required',
                'degree' => 'required',
                'field_of_study' => 'required',
                'start_date' => 'required',
                'end_date' => 'nullable',
                'grade' => 'nullable',
                'activities' => 'nullable',
                'description' => 'nullable',
            ];
        }
    }
}
