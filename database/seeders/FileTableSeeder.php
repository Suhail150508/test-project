<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('files')->insert(array (
            0=>array('id'=>2,'fileable_type'=>'App\Models\Alumni','fileable_id' =>2,'type'=>'alumni','source'=>'http://localhost:8000/uploads/images/alumnis/WgJVo0PJSK_63d9dffa33579.jpeg'),
            1=>array('id'=>3,'fileable_type'=>'App\Models\Alumni','fileable_id' =>3,'type'=>'alumni','source'=>'http://localhost:8000/uploads/images/alumnis/WgJVo0PJSK_63d9dffa33579.jpeg'),
        ));
    }
}
