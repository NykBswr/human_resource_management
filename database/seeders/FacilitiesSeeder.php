<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        foreach ($facilities as $facilitiesData) {
            \App\Models\Facility::create($facilitiesData);
        }
    }
}
