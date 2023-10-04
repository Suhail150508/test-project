<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MajorMinorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('major_minors')->delete();

        \DB::table('major_minors')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => 'Physics',
                'description' => NULL,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
    }
}
