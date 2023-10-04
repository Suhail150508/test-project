<?php


namespace App\Repositories;

use App\Interfaces\ClubInterface;
use App\Models\Club;

class ClubRepository extends BaseRepository implements ClubInterface
{
    public function __construct(Club $model)
    {
        $this->model = $model;
    }
}
