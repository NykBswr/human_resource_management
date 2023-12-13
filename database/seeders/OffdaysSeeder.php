<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OffdaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i < 11; $i++) { $randomEmployee=[
            'employee_id' => $i,
            'reason' => $faker->sentence,
            'start' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'), 
            'end' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'status' => $faker->numberBetween(1, 2),
            'info' => 'project.pdf',
        ];
            \App\Models\Offdays::create($randomEmployee);
        }

        for ($i = 12; $i < 50; $i++) { $randomEmployee2=[ 
            'employee_id'=> $i,
            'reason' => $faker->sentence,
            'start' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'end' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'status' => $faker->numberBetween(1, 2),
            'info' => 'project.pdf',
        ];
            \App\Models\Offdays::create($randomEmployee2);
        }
    }
}
