<?php


namespace App\Repositories;

use App\Interfaces\ContentInterface;
use App\Models\Content;


class ContentRepository extends BaseRepository implements ContentInterface
{
    public function __construct(Content $model)
    {
        $this->model = $model;
    }
}
