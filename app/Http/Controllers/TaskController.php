<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        if ($employee->role !== null) {
            $role = [
            '0' => 'Employee',
            '1' => 'Manager',
            '2' => 'Branch Manager',
        ];
            $employee->role = $role[$employee->role];
        }

        $tasks = DB::table('tasks')
            ->join('employees', 'tasks.employee_id', '=', 'employees.id')
            ->select('tasks.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
            ->get();

        // Memeriksa role (posisi) dari employee
        if ($employee->position === 0) {
            // Jika role employee == 0, tampilkan hanya task dengan ID yang sesuai
            $tasks = $tasks->where('employee_id', auth()->user()->id);
        } elseif ($employee->position === 1) {
            // Jika role employee == 1, tampilkan task dengan posisi yang sama dengan posisi karyawan
            $tasks = $tasks->where('position', $employee->position);
        }

        return view('dashboard.task', [
            'employee' => $employee,
            'tasks' => $tasks
        ]);
    }


    public function create(Request $request)
    {
        $request->validate([
            'task' => 'required|string',
            'taskdesc' => 'nullable|string',
            'employee' => 'required|integer',
            'file' => 'required|mimes:pdf,doc,docx',
            'deadline' => 'required|date',
        ]);

        $file = $request->file('file');
        $fileName = 'task_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('filetask', $fileName);

        $task = new Task;
        $task->taskname = $request->input('task');
        $task->taskdescriptions = $request->input('taskdesc');
        $task->file = $fileName;
        $task->employee_id = $request->input('employee');
        $task->deadline = $request->input('deadline');

        $task->save();

        return redirect('/task')->with('success', 'Task created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $task = DB::table('tasks')
        ->join('employees', 'tasks.employee_id', '=', 'employees.id')
        ->select('tasks.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
        ->first();
        

        return view('dashboard.isitask', [
        'task' => $task
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $employee = DB::table('users')
        ->join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.employee_id', 'employees.*')
        ->where('users.role', 0)
        ->get();
        $task = DB::table('tasks')
        ->join('employees', 'tasks.employee_id', '=', 'employees.id')
        ->select('tasks.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
        ->first();

        return view('dashboard.form', [
        'task' => $task,
        'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Validasi input
        $request->validate([
        'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        // Simpan file yang diunggah ke folder "filetask" dalam direktori penyimpanan publik
        $uploadedFile = $request->file('file'); // Menggunakan $request untuk mengakses file yang diunggah
        $fileName = time() . '.' . $uploadedFile->getClientOriginalExtension();
        $uploadedFile->storeAs('submitfile', $fileName);

        // Perbarui kolom "file" dalam database dengan nama file yang baru diunggah
        $task->submitfile = $fileName;
        $task->progress = 1;
        $task->save();

        return redirect('/task')->with('success', 'File berhasil diunggah dan tugas diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
