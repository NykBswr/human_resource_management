<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PerformanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        foreach ($performance as $performanceData) {
            \App\Models\Performance::create($performanceData);
        }

        $faker = Faker::create();

        for ($i = 11; $i < 80; $i++) {
            \App\Models\Performance::create([
                'rating' => $faker->numberBetween(1, 10),
                'feedback' => $faker->sentence,
                'employee_id' => $i-1,
                'task_id' => $i+2,
            ]);
        }
        for ($i = 80; $i < 102; $i++) {
            \App\Models\Performance::create([
                'employee_id' => $i-1,
                'task_id' => $i+2,
            ]);
        }
    }
}
