<?php

namespace App\Repositories;

use App\Interfaces\BannerInterface;
use App\Models\Banner;


class BannerRepository extends BaseRepository implements BannerInterface
{
    public function __construct(Banner $model)
    {
        $this->model = $model;
    }
}
