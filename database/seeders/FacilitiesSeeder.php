<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $facilities = [
            [
                // Facility 1
                'facility_name' => 'Honda Brio',
                'remain' => $faker->numberBetween(20, 100),
            ],
            [
                // Facility 2
                'facility_name' => 'Honda Vario',
                'remain' => $faker->numberBetween(20, 100),
            ],
            [
                // Facility 3
                'facility_name' => 'Toyota Alphard',
                'remain' => $faker->numberBetween(20, 100),
            ],
            [
                // Facility 4
                'facility_name' => 'Toyota Inova',
                'remain' => $faker->numberBetween(20, 100),
            ],
            [
                // Facility 5
                'facility_name' => 'Honda PCX',
                'remain' => $faker->numberBetween(20, 100),
            ],
        ];

        foreach ($facilities as $facilitiesData) {
            \App\Models\Facility::create($facilitiesData);
        }
    }
}
