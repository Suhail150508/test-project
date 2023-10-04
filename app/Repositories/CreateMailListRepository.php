<?php

namespace App\Repositories;

use App\Interfaces\CreateMailListInterface;
use App\Models\CreateMailList;

class CreateMailListRepository extends BaseRepository implements CreateMailListInterface
{
    public function __construct(CreateMailList $createMailList)
    {
        $this->model = $createMailList;
    }
}
