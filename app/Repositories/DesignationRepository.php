<?php


namespace App\Repositories;

use App\Models\Designation;
use App\Interfaces\DesignationInterface;


class DesignationRepository extends BaseRepository implements DesignationInterface
{
    public function __construct(Designation $model)
    {
        $this->model = $model;
    }
}
