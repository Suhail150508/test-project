<?php


namespace App\Repositories;

use App\Interfaces\GroupNewsFeedInterface;
use App\Models\GroupNewsFeed;

class GroupNewsFeedRepository extends BaseRepository implements GroupNewsFeedInterface
{
    public function __construct(GroupNewsFeed $groupNewsFeed)
    {
        $this->model = $groupNewsFeed;
    }
}
