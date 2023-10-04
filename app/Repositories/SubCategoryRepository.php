<?php


namespace App\Repositories;

use App\Interfaces\SubCategoryInterface;
use App\Models\SubCategory;

class SubCategoryRepository extends BaseRepository implements SubCategoryInterface
{
    public function __construct(SubCategory $model)
    {
        $this->model = $model;
    }
}
