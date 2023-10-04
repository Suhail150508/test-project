<?php


namespace App\Repositories;

use App\Interfaces\DivisionInterface;
use App\Models\Division;


class DivisionRepository extends BaseRepository implements DivisionInterface
{
    public function __construct(Division $model)
    {
        $this->model = $model;
    }
}
