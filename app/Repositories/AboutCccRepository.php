<?php


namespace App\Repositories;

use App\Interfaces\AboutCccInterface;
use App\Models\AboutCcc;


class AboutCccRepository extends BaseRepository implements AboutCccInterface
{
    public function __construct(AboutCcc $aboutCcc)
    {
        $this->model = $aboutCcc;
    }
}
