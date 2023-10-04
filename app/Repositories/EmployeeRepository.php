<?php


namespace App\Repositories;

use App\Models\Employee;
use App\Interfaces\EmployeeInterface;


class EmployeeRepository extends BaseRepository implements EmployeeInterface
{
    public function __construct(Employee $model)
    {
        $this->model = $model;
    }
}
