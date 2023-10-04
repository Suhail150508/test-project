<?php


namespace App\Repositories;

use App\Interfaces\ChapterInterface;
use App\Models\Chapter;

class ChapterRepository extends BaseRepository implements ChapterInterface
{
    public function __construct(Chapter $chapter)
    {
        $this->model = $chapter;
    }
}
