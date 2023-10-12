<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {

    // }
    
    public function edit()
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
                '1' => 'Software Developer',
            ];
            
            $employee->position = $positions[$employee->position];
            
        } else {
            $positions = [
                null => 'Kepala Cabang',
            ];
            $employee->position = $positions[$employee->position];
        }

        if ($employee->role !== null) {
            $role = [
                '0' => 'Employee',
                '1' => 'Manager',
                '2' => 'Branch Manager',
            ];
            $employee->role = $role[$employee->role];
        }
        return view('dashboard.profile.main', [
            'employee' => $employee
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'image' => 'file|image|max:5048',
        ]);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $uploadedFile = $request->file('image');
            $imagename = time() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('post-images', $imagename);
            $user->image = $imagename;
            $user->save();
        }

        return redirect('/task');
    }
}
