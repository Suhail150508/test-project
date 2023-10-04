<?php

namespace App\Repositories;

use App\Interfaces\ResumeInterface;
use App\Models\Resume;


class ResumeRepository extends BaseRepository implements ResumeInterface
{
    public function __construct(Resume $model)
    {
        $this->model = $model;
    }
}
