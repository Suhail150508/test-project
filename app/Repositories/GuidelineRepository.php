<?php

namespace App\Repositories;

use App\Interfaces\GuidelineInterface;
use App\Models\Guideline;

class GuidelineRepository extends BaseRepository implements GuidelineInterface
{
    public function __construct(Guideline $model)
    {
        $this->model = $model;
    }
}
