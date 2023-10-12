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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Dummy data for the 'employees' table
        $employees = [
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'position' => 0,
                'salary' => '50000',
            ],
            [
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'position' => 1,
                'salary' => '40000',
            ],
            [
                'firstname' => 'Nayaka',
                'lastname' => 'Baswara',
                'salary' => '999999999',
            ],
        ];

        $users = [
            [
                'username' => 'manager',
                'email' => 'johndoe@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 1,
                'employee_id' => 1,
            ],
            [
                'username' => 'karyawan',
                'email' => 'janesmith@example.com',
                'password' => bcrypt('nayaka123'),
                'role' => 0,
                'employee_id' => 2,
            ],
            [
                'username' => 'kepala cabang',
                'email' => 'nayaka@gmail.com',
                'password' => bcrypt('nayaka123'),
                'role' => 2,
                'employee_id' => 3,
            ],
        ];

        $task = [
            [
                'taskname' => 'Proyek A',
                'taskdescriptions' => 'Mengerjakan proyek A',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 2
            ],
            [
                'taskname' => 'Proyek B',
                'taskdescriptions' => 'Mengerjakan proyek B',
                'deadline' => '2023-12-31',
                'file' => 'project.pdf',
                'employee_id' => 2
            ],
        ];

        $performance = [
            [
                'employee_id' => 2,
                'task_id' => 1,
            ],
            [
                'employee_id' => 2,
                'task_id' => 1,
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
