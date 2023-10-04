<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuActionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_actions')->delete();
        
        \DB::table('menu_actions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Add',
                'icon' => 'fa fa-plus-circle',
                'slug' => 'add',
                'button_class' => 'btn btn-primary btn-sm',
                'order_by' => 1,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2021-02-25 15:45:31',
                'updated_at' => '2021-02-25 15:49:31',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Edit',
                'icon' => 'fa fa-edit',
                'slug' => 'edit',
                'button_class' => 'btn btn-warning btn-sm edit',
                'order_by' => 2,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2021-02-25 15:47:13',
                'updated_at' => '2021-04-04 11:15:15',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Delete',
                'icon' => 'fa fa-trash-alt',
                'slug' => 'delete',
                'button_class' => 'btn btn-danger btn-sm destroy',
                'order_by' => 4,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2021-02-25 15:48:38',
                'updated_at' => '2021-02-28 18:33:46',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'View',
                'icon' => 'fa fa-eye',
                'slug' => 'view',
                'button_class' => 'btn btn-info btn-sm',
                'order_by' => 3,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2021-02-27 14:58:40',
                'updated_at' => '2021-02-27 16:16:44',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Permission',
                'icon' => 'fa fa-lock',
                'slug' => 'permission',
                'button_class' => 'btn btn-primary btn-sm',
                'order_by' => 5,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2021-03-18 16:38:54',
                'updated_at' => '2021-03-18 16:38:54',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'Order',
                'icon' => 'fa fa-gavel',
                'slug' => 'order',
                'button_class' => 'btn btn-warning btn-sm order',
                'order_by' => 6,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2021-03-24 17:28:00',
                'updated_at' => '2021-03-24 17:28:00',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'Check',
                'icon' => 'fa fa-check',
                'slug' => 'check',
                'button_class' => 'btn btn-primary btn-sm',
                'order_by' => 7,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2021-04-05 16:07:08',
                'updated_at' => '2021-04-05 16:16:41',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 9,
                'name' => 'Print',
                'icon' => 'fas fa-print',
                'slug' => 'print',
                'button_class' => 'btn btn-primary btn-sm',
                'order_by' => 8,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2021-05-08 12:03:01',
                'updated_at' => '2021-05-08 12:03:10',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 10,
                'name' => 'Restore',
                'icon' => 'fa fa-undo',
                'slug' => 'restore',
                'button_class' => 'btn btn-warning btn-sm restore',
                'order_by' => 9,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2021-07-12 17:14:14',
                'updated_at' => '2021-07-12 17:37:10',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 11,
                'name' => 'Edit-History',
                'icon' => 'fas fa-history',
                'slug' => 'edit_history',
                'button_class' => 'btn btn-info btn-sm edit_history',
                'order_by' => 10,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2021-10-31 11:52:20',
                'updated_at' => '2021-11-01 15:37:48',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}