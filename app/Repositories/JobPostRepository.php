<?php


namespace App\Repositories;

use App\Interfaces\JobPostInterface;
use App\Models\JobPost;

class JobPostRepository extends BaseRepository implements JobPostInterface
{
    public function __construct(JobPost $model)
    {
        $this->model = $model;
    }
}