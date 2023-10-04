<?php

namespace App\Repositories;

use App\Interfaces\NoticeEventInterface;
use App\Models\NoticeEvent;


class NoticeEventRepository extends BaseRepository implements NoticeEventInterface
{
    public function __construct(NoticeEvent $model)
    {
        $this->model = $model;
    }
}
