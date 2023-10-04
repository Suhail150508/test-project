<?php


namespace App\Repositories;

use App\Interfaces\SliderInterface;
use App\Models\Slider;

class SliderRepository extends BaseRepository implements SliderInterface
{
    public function __construct(Slider $model)
    {
        $this->model = $model;
    }
}
