<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            return redirect('/dashboard');
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
            Storage::delete($request->oldImage);
            $uploadedFile = $request->file('image');
            $imagename = time() . '.' . $uploadedFile->getClientOriginalExtension();

            $uploadedFile->storeAs('images', $imagename);
            $user->image = $imagename;
            $user->save();
        }

        return redirect("/dashboard/profile/$user->id/edit"); // Mengubah URL dengan variabel user->id
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

        return view('dashboard.createuser', [
            'employee' => $employee
        ]);
    }

    public function store(Request $request)
    {
        $validatedData1 = $request->validate([
            'username' => 'required|min:3|max:20|unique:users',
            'email' => 'required|email|email:dns|unique:users',
            'role' => 'in:0,1',
            'password' => 'required|same:password_confirmation|min:8|max:225',
            'password_confirmation' => 'required|same:password|min:8|max:225',
        ]);
        $validatedData2 = $request->validate([
            'firstname' => 'required|min:3|max:20|unique:employees',
            'lastname' => 'required|min:3|max:20|unique:employees',
            'position' => 'in:1,2,3,4,5,6,7,8,9',
        ]);
        // Simpan data pengguna baru
        $user = User::create($validatedData1);
        $employee = Employee::create($validatedData2);

        // Hubungkan user dengan employee
        $user->employee()->associate($employee);
        $user->save();

        event(new Registered($user));
        event(new Registered($employee));

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
        if ($employee->role == 2 && $employee->role !== 3 && $employee->role !== 1) {
            return redirect('/dashboard');
        }
        
        // Jika peran employee adalah 1, maka ambil data karyawan dengan posisi yang sama
        if ($employee->role == 1) {
            $list = Employee::join('users', 'users.employee_id', '=', 'employees.id')
                ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary', 'users.role')
                ->where('employees.position', $employee->position) // Filter berdasarkan posisi yang sama
                ->where('users.role', 0) // Hanya role employee
                ->get();
        } else {
            // Jika bukan peran 1, maka ambil semua data karyawan dengan peran 0 dan 1
            $list = Employee::join('users', 'users.employee_id', '=', 'employees.id')
                ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary', 'users.role')
                ->where(function ($query) {
                    $query->where('users.role', 0)->orWhere('users.role', 1);
                })
                ->get();
        }

        // Mengganti posisi karyawan berdasarkan data yang sesuai
        $positions = [
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
            if ($lists->position !== null) {
                $lists->position = $positions[$lists->position];
            }
            if ($lists->role !== null) {
                $lists->role = $role[$lists->role];
            }
        }

        return view('dashboard.userlist', [
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

        return view('dashboard.edituser', [
                'list' => $list,
            ]);
    }

    public function userupdated(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'min:3|max:20|unique:users',
            'email' => 'email|email:dns|unique:users',
            'role' => 'in:0,1',
            'position' => 'in:1,2,3,4,5,6,7,8,9',
            'password' => 'required|same:password_confirmation|min:8|max:225',
            'password_confirmation' => 'required|same:password|min:8|max:225',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        
        // Mengambil pengguna berdasarkan ID yang diberikan.
        $user = User::find($id);
        $employee = Employee::find($id);

        if (!$user) {
            return redirect('/userlist')->with('error', 'User not found');
        }

        $user->update([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'password' => $validatedData['password'],
        ]);

        $employee->update(['position' => $validatedData['position']]);

        return redirect('/userlist')->with('success', 'User edited successfully');
    }
}
