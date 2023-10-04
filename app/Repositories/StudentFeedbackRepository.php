<?php

namespace App\Repositories;

use App\Interfaces\StudentFeedbackInterface;
use App\Models\StudentFeedback;


class StudentFeedbackRepository extends BaseRepository implements StudentFeedbackInterface
{
    public function __construct(StudentFeedback $model)
    {
        $this->model = $model;
    }
}
