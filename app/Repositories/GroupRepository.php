<?php


namespace App\Repositories;

use App\Interfaces\GroupInterface;
use App\Models\Group;

class GroupRepository extends BaseRepository implements GroupInterface
{
    public function __construct(Group $group)
    {
        $this->model = $group;
    }
}
