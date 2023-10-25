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
        ->select('attendances.id', 'attendances.employee_id', 'attendances.status', 'attendances.date',
        'employees.firstname',
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
        // Ambil semua pengguna dengan peran (role) 3 (karyawan)
        $employees = User::whereNot('role', 3)->get();

        // Tanggal hari ini
        $today = now()->toDateString();

        $errorMessages = [];

        // Loop melalui daftar karyawan
        foreach ($employees as $employee) {
            try {
                Attendance::firstOrCreate([
                    'employee_id' => $employee->id,
                    'date' => $today
                ]);
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
        // Tanggal hari ini
        $today = now()->toDateString();

        $date = Attendance::where('id', $id)->first();

        if ($today == $date->date){
            Attendance::where('id', $id)
            ->update(['status' => 1]);
            return redirect('/attendance')->with('success',"You have successfully presented your attendance.");
        } else {
            return redirect('/attendance')->with('error',"You unsuccessfully presented your attendance.");
        }
    }
}
