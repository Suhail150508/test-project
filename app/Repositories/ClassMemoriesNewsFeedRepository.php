<?php


namespace App\Repositories;

use App\Interfaces\ClassMemoriesNewsFeedInterface;
use App\Models\ClassMemoriesNewsFeed;

class ClassMemoriesNewsFeedRepository extends BaseRepository implements ClassMemoriesNewsFeedInterface
{
    public function __construct(ClassMemoriesNewsFeed $classMemoriesNewsFeed)
    {
        $this->model = $classMemoriesNewsFeed;
    }
}
