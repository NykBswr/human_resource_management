<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Benefit;
use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BenefitsApplication;

class PayrollandBenefitController extends Controller
{
    public function index(Request $request)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position', 'employees.firstname', 'employees.lastname')
        ->where('users.id', auth()->user()->id)
        ->first();
        
        $performances = Performance::join('employees', 'performances.employee_id', '=', 'employees.id')
        ->where('employee_id', auth()->user()->id)->get();

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
            $userpayroll = Payroll::join('employees', 'payrolls.employee_id', '=', 'employees.id')
            ->join('users', 'users.employee_id', '=', 'employees.id')
            ->where('users.id', auth()->user()->id)
            ->first();
            $listbenefit = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=',
            'employees.id')->join('benefits','benefits_applications.benefit_id', '=',
            'benefits.id')
            ->where('employee_id',auth()->user()->id)->get();
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
            'performances' => $performances,
            'typeFilter'=> $typeFilter,
            'benefitsFilter'=> $benefitsFilter,
            'payroll' => $userpayroll,
            'listbenefit' => $listbenefit
        ]);
    }

    public function formapply ()
    {
        $user = auth()->user();

        if ($user->role == 3) {
            $employeeid = DB::table('users')
                ->join('employees', 'users.employee_id', '=', 'employees.id')
                ->select('users.employee_id', 'employees.*')
                ->where('users.role', '!=', 3)
                ->get();
            $benefit = Benefit::all();
        } else {
            $employeeid = DB::table('users')
                ->join('employees', 'users.employee_id', '=', 'employees.id')
                ->select('users.employee_id', 'employees.*')
                ->where('users.id', $user->id)
                ->first();
            $benefit = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=',
            'employees.id')->join('benefits','benefits_applications.benefit_id', '=',
            'benefits.id')
            ->where('employee_id',auth()->user()->id)->get();
        }

        return view('payrollandbenefits.applybenefitform', [
            'employeeid' => $employeeid,
            'benefit' => $benefit
        ]);
    }

    public function apply(Request $request)
    {
        // Ambil data benefit user
        $benefituser = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=', 'employees.id')
            ->join('benefits', 'benefits_applications.benefit_id', '=', 'benefits.id')
            ->where('employee_id', auth()->user()->id)
            ->first(); // Menggunakan first() karena kita hanya butuh satu baris

        $this->validate($request, [
            'employee_id' => 'required',
            'benefit_id' => 'required',
            'requested_amount' => 'required',
        ]);

        // Bandingkan amount yang diinput dengan benefit user
        if ($request->input('requested_amount') > $benefituser->amount) {
            return redirect()->back()->with('error', 'Amount exceeds available benefit.');
        }

        $benefit = new BenefitsApplication;
        $benefit->employee_id = $request->input('employee_id');
        $benefit->benefit_id = $request->input('benefit_id');
        $benefit->amount = $request->input('requested_amount');
        $benefit->status = 1;
        $benefit->save();

        if (auth()->user()->role == 3) {
            return redirect('/PayrollandBenefit?benefitsFilter=employeebenefits&type_filter=benefit')
                ->with('success', 'The application submitted successfully.');
        } else {
            return redirect('/PayrollandBenefit')
                ->with('success', 'The application submitted successfully.');
        }
    }
}
