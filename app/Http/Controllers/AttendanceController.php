<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position', 'employees.firstname', 'employees.lastname')
        ->where('users.id', auth()->user()->id)
        ->first();

        // Periksa apakah data pengguna dan karyawan ada atau tidak
        if (!$employee || !$employee->employee || auth()->user()->id !== $employee->id) {
        return redirect('/dashboard');
        }

        $attendances = Attendance::join('employees', 'attendances.employee_id', '=', 'employees.id')
        ->join('users', 'users.employee_id', '=', 'employees.id')
        ->select('attendances.id', 'attendances.employee_id', 'attendances.status', 'attendances.date',
        'attendances.in', 'attendances.out',
        'employees.firstname',
        'employees.lastname', 'employees.position',
        'users.role');

        $typeFilter = $request->input('type_filter');

        if (request()->query('type_filter') == 'attend'){
            if ($employee->role == 0 && $attendances-> status == 0){
                return redirect('/attendance');
            } elseif ($employee->role == 3) {
                return redirect('/attendance');
            } else {
                $attendances = $attendances->where('attendances.employee_id',
                auth()->user()->id)->orderByDesc('attendances.date');
            }
        } elseif (request()->query('type_filter') == '') {
            if ($employee->role == 3) {
                $attendances = $attendances->orderByDesc('attendances.date');
            } elseif ($employee->role == 2) {
                $attendances = $attendances->where('attendances.employee_id', auth()->user()->id)->orderByDesc('attendances.date');
            } elseif ($employee->role == 1) {
                $attendances = $attendances->where('attendances.employee_id', auth()->user()->id)->orderByDesc('attendances.date');
            } elseif ($employee->role == 0) {
                $attendances = $attendances->where('attendances.employee_id', auth()->user()->id)->orderByDesc('attendances.date');
            }
        } elseif ($typeFilter === 'employeelist') {
            if ($employee->role == 0){
                return redirect('/attendance');
            } elseif ($employee->role == 3){
                return redirect('/attendance');
            } elseif ($employee->role == 1) {
                $attendances = $attendances
                ->where('employees.position', $employee->position)
                ->where(function ($query) {
                $query->where('attendances.status', 1)
                ->orWhere('attendances.status', 2);
                })
                ->where('users.role', '<>', 1)
                    ->orderByDesc('attendances.date');
            } else {
                $attendances = $attendances
                    ->where('users.role', '!=', 3)
                    ->where('users.role', '!=', 2)
                    ->orderByDesc('attendances.date');
            }
        } else {
            $attendances = $attendances->where('attendances.employee_id',
            auth()->user()->id)->orderByDesc('attendances.date');
        }

        $attendances = $attendances->paginate(5)->withQueryString()->appends(request()->query());
        
        if ($employee->role !== null) {
            $role = [
                '0' => 'Employee',
                '1' => 'Manager',
                '2' => 'Branch Manager',
                '3' => 'Human Resource',
            ];
            $employee->role = $role[$employee->role];
        }
        return view('attendance.main', [
            'employee' => $employee,
            'attend' => $attendances,
            'typeFilter' => $typeFilter
        ]);
    }

    public function createattend()
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position', 'employees.firstname', 'employees.lastname')
        ->where('users.id', auth()->user()->id)
        ->first();

        // Periksa apakah data pengguna dan karyawan ada atau tidak
        if (!$employee->role == 3) {
            return redirect('/dashboard');
        }

        // Ambil semua pengguna dengan peran (role) 3 (karyawan) dan offdays
        $employees = User::leftJoin('offdays', 'users.employee_id', '=', 'offdays.employee_id')
            ->select('users.*', 'offdays.status', 'offdays.start', 'offdays.end')
            ->where('users.role', '!=', 3)->get();
            
        // Tanggal hari ini
        $today = now()->toDateString();

        $errorMessages = [];
        // Loop melalui daftar karyawan
        foreach ($employees as $employee) {
            try {
                // Periksa apakah karyawan memiliki offdays dan apakah status offdays adalah 2
                if (($today <= $employee->start || $employee->status == 2) && ($today <= $employee->end ||
                        $employee->status == 2)) {
                    Attendance::firstOrCreate([
                        'employee_id' => $employee->id,
                        'date' => $today,
                        'status' => 2,
                        'in' => date('Y-m-d 08:00:00'),
                        'out' => date('Y-m-d 17:00:00'),
                    ]);
                } else {
                    Attendance::firstOrCreate([
                        'employee_id' => $employee->id,
                        'date' => $today
                    ]);
                }
            } catch (\Exception $e) {
                // Tangani kesalahan jika entri sudah ada
                $errorMessages[] = "Attendance for {$employee->firstname} {$employee->lastname} already exists for today.";
            }
        }

        if (count($errorMessages) > 0) {
            return redirect('/attendance')->with('error', implode("<br>", $errorMessages));
        } else {
            return redirect('/attendance')->with('success', "Today's attendance has been successfully added");
        }
    }

    public function present($id)
    {
        $userrole = auth()->user()->role;
        // Tanggal hari ini
        $today = now()->toDateString();

        // Waktu saat ini
        $currentHour = now()->format('H:i:s');
        $lateThreshold = now()->setHour(9)->setMinute(0)->setSecond(0)->format('H:i:s');
        $timeover = now()->setHour(11)->setMinute(0)->setSecond(0)->format('H:i:s');
        $attendance = Attendance::find($id);
        $lateDiff = now()->diffInMinutes($lateThreshold);
        $hours = floor($lateDiff / 60);
        $minutes = $lateDiff % 60;

        if (($today == $attendance->date && $currentHour < $timeover) || $userrole == 3) {
            $attendance->update(['status' => 1, 'in' => $currentHour]);
            if ($currentHour > $lateThreshold && !$userrole == 3) {
                if ($lateDiff >= 60) {
                    return redirect('/attendance')->with('error',"You successfully presented attendance, but the
                    employee is late by $hours hours and
                    $minutes minutes.");
                } else {
                    return redirect('/attendance')->with('error',"You successfully presented attendance, but the
                    employee is late by $lateDiff minutes.");
                }
            } elseif ($userrole == 3) {
                if ($lateDiff >= 60) {
                return redirect('/attendance')->with('success', "You successfully presented attendance, but the employee
                is
                late by $hours hours and
                $minutes minutes.");
                } else {
                return redirect('/attendance')->with('success',"You successfully presented attendance, but the
                employee is late by $lateDiff minutes.");
                }
            } else {
                return redirect('/attendance')->with('success', "You have successfully presented your attendance at $currentHour.");
            }
        } else if ($today == $attendance->date && $currentHour > $timeover) {
            return redirect('/attendance')->with('error', "You unsuccessfully presented your attendance, because your are
        too late");
        } else {
            return redirect('/attendance')->with('error', "You unsuccessfully presented your attendance.");
        }
    }

    public function leave($id)
    {
        $userrole = auth()->user()->role;

        // Tanggal hari ini
        $today = now()->toDateString();

        // Waktu saat ini
        $currentHour = now();

        $attendance = Attendance::find($id);

        if ($today == $attendance->date || $userrole == 3) {
            // Menghitung durasi kerja
            $workDuration = $currentHour->diff($attendance->in);

            // Periksa apakah durasi kerja lebih dari 8 jam
            if ($workDuration->h >= 8 || $userrole == 3) {
                // Update status menjadi pulang (status 2) dan mengisi kolom 'out' dengan waktu saat ini
                $attendance->update(['status' => 2, 'out' => $currentHour->format('H:i:s')]);

                return redirect('/attendance')->with('success', "You have successfully presented your attendance at {$currentHour->format('H:i')}");
            } else {
                return redirect('/attendance')->with('error', "You unsuccessfully presented your attendance, because you worked only for {$workDuration->h} hours and {$workDuration->i} minutes.");
            }
        } else {
            return redirect('/attendance')->with('error', "You unsuccessfully presented your attendance.");
        }
    }
}
