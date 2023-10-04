<?php


namespace App\Repositories;

use App\Interfaces\JobSeekerInterface;
use App\Models\JobSeeker;

class JobSeekerRepository extends BaseRepository implements JobSeekerInterface
{
    public function __construct(JobSeeker $model)
    {
        $this->model = $model;
    }
}
