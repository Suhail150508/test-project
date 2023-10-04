<?php


namespace App\Repositories;

use App\Interfaces\ClubModeratorInterface;
use App\Models\ClubModerator;

class ClubModeratorRepository extends BaseRepository implements ClubModeratorInterface
{
    public function __construct(ClubModerator $model)
    {
        $this->model = $model;
    }
}
