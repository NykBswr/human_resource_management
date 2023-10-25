<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
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
        return redirect('/task');
        }

        $attendances = Attendance::join('employees', 'attendances.employee_id', '=', 'employees.id')
        ->join('users', 'users.employee_id', '=', 'employees.id')
        ->select('attendances.id', 'attendances.employee_id', 'attendances.date', 'employees.firstname',
        'employees.lastname', 'employees.position',
        'users.role');

        $typeFilter = $request->input('type_filter');

        if ($employee->role == 0 && $typeFilter === 'attend') {
            return redirect('/attendance');
        } elseif ($employee->role == 3 && $typeFilter === 'attend') {
            return redirect('/attendance');
        } elseif ($employee->role == 0 && $typeFilter === '' || $employee->role == 0){
            $attendances = $attendances->where('attendances.employee_id', auth()->user()->id)->get();
        } elseif ($employee->role == 3 && $typeFilter === '' || $employee->role == 3) {
            $attendances = $attendances->get();
        } elseif ($typeFilter === 'attend' || $typeFilter === '') {
            $attendances = $attendances->where('attendances.employee_id', auth()->user()->id)->get();
        } elseif ($typeFilter === 'employeelist') {
            if ($employee->role == 0){
                return redirect('/attendance');
            } elseif ($employee->role == 3){
                return redirect('/attendance');
            } elseif ($employee->role == 1) {
                $attendances = $attendances->where('employees.position', $employee->position)->get();
            } else {
                $attendances = $attendances
                    ->where('users.role', '!=', 3)
                    ->where('users.role', '!=', 2)
                    ->get();
            }
        } else {
            $attendances = $attendances->where('attendances.employee_id', auth()->user()->id)->get();
        }

        return view('attendance.main', [
            'employee' => $employee,
            'attend' => $attendances,
            'typeFilter' => $typeFilter
        ]);
    }

    public function createattend()
    {
        // Ambil semua pengguna dengan peran (role) 3 (karyawan)
        $employees = User::whereNot('role', 3)->get();

        // Tanggal hari ini
        $today = now()->toDateString();

        // Loop melalui daftar karyawan dan masukkan ke dalam tabel attendance
        foreach ($employees as $employee) {
        Attendance::create([
                'employee_id' => $employee->id,
                'date' => $today
            ]);
        }
        
        return redirect('/attendance')->with('success',"Today's attendance has been successfully added");
    }
}
