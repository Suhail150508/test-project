<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('skills')->delete();

        \DB::table('skills')->insert(array(
            0 =>
            array(
                'id' => 1,
                'title' => 'Laravel',
                'description' => NULL,
                'status' => 'Active',
                'created_by' => Null,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
    }
}
