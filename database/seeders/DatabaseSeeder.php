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
                // Manager
                'firstname' => 'John',
                'lastname' => 'Doe',
                'position' => 0,
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
                // Kepala Cabang
                'firstname' => 'Nayaka',
                'lastname' => 'Baswara',
                'salary' => '999999999',
                'joining_date' => '2023-10-26'
            ],
            [
                // Karyawan 2
                'firstname' => 'Nayaka',
                'lastname' => 'Baswara',
                'position' => 1,
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
                // Manager 
                'username' => 'manager',
                'email' => 'johndoe@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 1,
                'employee_id' => 1,
            ],
            [
                // Karyawan 1
                'username' => 'karyawan1',
                'email' => 'janesmith@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 2,
            ],
            [
                // Karyawan 2
                'username' => 'karyawan2',
                'email' => 'nyk@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 4,
            ],
            [
                // Kepala cabang
                'username' => 'kepala cabang',
                'email' => 'nayaka@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 2,
                'employee_id' => 3,
            ],
            [
                // Human Resources
                'username' => 'hr',
                'email' => 'hr@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 3,
                'employee_id' => 5,
            ],
        ];

        $task = [
            [
                // Task 1
                'taskname' => 'Proyek A',
                'taskdescriptions' => 'Mengerjakan proyek A',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 2
            ],
            [
                // Task 2
                'taskname' => 'Proyek B',
                'taskdescriptions' => 'Mengerjakan proyek B',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 4
            ],
        ];

        $performance = [
            [
                // Task 1
                'employee_id' => 2,
                'task_id' => 1,
            ],
            [
                // Task 2
                'employee_id' => 4,
                'task_id' => 2,
            ],
        ];


        foreach ($employees as $employeeData) {
        \App\Models\Employee::create($employeeData);
        }

        foreach ($users as $userData) {
        \App\Models\User::create($userData);
        }

        foreach ($task as $taskData) {
        \App\Models\Task::create($taskData);
        }

        foreach ($performance as $performanceData) {
        \App\Models\Performance::create($performanceData);
        }
    }
}
