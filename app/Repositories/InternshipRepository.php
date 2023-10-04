<?php

namespace App\Repositories;

use App\Interfaces\InternshipInterface;
use App\Models\Internship;


class InternshipRepository extends BaseRepository implements InternshipInterface
{
    public function __construct(Internship $model)
    {
        $this->model = $model;
    }
}
