<?php


namespace App\Repositories;

use App\Interfaces\EducationInterface;
use App\Models\Education;

class EducationRepository extends BaseRepository implements EducationInterface
{
    public function __construct(Education $education)
    {
        $this->model = $education;
    }
}
