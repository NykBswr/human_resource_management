<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\BenefitsApplication;
use App\Models\Employee;
use App\Models\User;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $userpayroll = null;
        $listbenefit = null;

        if (auth()->user()->role == 3) {
            if ($typeFilter == 'payroll' ||request()->query('type_filter') == '') {
                $userpayroll = DB::table('employees')
                    ->select('employees.id as employee_id', 'employees.firstname', 'employees.lastname',
                        'employees.position',
                        'users.role', 'payrolls.id', 'payrolls.salary_amount', 'payrolls.status', 'payrolls.tax_deduction',
                        'payrolls.payment_date')
                    ->leftJoin('users', 'employees.id', '=', 'users.employee_id')
                    ->leftJoin('payrolls', 'payrolls.employee_id', '=', 'employees.id')
                    ->whereNotIn('users.role', [3])
                    ->get();
            } elseif ($typeFilter == 'benefit') {
                if ($benefitsFilter == 'benefitlist' || $benefitsFilter == '') {
                    $listbenefit = Benefit::all();
                } else {
                    $listbenefit = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=',
                        'employees.id')->join('users', 'employees.id', '=',
                        'users.employee_id')->join('benefits','benefits_applications.benefit_id', '=',
                        'benefits.id')->select('benefits_applications.*', 'employees.firstname',
                        'employees.lastname', 'users.role',
                        'employees.position', 'benefits.benefit_name', 'benefits.benefit_amount')
                        ->whereNotIn('users.role', [3])->get();

                    // $employeebenefit = [];
                    // foreach ($listbenefit as $data) {
                    //     $employeeId = $data->employee_id;

                    //     // Jika karyawan belum ada dalam $employeefacilities, tambahkan
                    //     if (!array_key_exists($employeeId, $employeebenefit)) {
                    //         $employeefacilities[$employeeId] = [
                    //             'employees' => $data->employee_id,
                    //             'employee_benefit_id' => $data->employee_facility_id,
                    //             'firstname' => $data->firstname,
                    //             'lastname' => $data->lastname,
                    //             'position' => $data->position,
                    //             'role' => $data->role,
                    //             'benefits' => [],
                    //         ];
                    //     }

                    //     // Tambahkan fasilitas ke dalam daftar fasilitas karyawan
                    //     if (!in_array($data->facility_name, $employeefacilities[$employeeId]['facilities'])) {
                    //         $employeefacilities[$employeeId]['facilities'][] = $data->facility_name;
                    //     }
                    // }
                }
            }
        } else {
            if ($typeFilter == 'payroll') {
                $userpayroll = Payroll::join('employees', 'payrolls.employee_id', '=', 'employees.id')
                ->join('users', 'payrolls.employee_id', '=', 'users.employee_id')
                ->select('payrolls.*', 'employees.firstname', 'employees.lastname', 'users.role',
                'employees.position')->where('employee_id',auth()->user()->id)->get();
            } else {
                $listbenefit = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=',
                'employees.id')->join('users', 'employees.id', '=',
                'users.employee_id')->select('benefits_applications.*', 'employees.firstname',
                'employees.lastname', 'users.role',
                'employees.position')->where('employee_id',auth()->user()->id)->get();
            }
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

        return view('payrollandbenefits.main', [
            'employee' => $employee,
            'typeFilter'=> $typeFilter,
            'benefitsFilter'=> $benefitsFilter,
            'payroll' => $userpayroll,
            'listbenefit' => $listbenefit
        ]);
    }
}
