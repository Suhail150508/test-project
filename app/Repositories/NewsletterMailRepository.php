<?php

namespace App\Repositories;

use App\Interfaces\NewsletterMailInterface;
use App\Models\NewsletterMail;

class NewsletterMailRepository extends BaseRepository implements NewsletterMailInterface
{
    public function __construct(NewsletterMail $newsletterMail)
    {
        $this->model = $newsletterMail;
    }
}