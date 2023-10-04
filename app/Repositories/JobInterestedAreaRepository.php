<?php


namespace App\Repositories;

use App\Interfaces\JobInterestedAreaInterface;
use App\Models\JobInterestedArea;

class JobInterestedAreaRepository extends BaseRepository implements JobInterestedAreaInterface
{
    public function __construct(JobInterestedArea $model)
    {
        $this->model = $model;
    }
}
