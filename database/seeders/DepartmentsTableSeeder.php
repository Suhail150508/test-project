<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('departments')->delete();

        \DB::table('departments')->insert(array (
            0 =>
            array (
                'id' => 1,
                'department_code' => 'SWE-121',
                'title' => 'SWE',
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
