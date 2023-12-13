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
        $this->call(EmployeesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(PerformanceSeeder::class);
        $this->call(PayrollSeeder::class);
        $this->call(BenefitsSeeder::class);
        $this->call(EmployeeBenefitsSeeder::class);
        $this->call(FacilitiesSeeder::class);
        $this->call(EmployeeFacilitySeeder::class);
        $this->call(OffdaysSeeder::class);
        $this->call(AttendanceSeeder::class);
    }
}
