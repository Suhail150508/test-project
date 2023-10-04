<?php


namespace App\Repositories;

use App\Interfaces\JobBlogInterface;
use App\Models\JobBlog;


class JobBlogRepository extends BaseRepository implements JobBlogInterface
{
    public function __construct(JobBlog $model)
    {
        $this->model = $model;
    }
}
