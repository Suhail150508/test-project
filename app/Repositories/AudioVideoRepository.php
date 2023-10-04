<?php

namespace App\Repositories;

use App\Interfaces\AudioVideoInterface;
use App\Models\AudioVideo;


class AudioVideoRepository extends BaseRepository implements AudioVideoInterface
{
    public function __construct(AudioVideo $model)
    {
        $this->model = $model;
    }
}
