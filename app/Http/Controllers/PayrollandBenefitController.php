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
        $payrollFilter = $request->input('payrollFilter');
        
        $userpayroll = null;
        $listbenefit = null;

        if (auth()->user()->role == 3) {
            if ($typeFilter == 'payroll' || request()->query('type_filter') == '') {
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
            'payrollFilter' => $payrollFilter,
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
            'requested_amount' => 'integer|required',
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
        $existingBenefit = Benefit::where('benefit_name', $request->input('benefit_name'))
            ->where('id', '!=', $id)
            ->first();

        if ($existingBenefit) {
            return redirect('/PayrollandBenefit/editbenefit/' . $id)
                ->with('error', 'Benefit name already exists.');
        }

        $updates = [];

        if ($request->input('benefit_name') !== null) {
            $updates['benefit_name'] = $request->input('benefit_name');
        }

        if ($request->input('benefit_amount') !== null) {
            $updates['benefit_amount'] = $request->input('benefit_amount');
        }

        if (!empty($updates)) {
            Benefit::where('id', $id)->update($updates);
        }

        return redirect('/PayrollandBenefit?type_filter=benefit')
            ->with('success', 'The benefit has been successfully edited.');
    }
    public function delete($id)
    {
        Benefit::where('id', $id)->delete();
        return redirect('/PayrollandBenefit?type_filter=benefit')->with('success','The benefit has been successfully deleted.');
    }
    
    public function addbenefit()
    {
        return view('payrollandbenefits.addbenefit');
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'benefit_name' => 'required',
            'benefit_amount' => 'required'
        ]);
        
        $existingBenefit = Benefit::where('benefit_name', $request->input('benefit_name'))
            ->first();

        if ($existingBenefit) {
            return redirect('/PayrollandBenefit/addbenefit')
                ->with('error', 'Benefit name already exists.');
        }

        $benefit = new Benefit;
        $benefit->benefit_name = $request->input('benefit_name');
        $benefit->benefit_amount = $request->input('benefit_amount');
        
        $benefit->save();

        return redirect('/PayrollandBenefit?type_filter=benefit')->with('success','The benefit has been successfully
        added.');
    }

    public function editpayroll($id){
        $payroll = Payroll::where('payrolls.id', $id)
        ->first();
        
        if (auth()->user()->role == 3) {
            $employeeid = DB::table('users')
            ->join('employees', 'users.employee_id', '=', 'employees.id')
            ->select('users.employee_id', 'employees.*', 'users.role')
            ->where('employees.id', $payroll->employee_id)
            ->first();
        } 
        
        return view('payrollandbenefits.editpayroll', [
            'id' => $id,
            'payroll' => $payroll,
            'employeeid' => $employeeid
        ]);
    }
    public function editedpay($id, Request $request)
    {
        $updates = [];

        if ($request->input('salary_amount') !== null) {
            $salaryAmount = $request->input('salary_amount');

            if (!is_numeric($salaryAmount) || $salaryAmount <= 0) {
                return redirect('/PayrollandBenefit')
                    ->with('error', 'Invalid salary amount. Please enter a valid amount.');
            }

            $updates['salary_amount'] = $salaryAmount;
        }

        if ($request->input('tax_deduction') !== null) {
            $taxDeduction = $request->input('tax_deduction');

            if (!is_numeric($taxDeduction) || $taxDeduction < 0) {
                return redirect('/PayrollandBenefit')
                    ->with('error', 'Invalid tax deduction. Please enter a valid amount.');
            }

            $updates['tax_deduction'] = $taxDeduction;
        }

        if (!empty($updates)) {
            Payroll::where('id', $id)->update($updates);
        }

        return redirect('/PayrollandBenefit')
            ->with('success', 'The payroll has been successfully edited.');
    }

    public function formapplypay()
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

        return view('payrollandbenefits.applypayrollform', [
            'employeeid' => $employeeid,
        ]);
    }

    public function applypay(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'employee_id' => 'required',
            'request_amount' => 'required|integer',
        ]);

        if ($user->role == 3) {
            $payrolluser = Payroll::join('employees', 'payrolls.employee_id', '=', 'employees.id')
                ->where('employee_id', $request->input('employee_id'))
                ->first();
        } else {
            $payrolluser = Payroll::join('employees', 'payrolls.employee_id', '=', 'employees.id')
                ->where('employee_id', $user->id)
                ->first();
        }

        if (!$payrolluser) {
            return redirect()->back()->with('error', 'Invalid employee or payroll record.');
        }

        // Bandingkan amount yang diinput dengan salary_amount
        if ($request->input('request_amount') <= $payrolluser->salary_amount) {
            return redirect()->back()->with('error', 'The requested is lower than your current salary.');
        }

        Payroll::where('employee_id', $request->input('employee_id'))
            ->update([
                'request_amount' => $request->input('request_amount'),
                'status' => 1
            ]);

        return redirect('/PayrollandBenefit')
            ->with('success', 'The application has been submitted successfully.');
    }


    public function accepterequest($id)
    {
        $user = auth()->user();

        if ($user->role != 3) {
            return redirect('/PayrollandBenefit');
        } 

        $payrolluser = Payroll::join('employees', 'payrolls.employee_id', '=', 'employees.id')
            ->where('payrolls.id', $id)
            ->first();
        
        return view('payrollandbenefits.accrequested', [
            'payrolluser' => $payrolluser,
            'id' => $id
        ]);
    }

    public function accept($id, Request $request){
        $user = auth()->user();
        $payroll = Payroll::where('id', $id)->first();
        
        if ($user->role != 3 || $payroll->status != 1) {
            return redirect('/PayrollandBenefit');
        } 
        
        if ($request->has('decline')){
            Payroll::where('id', $id)->update([
                'status' => 3
            ]);
            return redirect('/PayrollandBenefit')->with('success',
            'The request has been successfully declined.');

        } else {
            $newAmount = $payroll->request_amount;
            Payroll::where('id', $id)->update([
                'salary_amount' => $newAmount,
                'status' => 2
            ]);
            
            return redirect('/PayrollandBenefit')->with('success',
            'The request has been successfully accepted.');
        }
    }
}
