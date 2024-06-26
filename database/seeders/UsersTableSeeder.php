<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'administrator',
                'email' => 'kradjumli@gmail.com',
                'password' => '$2y$12$0tCFkhs.g2ZYuhxvuL8Ykuf4FVdW.E34m9aiiZBcGQwWkYMNGuPSa',
                'role' => 'Administrator',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-27 08:28:13',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:28:13',
                'updated_at' => '2024-05-27 08:50:18',
            ),
            1 => 
            array (
                'id' => 2,
                'username' => 'jbn',
                'email' => 'jpine652001@yahoo.com',
                'password' => '$2y$12$KJ22NJJuni3iW0dUqGQwSOlySJQCoNk1V9Ve/5yEZtoI2t0IdvU7a',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 00:00:00',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:32:46',
                'updated_at' => '2024-05-27 08:32:46',
            ),
            2 => 
            array (
                'id' => 3,
                'username' => 'zfa',
                'email' => 'zorenantonio@gmail.com',
                'password' => '$2y$12$k7nqSwqadUjtfX81H1jVq.x4CJH96SnXn1nG3t28E2vLHiqOyNbpy',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 00:00:00',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:33:42',
                'updated_at' => '2024-05-27 08:33:42',
            ),
            3 => 
            array (
                'id' => 4,
                'username' => 'ssb',
                'email' => 'bernardosheila21@gmail.com',
                'password' => '$2y$12$eIq5FeSDO41yEqx.H1GSqe/FcPFo0WjaNcxMEVPENdBl/H82Ynixy',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 00:00:00',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:35:17',
                'updated_at' => '2024-05-27 08:35:17',
            ),
            4 => 
            array (
                'id' => 5,
                'username' => 'sav',
                'email' => 'stenel_rizza@yahoo.com',
                'password' => '$2y$12$xUojLh9m0XZURfGovtunwumI5lwXFsrE49HaMps1phFY14Y1Vg4cK',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 00:00:00',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:38:13',
                'updated_at' => '2024-05-27 08:38:13',
            ),
            5 => 
            array (
                'id' => 6,
                'username' => 'mgc',
                'email' => 'cachinmarc@yahoo.com',
                'password' => '$2y$12$4hkj/tBj4zd9lzSj/OGkE.ghjOFELCsvBeQciKM8Lcg7CIKS/kL/C',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 17:00:18',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:39:16',
                'updated_at' => '2024-05-27 08:39:16',
            ),
            6 => 
            array (
                'id' => 7,
                'username' => 'sfj',
                'email' => 'jovenalsheryl@gmail.com',
                'password' => '$2y$12$g/IU9B6vxdr06jkBiHmTTu2nrl36vfdymdFbnR63DULJxvN/Mc.xa',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 17:00:16',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:40:04',
                'updated_at' => '2024-05-27 08:40:04',
            ),
            7 => 
            array (
                'id' => 8,
                'username' => 'jpa',
                'email' => 'jeyzel_aparri@gmail.com',
                'password' => '$2y$12$d7jT10cdUKkl7ucjQyVkyONQ/4mh3dfPrx28hSDRaGzhd8IjYL/Ta',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 17:00:15',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:40:55',
                'updated_at' => '2024-05-27 08:40:55',
            ),
            8 => 
            array (
                'id' => 9,
                'username' => 'peter_sei',
                'email' => 'peter_sei@gmail.com',
                'password' => '$2y$12$Zm5cXXuc8uF2JRY.WlbsjeDyCXdLYLPuc.RvIggkyzBJIOUC4PMTq',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 17:00:13',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:53:43',
                'updated_at' => '2024-05-27 08:53:43',
            ),
            9 => 
            array (
                'id' => 10,
                'username' => 'daisy_sei',
                'email' => 'daisy_sei@gmail.com',
                'password' => '$2y$12$Xw8YQZCRb9wynT8NkYsGT.Y3YM07uLT/GWBGkVuRVPF/fOcle.Q8y',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 17:00:12',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:54:19',
                'updated_at' => '2024-05-27 08:54:19',
            ),
            10 => 
            array (
                'id' => 11,
                'username' => 'charilyn_sei',
                'email' => 'charilyn_sei@gmail.com',
                'password' => '$2y$12$BqKFHkLFmzpDYM7myDrw.eJj2rhIzY5/60KeflnRxWlvYMQW/Va4a',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 17:00:11',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:55:09',
                'updated_at' => '2024-05-27 08:55:09',
            ),
            11 => 
            array (
                'id' => 12,
                'username' => 'nerissa_sei',
                'email' => 'nerissa_sei@gmail.com',
                'password' => '$2y$12$xWbLQDSn5Dhf28L4AXKGMOOTNII8M2o/LJ3.w0FM9Cl9jMiC4U0e.',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 17:00:09',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:55:54',
                'updated_at' => '2024-05-27 08:55:54',
            ),
            12 => 
            array (
                'id' => 13,
                'username' => 'anne_sei',
                'email' => 'anne_sei@gmail.com',
                'password' => '$2y$12$Pky.6BNu9Z5r0S7rKcY1X.Av0neUd0VJ5x9cNLFlsGA141p5JeWEq',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 17:00:07',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:56:49',
                'updated_at' => '2024-05-27 08:56:49',
            ),
            13 => 
            array (
                'id' => 14,
                'username' => 'jhan_sei',
                'email' => 'jhan_sei@gmail.com',
                'password' => '$2y$12$6R9F3C/eEKhLwflOWy6GAOZOD.23RvbJxMMoe9Yr9OoMF6z95aQma',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 17:00:05',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:57:21',
                'updated_at' => '2024-05-27 08:57:21',
            ),
            14 => 
            array (
                'id' => 15,
                'username' => 'raprence_sei',
                'email' => 'raprence_sei@gmail.com',
                'password' => '$2y$12$i07xPz2ReIzQJKboqONkZuL.qipf.s1xfaR/US.NkRNrqEkN1AGm.',
                'role' => 'Staff',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-01 17:00:03',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-05-27 08:58:13',
                'updated_at' => '2024-05-27 08:58:13',
            ),
        ));

        
    }
}