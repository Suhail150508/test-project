<?php


namespace App\Repositories;

use App\Interfaces\ThanaInterface;
use App\Interfaces\TrainingInterface;
use App\Models\Thana;
use App\Models\Training;

class TrainingRepository extends BaseRepository implements TrainingInterface
{
    public function __construct(Training $model)
    {
        $this->model = $model;
    }
}
