<?php


namespace App\Repositories;

use App\Interfaces\CareerTipsInterface;
use App\Models\CareerTips;

class CareerTipsRepository extends BaseRepository implements CareerTipsInterface
{
    public function __construct(CareerTips $careerTips)
    {
        $this->model = $careerTips;
    }
}
