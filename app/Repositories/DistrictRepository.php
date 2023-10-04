<?php


namespace App\Repositories;

use App\Interfaces\DistrictInterface;
use App\Models\District;


class DistrictRepository extends BaseRepository implements DistrictInterface
{
    public function __construct(District $district)
    {
        $this->model = $district;
    }
}
