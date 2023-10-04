<?php


namespace App\Repositories;

use App\Interfaces\ContactUsInterface;
use App\Models\ContactUs;

class ContactUsRepository extends BaseRepository implements ContactUsInterface
{
    public function __construct(ContactUs $model)
    {
        $this->model = $model;
    }
}
