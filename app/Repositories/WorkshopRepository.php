<?php

namespace App\Repositories;

use App\Interfaces\WorkshopInterface;
use App\Models\Workshop;

class WorkshopRepository extends BaseRepository implements WorkshopInterface
{
    public function __construct(Workshop $model)
    {
        $this->model = $model;
    }
}
