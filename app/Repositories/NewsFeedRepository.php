<?php


namespace App\Repositories;

use App\Interfaces\NewsFeedInterface;
use App\Models\NewsFeed;

class NewsFeedRepository extends BaseRepository implements NewsFeedInterface
{
    public function __construct(NewsFeed $newsFeed)
    {
        $this->model = $newsFeed;
    }
}
