<?php

namespace App\Repositories;

use App\Interfaces\MagazineInterface;
use App\Models\Magazine;


class MagazineRepository extends BaseRepository implements MagazineInterface
{
    public function __construct(Magazine $model)
    {
        $this->model = $model;
    }
}
