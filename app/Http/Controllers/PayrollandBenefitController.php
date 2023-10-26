<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PayrollandBenefitController extends Controller
{
    public function index(Request $request)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position', 'employees.firstname', 'employees.lastname')
        ->where('users.id', auth()->user()->id)
        ->first();

        // Menambahkan filter tipe surat
        $typeFilter = $request->input('type_filter');
        $benefitsFilter = $request->input('benefitsFilter');

        if ($employee->role !== null) {
            $role = [
            '0' => 'Employee',
            '1' => 'Manager',
            '2' => 'Branch Manager',
            '3' => 'Human Resource',
        ];
            $employee->role = $role[$employee->role];
        }

        return view('payrollandbenefits.main', [
            'employee' => $employee,
            'typeFilter'=> $typeFilter,
            'benefitsFilter'=> $benefitsFilter
        ]);
    }
}
