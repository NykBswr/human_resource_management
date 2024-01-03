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
        $endDate = date('Y-m-d');

        for ($i = 1; $i <= 100; $i++) {
            if ($i !== 11) {
                for ($currentDate = strtotime($startDate); $currentDate <= strtotime($endDate); $currentDate = strtotime('+1 day', $currentDate)) {
                    $date = date('Y-m-d', $currentDate);

                    $status = $faker->optional(0.25, 2)->randomElement([1, 2]);

                    // $inTime = $faker->dateTimeBetween($date . ' 07:00:00', $date . ' 11:00:00')->format('H:i:s');
                    $inTime = $faker->dateTimeBetween($date . ' 07:00:00', $date . ' 11:00:00');

                    if ($faker->optional(0.8)->boolean()) {
                        $inTime->setTime(mt_rand(9, 10), mt_rand(0, 59), mt_rand(0, 59));
                    } else {
                        $inTime->setTime(mt_rand(7, 8), mt_rand(0, 59), mt_rand(0, 59));
                    }

                    $inTime = $inTime->format('H:i:s');

                    $outTime = date('H:i:s', strtotime($inTime) + mt_rand(8, 11) * mt_rand(0, 59) * mt_rand(0, 59));

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
}
