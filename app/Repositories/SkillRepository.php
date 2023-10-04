<?php


namespace App\Repositories;

use App\Interfaces\SkillInterface;
use App\Models\Skill;

class SkillRepository extends BaseRepository implements SkillInterface
{
    public function __construct(Skill $model)
    {
        $this->model = $model;
    }
}
