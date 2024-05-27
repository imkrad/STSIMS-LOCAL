<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_roles')->truncate();
        
        \DB::table('user_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 2,
                'role_id' => 2,
                'created_at' => '2024-05-27 08:32:46',
                'updated_at' => '2024-05-27 08:32:46',
            ),
            1 => 
            array (
                'id' => 2,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 3,
                'role_id' => 3,
                'created_at' => '2024-05-27 08:33:42',
                'updated_at' => '2024-05-27 08:33:42',
            ),
            2 => 
            array (
                'id' => 3,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 4,
                'role_id' => 3,
                'created_at' => '2024-05-27 08:35:17',
                'updated_at' => '2024-05-27 08:35:17',
            ),
            3 => 
            array (
                'id' => 4,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 5,
                'role_id' => 3,
                'created_at' => '2024-05-27 08:38:13',
                'updated_at' => '2024-05-27 08:38:13',
            ),
            4 => 
            array (
                'id' => 5,
                'roleable_type' => 'App\\Models\\LocationProvince',
                'roleable_id' => 97200000,
                'user_id' => 6,
                'role_id' => 4,
                'created_at' => '2024-05-27 08:39:16',
                'updated_at' => '2024-05-27 08:39:16',
            ),
            5 => 
            array (
                'id' => 6,
                'roleable_type' => 'App\\Models\\LocationProvince',
                'roleable_id' => 97300000,
                'user_id' => 7,
                'role_id' => 4,
                'created_at' => '2024-05-27 08:40:04',
                'updated_at' => '2024-05-27 08:40:04',
            ),
            6 => 
            array (
                'id' => 7,
                'roleable_type' => 'App\\Models\\LocationProvince',
                'roleable_id' => 98300000,
                'user_id' => 8,
                'role_id' => 4,
                'created_at' => '2024-05-27 08:40:55',
                'updated_at' => '2024-05-27 08:40:55',
            ),
            7 => 
            array (
                'id' => 8,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 9,
                'role_id' => 2,
                'created_at' => '2024-05-27 08:53:43',
                'updated_at' => '2024-05-27 08:53:43',
            ),
            8 => 
            array (
                'id' => 9,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 10,
                'role_id' => 2,
                'created_at' => '2024-05-27 08:54:19',
                'updated_at' => '2024-05-27 08:54:19',
            ),
            9 => 
            array (
                'id' => 10,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 11,
                'role_id' => 2,
                'created_at' => '2024-05-27 08:55:09',
                'updated_at' => '2024-05-27 08:55:09',
            ),
            10 => 
            array (
                'id' => 11,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 12,
                'role_id' => 2,
                'created_at' => '2024-05-27 08:55:54',
                'updated_at' => '2024-05-27 08:55:54',
            ),
            11 => 
            array (
                'id' => 12,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 13,
                'role_id' => 2,
                'created_at' => '2024-05-27 08:56:49',
                'updated_at' => '2024-05-27 08:56:49',
            ),
            12 => 
            array (
                'id' => 13,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 14,
                'role_id' => 2,
                'created_at' => '2024-05-27 08:57:21',
                'updated_at' => '2024-05-27 08:57:21',
            ),
            13 => 
            array (
                'id' => 14,
                'roleable_type' => 'App\\Models\\LocationRegion',
                'roleable_id' => 90000000,
                'user_id' => 15,
                'role_id' => 2,
                'created_at' => '2024-05-27 08:58:13',
                'updated_at' => '2024-05-27 08:58:13',
            ),
        ));

        
    }
}