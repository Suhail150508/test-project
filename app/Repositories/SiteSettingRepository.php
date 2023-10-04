<?php

namespace App\Repositories;

use App\Interfaces\SiteSettingInterface;
use App\Models\SiteSetting;


class SiteSettingRepository extends BaseRepository implements SiteSettingInterface
{
    public function __construct(SiteSetting $model)
    {
        $this->model = $model;
    }
}
