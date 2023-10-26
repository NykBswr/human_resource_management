<?php

namespace App\Console;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $userpayrolls = Payroll::join('employees', 'payrolls.employee_id',
            'employees.id')->join('users', 'payrolls.employee_id', '=',
            'users.employee_id')->whereNotNull('employees.joining_date')
            ->where('users.role', '<>', 3)
                ->get();
            
            foreach ($userpayrolls as $userpayroll) {
                // Ambil tanggal payment_date dan joining_date
                $paymentDate = $userpayroll->payment_date;
                $joiningDate = $userpayroll->joining_date;

                if ($paymentDate && $joiningDate) {
                    // Hitung selisih dalam hari
                    $diffInDays = $paymentDate->diffInDays($joiningDate);
                    
                    if ($diffInDays > 30) {
                        // Tambahkan 30 hari ke payment_date
                        $newPaymentDate = $paymentDate->addDays(30);

                        // Simpan kembali ke database
                        $userpayroll->payment_date = $newPaymentDate;
                        $userpayroll->save();
                    }
                }
            }
        })->dailyAt('00:30'); ;
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
