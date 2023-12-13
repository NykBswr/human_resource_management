<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BenefitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
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

        foreach ($benefits as $benefitsData) {
        \App\Models\Benefit::create($benefitsData);
        }
    }
}
