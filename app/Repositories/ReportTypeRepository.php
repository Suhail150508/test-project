<?php


namespace App\Repositories;

use App\Interfaces\ReportTypeInterface;
use App\Models\ReportType;

class ReportTypeRepository extends BaseRepository implements ReportTypeInterface
{
    public function __construct(ReportType $model)
    {
        $this->model = $model;
    }
}
