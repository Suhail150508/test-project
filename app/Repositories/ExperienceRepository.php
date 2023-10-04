<?php


namespace App\Repositories;

use App\Interfaces\ExperienceInterface;
use App\Models\Experience;

class ExperienceRepository extends BaseRepository implements ExperienceInterface
{
    public function __construct(Experience $experience)
    {
        $this->model = $experience;
    }
}
