<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Super User',
                'bn_name' => 'সুপার ইউজার',
                'status' => 'Active',
                'created_at' => '2021-02-27 23:50:20',
                'updated_at' => '2021-02-27 23:50:20',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Admin',
                'bn_name' => 'এডমিন',
                'status' => 'Active',
                'created_at' => '2021-02-27 23:56:00',
                'updated_at' => '2021-03-16 20:49:35',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}