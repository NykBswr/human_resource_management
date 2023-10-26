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
                }
            }
        } else {
            $userpayroll = Payroll::join('employees', 'payrolls.employee_id', '=', 'employees.id')
            ->join('users', 'users.employee_id', '=', 'employees.id')
            ->where('users.id', auth()->user()->id)
            ->first();
            if ($benefitsFilter == 'application'){
                $listbenefit = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=',
                'employees.id')
                ->join('benefits', 'benefits_applications.benefit_id', '=', 'benefits.id')
                ->where('employee_id', auth()->user()->id)
                ->where('status', '!=', 0)
                ->get();
            } else {
                $listbenefit = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=',
                'employees.id')->join('benefits','benefits_applications.benefit_id', '=',
                'benefits.id')
                ->where('employee_id',auth()->user()->id)->get();
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
        if (auth()->user()->role == 3){
            $benefituser = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=',
            'employees.id')
            ->join('benefits', 'benefits_applications.benefit_id', '=', 'benefits.id')
            ->where('employee_id', $request->input('employee_id'))
            ->orWhere('benefits.id', $request->input('benefit_id'))
            ->first();
        } else {
            // Ambil data benefit user
            $benefituser = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=',
            'employees.id')
            ->join('benefits', 'benefits_applications.benefit_id', '=', 'benefits.id')
            ->where('employee_id', auth()->user()->id)
            ->first();
        }

        $this->validate($request, [
            'employee_id' => 'required',
            'benefit_id' => 'required',
            'requested_amount' => 'required',
            'info' => 'required|file|mimes:pdf,doc,docx,png,jpg|max:2048',
        ]);

        // Bandingkan amount yang diinput dengan benefit user
        if ($request->input('requested_amount') > $benefituser->amount) {
            return redirect()->back()->with('error', 'Amount exceeds available benefit.');
        }

        if ($request->hasFile('info')) {
            $file = $request->file('info');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('Proof of Benefit Request', $fileName);
        }

        BenefitsApplication::where('employee_id', $request->input('employee_id'))
        ->where('benefit_id', $request->input('benefit_id'))
        ->update([
            'requested_amount' => $request->input('requested_amount'),
            'info' => $fileName,
            'status' => 1
        ]);

        if (auth()->user()->role == 3) {
            return redirect('/PayrollandBenefit?benefitsFilter=employeebenefits&type_filter=benefit')
                ->with('success', 'The application submitted successfully.');
        } else {
            return redirect('/PayrollandBenefit')
                ->with('success', 'The application submitted successfully.');
        }
    }

    public function acceptedapplication($id)
    {
        $user = auth()->user();

        if ($user->role != 3) {
            return redirect('/PayrollandBenefit');
        } 

        $benefit = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=',
            'employees.id')->join('benefits','benefits_applications.benefit_id', '=',
            'benefits.id')
            ->where('benefits_applications.id',$id)->first();
        
        return view('payrollandbenefits.acc', [
            'benefit' => $benefit,
            'id' => $id
        ]);
    }

    public function process($id, Request $request){
        $benefit = BenefitsApplication::join('employees', 'benefits_applications.employee_id', '=', 'employees.id')
            ->join('benefits', 'benefits_applications.benefit_id', '=', 'benefits.id')
            ->where('benefits_applications.id', $id)
            ->first();

        if ($request->has('decline')){
            // Jika iya, maka update aplikasi manfaat dengan status penolakan
            BenefitsApplication::where('id', $id)->update([
                'requested_amount' => null,
                'info' => null,
                'status' => 3
            ]);
            return redirect('/PayrollandBenefit?type_filter=benefit&benefitsFilter=employeebenefits')->with('success',
            'The benefit has been successfully declined.');
        } else {
            // Jika tidak ada parameter 'decline', maka lakukan perubahan gaji karyawan dan jumlah manfaat
            Employee::where('id', $benefit->employee_id)->update([
                'salary' => $benefit->employee->salary + $benefit->requested_amount,
            ]);

            // Menghitung jumlah manfaat baru setelah dikurangi jumlah yang diminta
            $newAmount = $benefit->amount - $benefit->requested_amount;

            // Update aplikasi manfaat dengan jumlah yang diminta yang diatur menjadi 'null', info menjadi 'null', dan status menjadi '2'
            BenefitsApplication::where('id', $id)->update([
                'requested_amount' => null,
                'info' => null,
                'amount' => $newAmount,
                'status' => 2
            ]);
            return redirect('/PayrollandBenefit?type_filter=benefit&benefitsFilter=employeebenefits')->with('success',
            'The benefit has been successfully accepted.');
        }
    }

    public function editbenefit($id){
        $benefit = Benefit::where('benefits.id', $id)
        ->first();
        
        return view('payrollandbenefits.editbenefit', [
            'id' => $id,
            'benefit' => $benefit
        ]);
    }
    public function edited($id, Request $request)
    {
        if ($request->input('benefit_name') != null) {
            Benefit::where('id', $id)->update([
                'benefit_name' => $request->input('benefit_name')
            ]);
        }
        if ($request->input('benefit_amount') != null) {
            Benefit::where('id', $id)->update([
                'benefit_amount' => $request->input('benefit_amount')
            ]);
        }
        return redirect('/PayrollandBenefit?type_filter=benefit')->with('success','The benefit has been successfully edited.');
    }

    public function delete($id)
    {
        Benefit::where('id', $id)->delete();
        return redirect('/PayrollandBenefit?type_filter=benefit')->with('success','The benefit has been successfully deleted.');
    }
    
}
