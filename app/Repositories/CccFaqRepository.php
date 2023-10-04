<?php


namespace App\Repositories;

use App\Interfaces\CccFaqInterface;
use App\Models\CccFaq;


class CccFaqRepository extends BaseRepository implements CccFaqInterface
{
    public function __construct(CccFaq $ccc_faq)
    {
        $this->model = $ccc_faq;
    }
}
