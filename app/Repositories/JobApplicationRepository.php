<?php

namespace App\Repositories;

use App\Interfaces\JobApplicationInterface;
use App\Models\UserApplication;


class JobApplicationRepository extends BaseRepository implements JobApplicationInterface
{
    public function __construct(UserApplication $model)
    {
        $this->model = $model;
    }
}
