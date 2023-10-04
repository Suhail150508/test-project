<?php


namespace App\Repositories;

use App\Interfaces\ClassMemoriesInterface;
use App\Models\ClassMemories;

class ClassMemoriesRepository extends BaseRepository implements ClassMemoriesInterface
{
    public function __construct(ClassMemories $classMemories)
    {
        $this->model = $classMemories;
    }
}
