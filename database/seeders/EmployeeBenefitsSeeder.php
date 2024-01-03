<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployeeBenefitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee_benefits = [
            [
            'employee_id' => 1,
            'benefit_id' => 1,
            'amount' => 250000000,
            ],
            [
            'employee_id' => 2,
            'benefit_id' => 1,
            'amount' => 250000000,
            ],
            [
            'employee_id' => 3,
            'benefit_id' => 1,
            'amount' => 250000000,
            ],
            [
            'employee_id' => 4,
            'benefit_id' => 1,
            'amount' => 250000000,
            ],
            [
            'employee_id' => 5,
            'benefit_id' => 1,
            'amount' => 250000000,
            ],
            [
            'employee_id' => 6,
            'benefit_id' => 1,
            'amount' => 250000000,
            ],
            [
            'employee_id' => 7,
            'benefit_id' => 1,
            'amount' => 250000000,
            ],
            [
            'employee_id' => 8,
            'benefit_id' => 1,
            'amount' => 250000000,
            ],
            [
            'employee_id' => 9,
            'benefit_id' => 1,
            'amount' => 250000000,
            ],
            [
            'employee_id' => 10,
            'benefit_id' => 1,
            'amount' => 250000000,
            ],
            [
            'employee_id' => 10,
            'benefit_id' => 2,
            'amount' => 500000000,
            ],
            [
            'employee_id' => 10,
            'benefit_id' => 3,
            'amount' => 300000000,
            ],
            [
            'employee_id' => 10,
            'benefit_id' => 4,
            'amount' => 400000000,
            ],
            [
            'employee_id' => 10,
            'benefit_id' => 5,
            'amount' => 500000000,
            ],
        ];

        foreach ($employee_benefits as $employeebenefitsData) {
            \App\Models\BenefitsApplication::create($employeebenefitsData);
        }

        $faker = Faker::create();

        for ($i = 11; $i < 50; $i++) {
            $randomEmployee = [
                'employee_id' => $i+1,
                'benefit_id' => $faker->numberBetween(1, 5),
                'amount' => $faker->numberBetween(35000000, 99999999),
            ];

            \App\Models\BenefitsApplication::create($randomEmployee);
        }

        for ($i = 50; $i < 100; $i++) {
            $randomEmployee = [
                'employee_id' => $i+1,
                'benefit_id' => $faker->numberBetween(1, 5),
                'amount' => $faker->numberBetween(35000000, 99999999),
                'requested_amount' => $faker->numberBetween(200000, 35000000),
                'status' => $faker->numberBetween(0,2)
            ];

            \App\Models\BenefitsApplication::create($randomEmployee);
        }
    }
}
