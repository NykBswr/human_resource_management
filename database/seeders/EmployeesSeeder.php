<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployeesSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
            // Manager 1
            'firstname' => 'John',
            'lastname' => 'Doe',
            'position' => 0,
            'salary' => '50000',
            'joining_date' => '2023-10-26'
            ],
            [
            // Manager 2
            'firstname' => 'Will',
            'lastname' => 'Smith',
            'position' => 1,
            'salary' => '50000',
            'joining_date' => '2023-10-26'
            ],
            [
            // Manager 3
            'firstname' => 'James',
            'lastname' => 'Callaghar',
            'position' => 2,
            'salary' => '50000',
            'joining_date' => '2023-10-26'
            ],
            [
            // Karyawan 1
            'firstname' => 'Jane',
            'lastname' => 'Smith',
            'position' => 0,
            'salary' => '40000',
            'joining_date' => '2023-10-26'
            ],
            [
            // Karyawan 2
            'firstname' => 'Nayaka',
            'lastname' => 'Baswara',
            'position' => 0,
            'salary' => '999999999',
            'joining_date' => '2023-10-26'
            ],
            [
            // Karyawan 3
            'firstname' => 'Hafiz',
            'lastname' => 'Rahman',
            'position' => 1,
            'salary' => '999999999',
            'joining_date' => '2023-10-26'
            ],
            [
            // Karyawan 4
            'firstname' => 'Kevin',
            'lastname' => 'Adi',
            'position' => 1,
            'salary' => '999999999',
            'joining_date' => '2023-10-26'
            ],
            [
            // Karyawan 5
            'firstname' => 'Cristiano',
            'lastname' => 'Ronaldo',
            'position' => 2,
            'salary' => '999999999',
            'joining_date' => '2023-10-26'
            ],
            [
            // Karyawan 6
            'firstname' => 'Gordon',
            'lastname' => 'Ramsay',
            'position' => 2,
            'salary' => '999999999',
            'joining_date' => '2023-10-26'
            ],
            [
            // Kepala Cabang
            'firstname' => 'Nayaka',
            'lastname' => 'Baswara',
            'salary' => '999999999',
            'joining_date' => '2023-10-26'
            ],
            [
            // Human Resources
            'firstname' => 'Nayaka',
            'lastname' => 'Baswara',
            'salary' => '9999999999999999999',
            'joining_date' => '2023-10-26'
            ],
        ];

        foreach ($employees as $employeeData) {
            \App\Models\Employee::create($employeeData);
        }

        $faker = Faker::create();
        for ($i = 11; $i < 100; $i++) {
            $randomEmployee = [
                'firstname' => ucfirst($faker->firstName),
                'lastname' => ucfirst($faker->lastName),
                'position' => $faker->numberBetween(0, 7),
                'salary' => $faker->numberBetween(35000000, 99999999),
                'joining_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            ];

            \App\Models\Employee::create($randomEmployee);
        }
    }
}
