<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_menus')->delete();
        
        \DB::table('list_menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Dashboard',
                'icon' => 'ri ri-apps-line',
                'route' => '/dashboard',
                'path' => 'Modules/Dashboard',
                'group' => 'Menu',
                'order' => 1,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Scholars',
                'icon' => 'ri-team-fill',
                'route' => NULL,
                'path' => 'Modules/Scholars',
                'group' => 'Menu',
                'order' => 2,
                'has_child' => 1,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Lists',
                'icon' => NULL,
                'route' => '/scholars/lists',
                'path' => '/scholars/lists',
                'group' => 'Scholars',
                'order' => 1,
                'has_child' => 0,
                'is_mother' => 0,
                'is_active' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Qualifiers',
                'icon' => NULL,
                'route' => '/scholars/qualifiers',
                'path' => '/scholars/qualifiers',
                'group' => 'Scholars',
                'order' => 2,
                'has_child' => 0,
                'is_mother' => 0,
                'is_active' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Endorsements',
                'icon' => NULL,
                'route' => '/scholars/endorsements',
                'path' => '/scholars/endorsements',
                'group' => 'Scholars',
                'order' => 3,
                'has_child' => 0,
                'is_mother' => 0,
                'is_active' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Transferees',
                'icon' => NULL,
                'route' => '/scholars/transferees',
                'path' => '/scholars/transferees',
                'group' => 'Scholars',
                'order' => 4,
                'has_child' => 0,
                'is_mother' => 0,
                'is_active' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Schools',
                'icon' => 'ri-hotel-fill',
                'route' => '/schools',
                'path' => 'Modules/Schools',
                'group' => 'Menu',
                'order' => 3,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Enrollments',
                'icon' => 'ri-pages-line',
                'route' => '/enrollments',
                'path' => 'Modules/Enrollments',
                'group' => 'Menu',
                'order' => 4,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Financial Benefits',
                'icon' => 'ri-wallet-3-fill',
                'route' => '/financial-benefits',
                'path' => 'Modules/FinancialBenefits',
                'group' => 'Menu',
                'order' => 5,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
        ));

        
    }
}