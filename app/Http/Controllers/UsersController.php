<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{   
    public function profile()
    {
        // Mengambil data pengguna (user) berdasarkan ID dan menggabungkan data karyawan (employee)
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
            ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
            ->where('users.id', auth()->user()->id)
            ->first();

        // Periksa apakah data pengguna dan karyawan ada atau tidak
        if (!$employee || !$employee->employee || auth()->user()->id !== $employee->id) {
            return redirect('/employee');
        }

        if ($employee->position !== null) {
            $positions = [
                '0' => 'Business Analysis',
                '1' => 'Data Analyst',
                '2' => 'Data Scientist',
                '3' => 'Teller', 
                '4' => 'Auditor',  
                '5' => 'Staff',
                '6' => 'Sales',
                '7' => 'Akuntan',
                '8' => 'CS'
            ];
            
            $employee->position = $positions[$employee->position];
        } else {
            if ($employee->role === 2) {
                $positions = [
                    null => 'Kepala Cabang'
                ];
                $employee->position = $positions[null];
            } elseif ($employee->role === 3) {
                $positions = [
                    null => 'Human Resources'
                ];
                $employee->position = $positions[null];
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
        return view('dashboard.profile.main', [
            'employee' => $employee
        ]);
    }

    public function updateimage(Request $request, User $user)
    {
        $request->validate([
            'image' => 'required|file|image',
        ]);
        
        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete('public/images/' . $request->oldImage);
            }
            $uploadedFile = $request->file('image');
            $imagename = time() . '.' . $uploadedFile->getClientOriginalExtension();

            $uploadedFile->storeAs('images', $imagename);
            $user->image = $imagename;
            $user->save();
        }
        // Tambah ganti images
        return redirect("/dashboard/profile/$user->id/edit")->with("success","Your profile image has been successfully
        changed.");
    }

    public function create()
    {
        // Mengambil data pengguna (user) berdasarkan ID dan menggabungkan data karyawan (employee)
        $employee = Employee::join('users', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary',
        'users.role')
        ->where(function ($query) {
        $query->where('users.role', 0)->orWhere('users.role', 1);
        })
        ->get();

        return view('employee.createuser', [
            'employee' => $employee
        ]);
    }

    public function store(Request $request)
    {
        $validatedData1 = $request->validate([
            'username' => 'required|min:3|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:0,1',
            'password' => 'required|confirmed|min:8|max:255',
        ]);

        $validatedData2 = $request->validate([
            'firstname' => 'required|min:3|max:20|unique:employees',
            'lastname' => 'required|min:3|max:20|unique:employees',
            'position' => 'required|in:0,1,2,3,4,5,6,7,8',
        ]);

        // Simpan data pengguna baru
        $user = User::create($validatedData1);
        $employee = Employee::create($validatedData2);

        // Setel joining_date ke tanggal hari ini
        $employee->joining_date = now();
        $employee->save();
        
        // Hubungkan user dengan employee
        $user->employee_id = $employee->id;
        $user->save();

        // Simpan data payroll
        $payroll = new Payroll();
        $payroll->employee_id = $employee->id;
        $payroll->save();

        return redirect('/userlist')->with('success', 'New user has been added.');
    }

    public function list()
    {
        // Mengambil data pengguna (user) berdasarkan ID dan menggabungkan data karyawan (employee)
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
            ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary', 'users.role')
            ->where('users.id', auth()->user()->id)
            ->first();

        // Periksa apakah data pengguna memiliki peran (role) yang sesuai
        if (auth()->user()->role !== 3 && auth()->user()->role !== 2 && auth()->user()->role !== 1) {
            return redirect('/task');
        }
        
        // Jika peran employee adalah 1, maka ambil data karyawan dengan posisi yang sama
        if ($employee->role == 1) {
            $list = Employee::join('users', 'users.employee_id', '=', 'employees.id')
                ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary', 'users.role')
                ->where('employees.position', $employee->position) // Filter berdasarkan posisi yang sama
                ->where('users.role', 0) // Hanya role employee
                ->get();
        } elseif ($employee->role == 2) {
            // Jika bukan peran 1, maka ambil semua data karyawan dengan peran 0 dan 1
            $list = Employee::join('users', 'users.employee_id', '=', 'employees.id')
                ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary', 'users.role')
                ->where(function ($query) {
                    $query->where('users.role', 0)->orWhere('users.role', 1);
                })
                ->get();
        } else {
            $list = Employee::join('users', 'users.employee_id', '=', 'employees.id')
                ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary', 'users.role')
                ->where(function ($query) {
                    $query->whereNot('users.role', 3);
                })
                ->get();
        }
        // Mengganti posisi karyawan berdasarkan data yang sesuai
        $positions = [
            null => 'Branch Manager',
            0 => 'Business Analysis',
            1 => 'Data Analyst',
            2 => 'Data Scientist',
            3 => 'Teller',
            4 => 'Auditor',
            5 => 'Staff',
            6 => 'Sales',
            7 => 'Akuntan',
            8 => 'CS',
        ];

        $role = [
                '0' => 'Employee',
                '1' => 'Manager',
                '2' => 'Branch Manager',
                '3' => 'Human Resource',
            ];
        $employee->role = $role[$employee->role];

        foreach ($list as $lists) {
            $lists->position = $positions[$lists->position];
            if ($lists->role !== null) {
                $lists->role = $role[$lists->role];
            }
        }

        return view('employee.userlist', [
            'employee' => $employee,
            'list' => $list,
        ]);
    }

    public function edituser($id)
    {
        // Mengambil data pengguna (user) berdasarkan ID dan menggabungkan data karyawan (employee)
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position', 'users.role')
        ->where('users.id', auth()->user()->id)
        ->first();

        $list = DB::table('users')
            ->join('employees', 'users.employee_id', '=', 'employees.id')
            ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary', 'users.role')
            ->where('users.id', $id)
            ->first();

        // Periksa apakah data pengguna memiliki peran (role) yang sesuai
        if ($employee->role == 2 && $employee->role !== 3 && $employee->role !== 1) {
        return redirect('/userlist');
        }
        // Periksa apakah peran (role) employee adalah 1 dan posisi yang berbeda
        if ($employee->role == 1 && $employee->position != $list->position) {
            return redirect('/userlist');
        } elseif ($employee->role == 1 && $employee->role == $list->role) {
            return redirect('/userlist');
        } 

        return view('employee.edituser', [
                'list' => $list,
            ]);
    }

    public function userupdated(Request $request, $id)
    {
        $user = User::find($id);
        $employee = Employee::find($id);

        if (!$user || !$employee) {
            return redirect('/userlist')->with('error', 'User not found');
        }

        if ($request->input('username') !== null) {
            $request->validate(['username' => 'min:3|max:20|unique:users']);
            $user->update(['username' => $request->input('username')]);
        }

        if ($request->input('email') !== null) {
            $request->validate(['email' => 'email|email:dns|unique:users']);
            $user->update(['email' => $request->input('email')]);
        }

        if ($request->input('role') !== null) {
            $request->validate(['role' => 'in:0,1']);
            $user->update(['role' => $request->input('role')]);
        }

        if ($request->input('password') !== null) {
            $validatedData = $request->validate([
                'password' => 'required|same:password_confirmation|min:8|max:225',
                'password_confirmation' => 'required|same:password|min:8|max:225',
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);
            $user->update(['password' => $validatedData['password']]);
        }

        if ($request->input('position') !== null) {
            $request->validate(['position' => 'in:0,1,2,3,4,5,6,7,8,9']);
            $employee->update(['position' => $request->input('position')]);
        }

        return redirect('/userlist')->with('success', 'User edited successfully');
    }

    public function changepassword () {
        // Mengambil data pengguna (user) berdasarkan ID dan menggabungkan data karyawan (employee)
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position','employees.firstname', 'employees.lastname', 'users.role')
        ->where('users.id', auth()->user()->id)
        ->first();

        return view('dashboard.changepassword.main', [
        'employee' => $employee,
        ]);
    }
    public function change (Request $request, User $user) {
        if (auth()->user()->id != 3) {
            return redirect('/userlist')->with('error','You are not allowed to edit users');
        }
        $validatedData = $request->validate([
            'password' => 'required|same:password_confirmation|min:8|max:225',
            'password_confirmation' => 'required|same:password|min:8|max:225',
        ]);

        $user->update([
        'password' => Hash::make($validatedData['password']),
        ]);

        return redirect("/dashboard/changepassword/$user->id")->with('success', 'Your password has been changed
        successfully');
    }
    public function deleteuser($id) {
        if (auth()->user()->id != 3) {
            return redirect('/userlist')->with('error','You are not allowed to delete users');
        }
        User::where('id', $id)->delete();
        return redirect("/userlist")->with('success', 'The user has been deleted successfully');
    }
}
