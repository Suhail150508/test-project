<?php

namespace App\Repositories;

use App\Interfaces\CoCurricularActivityInterface;
use App\Models\CoCurricularActivity;


class CoCurricularActivityRepository extends BaseRepository implements CoCurricularActivityInterface
{
    public function __construct(CoCurricularActivity $model)
    {
        $this->model = $model;
    }
}
