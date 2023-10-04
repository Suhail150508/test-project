<?php

namespace App\Repositories;

use App\Interfaces\InterestInterface;
use App\Models\Interest;


class InterestRepository extends BaseRepository implements InterestInterface
{
    public function __construct(Interest $model)
    {
        $this->model = $model;
    }
}
