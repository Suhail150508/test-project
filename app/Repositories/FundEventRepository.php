<?php

namespace App\Repositories;

use App\Interfaces\FundEventInterface;
use App\Models\FundEvent;

class FundEventRepository extends BaseRepository implements FundEventInterface
{
    public function __construct(FundEvent $model)
    {
        $this->model = $model;
    }
}
