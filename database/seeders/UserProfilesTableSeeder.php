<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserProfilesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_profiles')->truncate();
        
        \DB::table('user_profiles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'firstname' => 'Ra-ouf',
                'lastname' => 'Jumli',
                'middlename' => 'Indanan',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09171531652',
                'avatar' => 'avatar.jpg',
                'user_id' => 1,
                'created_at' => '2024-05-27 08:28:13',
                'updated_at' => '2024-05-27 08:28:13',
            ),
            1 => 
            array (
                'id' => 2,
                'firstname' => 'Josephine',
                'lastname' => 'Nohay',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09171208213',
                'avatar' => 'avatar.jpg',
                'user_id' => 2,
                'created_at' => '2024-05-27 08:32:46',
                'updated_at' => '2024-05-27 08:32:46',
            ),
            2 => 
            array (
                'id' => 3,
                'firstname' => 'Zoren',
                'lastname' => 'Antonio',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09958418776',
                'avatar' => 'avatar.jpg',
                'user_id' => 3,
                'created_at' => '2024-05-27 08:33:42',
                'updated_at' => '2024-05-27 08:33:42',
            ),
            3 => 
            array (
                'id' => 4,
                'firstname' => 'Sheila',
                'lastname' => 'Bernardo',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09060775053',
                'avatar' => 'avatar.jpg',
                'user_id' => 4,
                'created_at' => '2024-05-27 08:35:17',
                'updated_at' => '2024-05-27 08:35:17',
            ),
            4 => 
            array (
                'id' => 5,
                'firstname' => 'Stenel Rizza',
                'lastname' => 'Alegre',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09156383457',
                'avatar' => 'avatar.jpg',
                'user_id' => 5,
                'created_at' => '2024-05-27 08:38:13',
                'updated_at' => '2024-05-27 08:38:13',
            ),
            5 => 
            array (
                'id' => 6,
                'firstname' => 'Marc',
                'lastname' => 'Cachin',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09773325701',
                'avatar' => 'avatar.jpg',
                'user_id' => 6,
                'created_at' => '2024-05-27 08:39:16',
                'updated_at' => '2024-05-27 08:39:16',
            ),
            6 => 
            array (
                'id' => 7,
                'firstname' => 'Sheryl',
                'lastname' => 'Jovenal',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09778205540',
                'avatar' => 'avatar.jpg',
                'user_id' => 7,
                'created_at' => '2024-05-27 08:40:04',
                'updated_at' => '2024-05-27 08:40:04',
            ),
            7 => 
            array (
                'id' => 8,
                'firstname' => 'Jeyzel',
                'lastname' => 'Aparri',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09778202436',
                'avatar' => 'avatar.jpg',
                'user_id' => 8,
                'created_at' => '2024-05-27 08:40:55',
                'updated_at' => '2024-05-27 08:40:55',
            ),
            8 => 
            array (
                'id' => 9,
                'firstname' => 'Peter Gerry',
                'lastname' => 'Gavina',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123456789',
                'avatar' => 'avatar.jpg',
                'user_id' => 9,
                'created_at' => '2024-05-27 08:53:43',
                'updated_at' => '2024-05-27 08:53:43',
            ),
            9 => 
            array (
                'id' => 10,
                'firstname' => 'Ma. Daisy',
                'lastname' => 'Sison',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09123456781',
                'avatar' => 'avatar.jpg',
                'user_id' => 10,
                'created_at' => '2024-05-27 08:54:19',
                'updated_at' => '2024-05-27 08:54:19',
            ),
            10 => 
            array (
                'id' => 11,
                'firstname' => 'Charilyn Joy',
                'lastname' => 'Layus',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09123456782',
                'avatar' => 'avatar.jpg',
                'user_id' => 11,
                'created_at' => '2024-05-27 08:55:09',
                'updated_at' => '2024-05-27 08:55:09',
            ),
            11 => 
            array (
                'id' => 12,
                'firstname' => 'Ma. Nerissa',
                'lastname' => 'Francisco',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09123456783',
                'avatar' => 'avatar.jpg',
                'user_id' => 12,
                'created_at' => '2024-05-27 08:55:54',
                'updated_at' => '2024-05-27 08:55:54',
            ),
            12 => 
            array (
                'id' => 13,
                'firstname' => 'Anne Chiara',
                'lastname' => 'Amponin',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09123456784',
                'avatar' => 'avatar.jpg',
                'user_id' => 13,
                'created_at' => '2024-05-27 08:56:49',
                'updated_at' => '2024-05-27 08:56:49',
            ),
            13 => 
            array (
                'id' => 14,
                'firstname' => 'Jhan Jhan',
                'lastname' => 'De Vera',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123456785',
                'avatar' => 'avatar.jpg',
                'user_id' => 14,
                'created_at' => '2024-05-27 08:57:21',
                'updated_at' => '2024-05-27 08:57:21',
            ),
            14 => 
            array (
                'id' => 15,
                'firstname' => 'Raprence',
                'lastname' => 'Rosas',
                'middlename' => NULL,
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123456786',
                'avatar' => 'avatar.jpg',
                'user_id' => 15,
                'created_at' => '2024-05-27 08:58:13',
                'updated_at' => '2024-05-27 08:58:13',
            ),
        ));

        
    }
}