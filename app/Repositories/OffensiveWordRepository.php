<?php


namespace App\Repositories;

use App\Interfaces\OffensiveWordInterface;
use App\Models\OffensiveWord;

class OffensiveWordRepository extends BaseRepository implements OffensiveWordInterface
{
    public function __construct(OffensiveWord $offensiveWord)
    {
        $this->model = $offensiveWord;
    }
}
