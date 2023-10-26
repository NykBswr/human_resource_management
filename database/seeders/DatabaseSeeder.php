<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
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

        $users = [
            [
                // Manager 1
                'username' => 'manager1',
                'email' => 'johndoe@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 1,
                'employee_id' => 1,
            ],
            [
                // Manager 2
                'username' => 'manager2',
                'email' => 'willsmith@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 1,
                'employee_id' => 2,
            ],
            [
                // Manager 3
                'username' => 'manager3',
                'email' => 'jamescal@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 1,
                'employee_id' => 3,
            ],
            [
                // Karyawan 1
                'username' => 'karyawan1',
                'email' => 'janesmith@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 4,
            ],
            [
                // Karyawan 2
                'username' => 'karyawan2',
                'email' => 'nyk@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 5,
            ],
            [
                // Karyawan 3
                'username' => 'karyawan3',
                'email' => 'hafizr@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 6,
            ],
            [
                // Karyawan 4
                'username' => 'karyawan4',
                'email' => 'kevinadi@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 7,
            ],
            [
                // Karyawan 5
                'username' => 'karyawan5',
                'email' => 'cristiano@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 8,
            ],
            [
                // Karyawan 6
                'username' => 'karyawan6',
                'email' => 'gordonramsay@example.com',
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
        
        $task = [
            [
                // Task 1
                'taskname' => 'Proyek A',
                'taskdescriptions' => 'Mengerjakan proyek A',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 4
            ],
            [
                // Task 2
                'taskname' => 'Proyek B',
                'taskdescriptions' => 'Mengerjakan proyek B',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 4
            ],
            [
                // Task 3
                'taskname' => 'Proyek C',
                'taskdescriptions' => 'Mengerjakan proyek C',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 5
            ],
            [
                // Task 4
                'taskname' => 'Proyek D',
                'taskdescriptions' => 'Mengerjakan proyek D',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 5
            ],
            [
                // Task 5
                'taskname' => 'Proyek E',
                'taskdescriptions' => 'Mengerjakan proyek E',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 6
            ],
            [
                // Task 6
                'taskname' => 'Proyek F',
                'taskdescriptions' => 'Mengerjakan proyek F',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 6
            ],
            [
                // Task 7
                'taskname' => 'Proyek G',
                'taskdescriptions' => 'Mengerjakan proyek G',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 7
            ],
            [
                // Task 8
                'taskname' => 'Proyek H',
                'taskdescriptions' => 'Mengerjakan proyek H',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 7
            ],
            [
                // Task 9
                'taskname' => 'Proyek I',
                'taskdescriptions' => 'Mengerjakan proyek I',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 8
            ],
            [
                // Task 10
                'taskname' => 'Proyek J',
                'taskdescriptions' => 'Mengerjakan proyek J',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 8
            ],
            [
                // Task 11
                'taskname' => 'Proyek K',
                'taskdescriptions' => 'Mengerjakan proyek K',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 9
            ],
            [
                // Task 12
                'taskname' => 'Proyek L',
                'taskdescriptions' => 'Mengerjakan proyek L',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 9
            ],
        ];

        $performance = [
            [
                // Task 1
                'employee_id' => 4,
                'task_id' => 1,
            ],
            [
                // Task 2
                'employee_id' => 4,
                'task_id' => 2,
            ],
            [
                // Task 3
                'employee_id' => 5,
                'task_id' => 3,
            ],
            [
                // Task 4
                'employee_id' => 5,
                'task_id' => 4,
            ],
            [
                // Task 5
                'employee_id' => 6,
                'task_id' => 5,
            ],
            [
                // Task 6
                'employee_id' => 6,
                'task_id' => 6,
            ],
            [
                // Task 7
                'employee_id' => 7,
                'task_id' => 7,
            ],
            [
                // Task 8
                'employee_id' => 7,
                'task_id' => 8,
            ],
            [
                // Task 9
                'employee_id' => 8,
                'task_id' => 9,
            ],
            [
                // Task 10
                'employee_id' => 8,
                'task_id' => 10,
            ],
            [
                // Task 11
                'employee_id' => 9,
                'task_id' => 11,
            ],
            [
                // Task 12
                'employee_id' => 9,
                'task_id' => 12,
            ],
        ];

        $facilities = [
            [
                // Facility 1
                'facility_name' => 'Honda Brio',
                'remain' => 100,
            ],
            [
                // Facility 2
                'facility_name' => 'Honda Vario',
                'remain' => 100,
            ],
            [
                // Facility 3
                'facility_name' => 'Toyota Alphard',
                'remain' => 100,
            ],
            [
                // Facility 4
                'facility_name' => 'Toyota Inova',
                'remain' => 100,
            ],
            [
                // Facility 5
                'facility_name' => 'Honda PCX',
                'remain' => 100,
            ],
        ];

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

        $benefits = [
            [
                // Benefits 1
                'benefit_name' => "Kartu BPJS",
                'benefit_amount' => 250000000,
            ],
            [
                // Benefits 2
                'benefit_name' => "Kartu Asuransi AXA",
                'benefit_amount' => 500000000,
            ],
            [
                // Benefits 3
                'benefit_name' => "Kartu Pendidikan Anak",
                'benefit_amount' => 300000000,
            ],
            [
                // Benefits 4
                'benefit_name' => "Kartu Asuransi Kendaraan",
                'benefit_amount' => 400000000,
            ],
            [
                // Benefits 5
                'benefit_name' => "Kredit Perumahan",
                'benefit_amount' => 500000000,
            ],
        ];

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

        foreach ($employees as $employeeData) {
        \App\Models\Employee::create($employeeData);
        }

        foreach ($users as $userData) {
        \App\Models\User::create($userData);
        }

        foreach ($payroll as $payrollData) {
        \App\Models\Payroll::create($payrollData);
        }

        foreach ($task as $taskData) {
        \App\Models\Task::create($taskData);
        }

        foreach ($performance as $performanceData) {
        \App\Models\Performance::create($performanceData);
        }

        foreach ($facilities as $facilitiesData) {
        \App\Models\Facility::create($facilitiesData);
        }
        
        foreach ($employee_facility as $employee_facilityData) {
        \App\Models\EmployeeFacility::create($employee_facilityData);
        }

        foreach ($benefits as $benefitsData) {
        \App\Models\Benefit::create($benefitsData);
        }

        foreach ($employee_benefits as $employeebenefitsData) {
        \App\Models\BenefitsApplication::create($employeebenefitsData);
        }
    }
}
