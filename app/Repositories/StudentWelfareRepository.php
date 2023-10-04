<?php

namespace App\Repositories;

use App\Interfaces\StudentWelfareInterface;
use App\Models\StudentWelfare;


class StudentWelfareRepository extends BaseRepository implements StudentWelfareInterface
{
    public function __construct(StudentWelfare $model)
    {
        $this->model = $model;
    }
}
