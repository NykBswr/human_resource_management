<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offdays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OffdaysController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Mengambil data pengguna (user) berdasarkan ID dan menggabungkan data karyawan (employee)
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
            ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
            ->where('users.id', $user->id)
            ->first();

        if (!$employee || !$employee->employee || auth()->user()->id !== $employee->id) {
        return redirect('/task');
        }

        // Query Offdays dengan join
        $offdayQuery = Offdays::join('employees', 'offdays.employee_id', '=', 'employees.id')
            ->join('users', 'offdays.employee_id', '=', 'users.employee_id')
            ->select('offdays.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'users.role');

        // Menambahkan filter tipe surat
        $typeFilter = $request->input('type_filter');

        if ($typeFilter === 'pending') {
            $offdayQuery = $offdayQuery->where(function ($query) {
                $query->where('status', null)->orWhere('status', 0);
            });
        } elseif ($typeFilter === 'approve') {
            $offdayQuery = $offdayQuery->where('status', 1);
        } elseif ($typeFilter === 'refuse') {
            $offdayQuery = $offdayQuery->where('status', 2);
        } else {
            $offdayQuery = $offdayQuery->where(function ($query) {
                $query->where('status', null)->orWhere('status', 0);
            });
        }

        // Filter berdasarkan role pengguna
        if ($user->role !== 3) {
            $offdayQuery = $offdayQuery->where('offdays.employee_id', $user->employee_id);
        }

        $offday = $offdayQuery->get();

        // Menyesuaikan role dengan label
        $roleLabels = [
            '0' => 'Employee',
            '1' => 'Manager',
            '2' => 'Branch Manager',
            '3' => 'Human Resource',
        ];

        $employee->role = $roleLabels[$user->role];

        return view('offdays.main', [
            'employee' => $employee,
            'offday' => $offday,
            'typeFilter' => $typeFilter,
        ]);
    }

    public function applications()
    {
        $user = auth()->user();

        if ($user->role == 3) {
            $employeeid = DB::table('users')
                ->join('employees', 'users.employee_id', '=', 'employees.id')
                ->select('users.employee_id', 'employees.*')
                ->where('users.role', '!=', 3)
                ->get();
        } else {
            $employeeid = DB::table('users')
                ->join('employees', 'users.employee_id', '=', 'employees.id')
                ->select('users.employee_id', 'employees.*')
                ->where('users.id', $user->id)
                ->first();
        }

        return view('offdays.application', [
            'employeeid' => $employeeid
        ]);
    }
    public function addoffdays(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required',
            'reason' => 'required',
            'start' => 'required|date|after:today',
            'end' => 'required|date|after:start',
            'info' => 'required|file|mimes:pdf,doc,docx,png,jpg|max:2048',
        ]);
        
        $offday = new Offdays;
        $offday->employee_id = $request->input('employee_id');
        $offday->reason = $request->input('reason');
        $offday->start = $request->input('start');
        $offday->end = $request->input('end');
        
        if ($request->hasFile('info')) {
            $file = $request->file('info');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            // $file->move(public_path('uploads'), $fileName); 
            $file->storeAs('Proof of Leave Application', $fileName);
            $offday->info = $fileName;
        }
        $offday->save();

        return redirect('/offdays')->with('success', 'The application submitted successfully.');
    }
    public function refuse($id)
    {
        Offdays::where('id', $id)->update(['status' => 2]);

        return redirect('/offdays?type_filter=refuse')->with('success', 'The application has been successfully
        refused.');
    }
    public function approve($id)
    {
        Offdays::where('id', $id)->update(['status' => 1]);

        return redirect('/offdays?type_filter=approve')->with('success', 'The application has been successfully
        approved.');
    }
}
