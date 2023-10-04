<?php


namespace App\Repositories;

use App\Interfaces\AlumniInterface;
use App\Models\Alumni;


class AlumniRepository extends BaseRepository implements AlumniInterface
{
    public function __construct(Alumni $alumni)
    {
        $this->model = $alumni;
    }
}
