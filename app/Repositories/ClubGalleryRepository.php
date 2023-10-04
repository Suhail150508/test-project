<?php

namespace App\Repositories;

use App\Interfaces\ClubGalleryInterface;
use App\Models\ClubGallery;

class ClubGalleryRepository extends BaseRepository implements ClubGalleryInterface
{
    public function __construct(ClubGallery $model)
    {
        $this->model = $model;
    }
}
