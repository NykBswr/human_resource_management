<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payroll = [
            [
                // Manager 1
                'employee_id' => 1,
                'salary_amount' => 12000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
            [
                // Manager 2
                'employee_id' => 2,
                'salary_amount' => 12000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
            [
                // Manager 3
                'employee_id' => 3,
                'salary_amount' => 12000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
            [
                // Karyawan 1
                'employee_id' => 4,
                'salary_amount' => 4000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
            [
                // Karyawan 2
                'employee_id' => 5,
                'salary_amount' => 4000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
            [
                // Karyawan 3
                'employee_id' => 6,
                'salary_amount' => 4000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
            [
                // Karyawan 4
                'employee_id' => 7,
                'salary_amount' => 4000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
            [
                // Karyawan 5
                'employee_id' => 8,
                'salary_amount' => 4000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
            [
                // Karyawan 6
                'employee_id' => 9,
                'salary_amount' => 4000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
            [
                // Kepala cabang
                'employee_id' => 10,
                'salary_amount' => 20000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
            [
                // Human Resources
                'employee_id' => 11,
                'salary_amount' => 4000000,
                'tax_deduction' => 5,
                'payment_date' => '2023-11-01',
            ],
        ];

        foreach ($payroll as $payrollData) {
            \App\Models\Payroll::create($payrollData);
        }

        $faker = Faker::create();

        for ($i = 11; $i < 100; $i++) {
            $randomEmployee = [
                'employee_id' => $i,
                'salary_amount' => $faker->numberBetween(35000000, 99999999),
                'tax_deduction' => 5,
                'payment_date' => '2023-12-01',
            ];

            \App\Models\Payroll::create($randomEmployee);
        }
    }
}
