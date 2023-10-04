<?php

namespace App\Repositories;

use App\Interfaces\ResumeFileInterface;
use App\Models\ResumeFile;

class ResumeFileRepository extends BaseRepository implements ResumeFileInterface
{
    public function __construct(ResumeFile $model)
    {
        $this->model = $model;
    }
}
