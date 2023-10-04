<?php


namespace App\Repositories;


use App\Interfaces\ClubMediaInterface;
use App\Models\ClubMedia;

class ClubMediaRepository extends BaseRepository implements ClubMediaInterface
{
    public function __construct(ClubMedia $model)
    {
        $this->model = $model;
    }
}
