<?php


namespace App\Repositories;

use App\Interfaces\NewsInterface;
use App\Models\News;

class NewsRepository extends BaseRepository implements NewsInterface
{
    public function __construct(News $news)
    {
        $this->model = $news;
    }
}