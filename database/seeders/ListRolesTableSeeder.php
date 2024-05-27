<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_roles')->delete();
        
        \DB::table('list_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Top Management',
                'description' => '..',
                'has_designation' => 0,
                'is_active' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Scholarship Coordinator',
                'description' => '..',
                'has_designation' => 0,
                'is_active' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Scholarship Staff',
                'description' => '..',
                'has_designation' => 0,
                'is_active' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'PSTO Staff',
                'description' => '..',
                'has_designation' => 1,
                'is_active' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'University Coordinator',
                'description' => '..',
                'has_designation' => 1,
                'is_active' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Cashier',
                'description' => '..',
                'has_designation' => 0,
                'is_active' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Accountant',
                'description' => '..',
                'has_designation' => 0,
                'is_active' => 1,
            ),
        ));

        
    }
}