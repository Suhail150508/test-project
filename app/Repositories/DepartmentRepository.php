<?php


namespace App\Repositories;

use App\Interfaces\DepartmentInterface;
use App\Models\Department;


class DepartmentRepository extends BaseRepository implements DepartmentInterface
{
    public function __construct(Department $department)
    {
        $this->model = $department;
    }
}
