<?php


namespace App\Repositories;

use App\Interfaces\ThanaInterface;
use App\Models\Thana;

class ThanaRepository extends BaseRepository implements ThanaInterface
{
    public function __construct(Thana $thana)
    {
        $this->model = $thana;
    }
}
