<?php

namespace App\Repositories;

use App\Interfaces\MajorMinorInterface;
use App\Models\MajorMinor;


class MajorMinorRepository extends BaseRepository implements MajorMinorInterface
{
    public function __construct(MajorMinor $model)
    {
        $this->model = $model;
    }
}
