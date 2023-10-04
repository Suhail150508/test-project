<?php

namespace App\Repositories;

use App\Interfaces\CompanyDetailInterface;
use App\Models\CompanyDetail;

class CompanyDetailRepository extends BaseRepository implements CompanyDetailInterface
{
    public function __construct(CompanyDetail $model)
    {
        $this->model = $model;
    }
}
