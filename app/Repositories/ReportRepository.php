<?php


namespace App\Repositories;

use App\Interfaces\ReportInterface;
use App\Models\Report;

class ReportRepository extends BaseRepository implements ReportInterface
{
    public function __construct(Report $model)
    {
        $this->model = $model;
    }
}
