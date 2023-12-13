<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        foreach ($task as $taskData) {
            \App\Models\Task::create($taskData);
        }

        $faker = Faker::create();

        for ($i = 10; $i < 80; $i++) {
            \App\Models\Task::create([
                'taskname' => $faker->sentence,
                'deadline' => $faker->dateTimeBetween('-6 month', 'now')->format('Y-m-d'),
                'file' => 'project.pdf',
                'submitfile' => 'project.pdf',
                'progress' => $faker->numberBetween(1, 3),
                'employee_id' => $i,
            ]);
        }
        for ($i = 80; $i < 101; $i++) {
            \App\Models\Task::create([
                'taskname' => $faker->sentence,
                'deadline' => $faker->dateTimeBetween('-6 month', 'now')->format('Y-m-d'),
                'file' => 'project.pdf',
                'progress' => null,
                'employee_id' => $i,
            ]);
        }
    }
}
