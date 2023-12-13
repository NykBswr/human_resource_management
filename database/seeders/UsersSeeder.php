<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                // Manager 1
                'username' => 'manager1',
                'email' => 'johndoe@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 1,
                'employee_id' => 1,
            ],
            [
                // Manager 2
                'username' => 'manager2',
                'email' => 'willsmith@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 1,
                'employee_id' => 2,
            ],
            [
                // Manager 3
                'username' => 'manager3',
                'email' => 'jamescal@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 1,
                'employee_id' => 3,
            ],
            [
                // Karyawan 1
                'username' => 'karyawan1',
                'email' => 'janesmith@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 4,
            ],
            [
                // Karyawan 2
                'username' => 'karyawan2',
                'email' => 'nyk@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 5,
            ],
            [
                // Karyawan 3
                'username' => 'karyawan3',
                'email' => 'hafizr@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 6,
            ],
            [
                // Karyawan 4
                'username' => 'karyawan4',
                'email' => 'kevinadi@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 7,
            ],
            [
                // Karyawan 5
                'username' => 'karyawan5',
                'email' => 'cristiano@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 8,
            ],
            [
                // Karyawan 6
                'username' => 'karyawan6',
                'email' => 'gordonramsay@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 9,
            ],
            [
                // Kepala cabang
                'username' => 'kepala cabang',
                'email' => 'nayaka@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 2,
                'employee_id' => 10,
            ],
            [
                // Human Resources
                'username' => 'hr',
                'email' => 'hr@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 3,
                'employee_id' => 11,
            ],
        ];

        foreach ($users as $userData) {
            \App\Models\User::create($userData);
        }

        $faker = Faker::create();
        
        for ($i = 11; $i < 100; $i++) {
            $randomUser = [
                'username' => 'karyawan' . $i,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => $i+1,
            ];

            \App\Models\User::create($randomUser);
        }
    }
}
