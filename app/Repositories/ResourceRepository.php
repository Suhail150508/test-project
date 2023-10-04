<?php

namespace App\Repositories;

use App\Interfaces\ResourceInterface;
use App\Models\Resource;

class ResourceRepository extends BaseRepository implements ResourceInterface
{
    public function __construct(Resource $model)
    {
        $this->model = $model;
    }
}
