<?php


namespace App\Repositories;


use App\Interfaces\PartnerInterface;
use App\Models\Partner;

class PartnerRepository extends BaseRepository implements PartnerInterface
{
    public function __construct(Partner $model)
    {
        $this->model = $model;
    }
}
