<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DivisionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('divisions')->delete();

        \DB::table('divisions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Barisal',
                'bn_name' => 'বরিশাল',
                'status' => 'Active',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Chittagong',
                'bn_name' => 'চট্টগ্রাম',
                'status' => 'Active',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Dhaka',
                'bn_name' => 'ঢাকা',
                'status' => 'Active',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Khulna',
                'bn_name' => 'খুলনা',
                'status' => 'Active',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Rajshahi',
                'bn_name' => 'রাজশাহী',
                'status' => 'Active',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Rangpur',
                'bn_name' => 'রংপুর',
                'status' => 'Active',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Sylhet',
                'bn_name' => 'সিলেট',
                'status' => 'Active',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'name' => '',
                'bn_name' => 'ময়মনসিংহ',
                'status' => 'Active',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));


    }
}
