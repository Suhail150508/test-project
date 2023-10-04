<?php

namespace App\Repositories;

use App\Interfaces\AchievementInterface;
use App\Models\Achievement;


class AchievementRepository extends BaseRepository implements AchievementInterface
{
    public function __construct(Achievement $model)
    {
        $this->model = $model;
    }
}
