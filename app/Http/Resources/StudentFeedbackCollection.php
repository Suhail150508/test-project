<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentFeedbackCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($student_feedback) {
                return [
                    'id' => $student_feedback->id,
                    'name' => $student_feedback->name,
                    'student_id' => $student_feedback->student_id,
                    'degree_program' => $student_feedback->degree_program,
                    'email_address' => $student_feedback->email_address,
                    'level_of_study' => $student_feedback->level_of_study,
                    'phone_number' => $student_feedback->phone_number,
                    'question_one' => $student_feedback->question_one,
                    'question_two' => $student_feedback->question_two,
                    'question_three' => $student_feedback->question_three,
                ];
            }),
        ];
    }
}
