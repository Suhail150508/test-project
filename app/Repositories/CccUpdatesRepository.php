<?php


namespace App\Repositories;

use App\Interfaces\CccUpdatesInterface;
use App\Models\CccUpdates;

class CccUpdatesRepository extends BaseRepository implements CccUpdatesInterface
{
    public function __construct(CccUpdates $model)
    {
        $this->model = $model;
    }
}
