<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployeeFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee_facility = [
            [
                // Employee Facility 1
                'employee_id' => 1,
                'facility_id' => 1,
            ],
            [
                // Employee Facility 2
                'employee_id' => 1,
                'facility_id' => 2,
            ],
            [
                // Employee Facility 3
                'employee_id' => 2,
                'facility_id' => 1,
            ],
            [
                // Employee Facility 4
                'employee_id' => 2,
                'facility_id' => 4,
            ],
            [
                // Employee Facility 5
                'employee_id' => 3,
                'facility_id' => 1,
            ],
            [
                // Employee Facility 6
                'employee_id' => 3,
                'facility_id' => 5,
            ],
            [
                // Employee Facility 7
                'employee_id' => 4,
                'facility_id' => 5,
            ],
            [
                // Employee Facility 8
                'employee_id' => 4,
                'facility_id' => 2,
            ],
            [
                // Employee Facility 9
                'employee_id' => 5,
                'facility_id' => 5,
            ],
            [
                // Employee Facility 10
                'employee_id' => 5,
                'facility_id' => 1,
            ],
            [
                // Employee Facility 11
                'employee_id' => 6,
                'facility_id' => 5,
            ],
            [
                // Employee Facility 12
                'employee_id' => 6,
                'facility_id' => 1,
            ],
            [
                // Employee Facility 13
                'employee_id' => 7,
                'facility_id' => 5,
            ],
            [
                // Employee Facility 14
                'employee_id' => 7,
                'facility_id' => 1,
            ],
        ];

        foreach ($employee_facility as $employee_facilityData) {
            \App\Models\EmployeeFacility::create($employee_facilityData);
        }

        $faker = Faker::create();

        for ($i = 12; $i < 101; $i++) {
            $randomEmployee = [
                'employee_id' => $i,
                'facility_id' => $faker->numberBetween(1, 5),
            ];

            \App\Models\EmployeeFacility::create($randomEmployee);
        }
    }
}
