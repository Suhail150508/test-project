<?php


namespace App\Repositories;

use App\Interfaces\ClubSliderInterface;
use App\Models\ClubSlider;

class ClubSliderRepository extends BaseRepository implements ClubSliderInterface
{
    public function __construct(ClubSlider $model)
    {
        $this->model = $model;
    }
}
