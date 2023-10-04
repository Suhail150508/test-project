<?php


namespace App\Repositories;

use App\Interfaces\JobCategoryInterface;
use App\Models\JobCategory;

class JobCategoryRepository extends BaseRepository implements JobCategoryInterface
{
    public function __construct(JobCategory $jobCategory)
    {
        $this->model = $jobCategory;
    }
}
