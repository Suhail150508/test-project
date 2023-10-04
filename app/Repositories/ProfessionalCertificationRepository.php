<?php


namespace App\Repositories;

use App\Interfaces\ProfessionalCertificationInterface;
use App\Models\ProfessionalCertification;


class ProfessionalCertificationRepository extends BaseRepository implements ProfessionalCertificationInterface
{
    public function __construct(ProfessionalCertification $model)
    {
        $this->model = $model;
    }
}
