<?php

namespace Database\Seeders;

use App\Models\CccNews;
use Illuminate\Database\Seeder;

class CccNewsTableSeeder extends Seeder
{
    public function run()
    {
        CccNews::factory(100)->create();
    }
}
