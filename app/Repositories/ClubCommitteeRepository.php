<?php


namespace App\Repositories;

use App\Interfaces\ClubCommitteeInterface;
use App\Models\ClubCommittee;

class ClubCommitteeRepository extends BaseRepository implements ClubCommitteeInterface
{
    public function __construct(ClubCommittee $model)
    {
        $this->model = $model;
    }
}
