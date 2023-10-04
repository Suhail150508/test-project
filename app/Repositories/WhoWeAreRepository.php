<?php


namespace App\Repositories;

use App\Interfaces\WhoWeAreInterface;
use App\Models\WhoWeAre;

class WhoWeAreRepository extends BaseRepository implements WhoWeAreInterface
{
    public function __construct(WhoWeAre $model)
    {
        $this->model = $model;
    }
}
