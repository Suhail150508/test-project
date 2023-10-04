<?php


namespace App\Repositories;

use App\Interfaces\CountryInterface;
use App\Models\Country;


class CountryRepository extends BaseRepository implements CountryInterface
{
    public function __construct(Country $country)
    {
        $this->model = $country;
    }
}
