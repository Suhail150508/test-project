<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StudentFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'student_id' => 'nullable',
            'degree_program' => 'required',
            'email_address' => 'required',
            'level_of_study' => 'required',
            'phone_number' => 'nullable',
            'question_one' => 'required',
            'question_two' => 'required',
            'question_three' => 'required',
        ];
    }
}
