<?php


namespace App\Repositories;

use App\Interfaces\JobSubCategoryInterface;
use App\Models\JobSubCategory;

class JobSubCategoryRepository extends BaseRepository implements JobSubCategoryInterface
{
    public function __construct(JobSubCategory $JobSubCategory)
    {
        $this->model = $JobSubCategory;
    }
}
