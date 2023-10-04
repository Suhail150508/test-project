<?php


namespace App\Repositories;

use App\Interfaces\CccNewsInterface;
use App\Models\CccNews;

class CccNewsRepository extends BaseRepository implements CccNewsInterface
{
    public function __construct(CccNews $cccnews)
    {
        $this->model = $cccnews;
    }
}
