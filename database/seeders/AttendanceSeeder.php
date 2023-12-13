<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $startDate = '2023-10-26';
        $endDate = '2023-12-12';

        for ($i = 1; $i < 100; $i++) {
            for ($currentDate = strtotime($startDate); $currentDate <= strtotime($endDate); $currentDate = strtotime('+1 day', $currentDate)) {
                $date = date('Y-m-d', $currentDate);

                $status = $faker->optional(0.9, 1)->randomElement([1, 2]);

                $inTime = $faker->dateTimeBetween($date . ' 08:00:00', $date . ' 11:00:00')->format('H:i:s');
                $outTime = date('H:i:s', strtotime($inTime) + 6 * 60 * 60);

                $randomEmployee = [
                    'employee_id' => $i,
                    'date' => $date,
                    'status' => $status,
                    'in' => $inTime,
                    'out' => $status == 1 ? null : $outTime,
                ];

                \App\Models\Attendance::create($randomEmployee);
            }
        }
    }
}
