<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil data pengguna (user) berdasarkan ID dan menggabungkan data karyawan (employee)
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
            ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
            ->where('users.id', auth()->user()->id)
            ->first();
            
        if (!$employee || !$employee->employee || auth()->user()->id !== $employee->id) {
            return redirect('/dashboard');
        }

        $tasksQuery = DB::table('tasks')
            ->join('employees', 'tasks.employee_id', '=', 'employees.id')
            ->join('users', 'tasks.employee_id', '=', 'users.employee_id')
            ->join('performances', 'tasks.id', '=', 'performances.task_id')
            ->select('tasks.*', 'users.id','users.role', 'employees.firstname', 'employees.lastname',
            'employees.position', 'employees.salary', 'performances.rating', 'performances.feedback');

        $typeFilter = $request->input('type_filter');

        if ($typeFilter === 'unfinished') {
            $tasksQuery->where(function ($query) {
                $query->where('progress', null)->orWhere('progress', 3)->orWhere('progress', 1);
            });
        } elseif ($typeFilter === 'finished') {
            $tasksQuery->where(function ($query) {
                $query->where('progress', 2);
            });
        } else {
            $tasksQuery->where(function ($query) {
                $query->where('progress', null)->orWhere('progress', 3)->orWhere('progress', 1);
            });
        }

        // Memeriksa role dari employee
        if ($employee->role == 0) {
            $tasks = $tasksQuery->where('users.id', auth()->user()->id)->paginate(5)->appends(request()->query());
        } elseif ($employee->role == 1) {
            $tasks = $tasksQuery->where('position', $employee->position)->where('role', 0)->paginate(5)->appends(request()->query());
        } elseif ($employee->role == 2 || $employee->role == 3) {
            $tasks = $tasksQuery->where('role', 0)->paginate(5)->appends(request()->query());
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

        return view('task.task', [
            'employee' => $employee,
            'tasks' => $tasks,
            'typeFilter' => $typeFilter,
        ]);
    }
    public function createtask()
    {
        // Mengambil data pengguna (user) berdasarkan ID dan menggabungkan data karyawan (employee)
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
        ->where('users.id', auth()->user()->id)
        ->first();

        if (auth()->user()->role !== 1 && auth()->user()->role !== 3) {
            return redirect('/task');
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

        $employeeid = DB::table('users')
        ->join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.employee_id', 'employees.*')
        ->where('users.role', 0)
        ->get();

        if(auth()->user()->role == 1){
            $employeeid = $employeeid->where('position', $employee->position);
        } elseif (auth()->user()->role == 3) {
            $employeeid = $employeeid->all();
        }


        $tasks = DB::table('tasks')
        ->join('employees', 'tasks.employee_id', '=', 'employees.id')
        ->select('tasks.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
        ->get();

        // Memeriksa role dari employee
        if ($employee->role == 0) {
            // Jika role employee == 0, tampilkan hanya task dengan ID yang sesuai
            $tasks = $tasks->where('employee_id', auth()->user()->id);
        } elseif ($employee->role == 1) {
            // Jika role employee == 1, tampilkan task dengan posisi yang sama dengan posisi karyawan
            $tasks = $tasks->where('position', $employee->position);
        } elseif ($employee->role == 2 || $employee->role == 3) {
            $tasks = $tasks->all();
        }

        return view('task.createtask', [
        'employee' => $employee,
        'employeeid' => $employeeid,
        'task' => $tasks
        ]);
    }

    public function create(Request $request)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position')
        ->where('users.id', auth()->user()->id)
        ->first();

        if ($employee->role != '3' && $employee->role != '1') {
            return redirect('/task');
        }

        $request->validate([
            'task' => 'required|string',
            'taskdesc' => 'nullable|string',
            'employee' => 'required|integer',
            'file' => 'required|mimes:pdf,doc,docx',
            'deadline' => 'required|date|after:today',
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

        $perform = new Performance;
        $perform->task_id = $task->id;
        $perform->employee_id = $request->input('employee');

        $perform ->save();

        return redirect('/task')->with('success', 'Task created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position')
        ->where('users.id', auth()->user()->id)
        ->first();
        
        // Periksa apakah data pengguna dan karyawan ada atau tidak
        if (!$employee || !$employee->employee || auth()->user()->id !== $employee->id) {
        return redirect('/task');
        }

        $task = DB::table('tasks')
        ->join('employees', 'tasks.employee_id', '=', 'employees.id')
        ->where('tasks.id', $id)
        ->select('tasks.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
        ->first();

        return view('task.isitask', [
        'task' => $task
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = DB::table('tasks')
        ->join('employees', 'tasks.employee_id', '=', 'employees.id')
        ->select('tasks.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
        ->where('tasks.id', $id)
        ->first();

        return view('task.edittask', [
        'task' => $task,
    ]);
    }

    //  Submit
    public function update(Request $request, Task $task)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position')
        ->where('users.id', auth()->user()->id)
        ->first();
        
        if ($employee->role != '3' && $employee->role != '0') {
            return redirect('/task');
        }
        // Validasi input
        $request->validate([
            'file2' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        // Simpan file yang diunggah ke folder "filetask" dalam direktori penyimpanan publik
        $uploadedFile = $request->file('file2'); // Menggunakan $request untuk mengakses file yang diunggah
        $fileName = time() . '.' . $uploadedFile->getClientOriginalExtension();
        $uploadedFile->storeAs('submitfile', $fileName);

        // Perbarui kolom "file" dalam database dengan nama file yang baru diunggah
        $task->submitfile = $fileName;
        $task->progress = 1;
        $task->save();

        return redirect('/task')->with('success', 'The task was submitted successfully');
    }


    // Edit Task
    public function edittask(Request $request, Task $task)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position')
        ->where('users.id', auth()->user()->id)
        ->first();
        
        if ($employee->role != '3' && $employee->role != '1') {
            return redirect('/task');
        }

        $validatedData = $request->validate([
            'taskname' => 'required|string',
            'taskdescriptions' => 'nullable|string',
            'deadline' => 'required|date',
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        // Simpan file yang diunggah ke folder "filetask" dalam direktori penyimpanan publik
        $uploadedFile = $request->file('file');
        $fileName = time() . '.' . $uploadedFile->getClientOriginalExtension();
        $uploadedFile->storeAs('filetask', $fileName);
        
        // Update kolom "file" dan kolom lainnya dalam database
        $task->update(array_merge($validatedData, ['file' => $fileName, 'progress' => null]));

        return redirect('/task')->with('success', 'The task was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position')
        ->where('users.id', auth()->user()->id)
        ->first();

        if ($employee->role != '3' && $employee->role != '2') {
            return redirect('/task');
        }

        $task->delete();
        return redirect('/task');
    }

    public function feedback($id)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position')
        ->where('users.id', auth()->user()->id)
        ->first();

        if ($employee->role != '3' && $employee->role != '1') {
        return redirect('/task');
        }

        $task = DB::table('tasks')
            ->join('employees', 'tasks.employee_id', '=', 'employees.id')
            ->select('tasks.*', 'employees.firstname', 'employees.lastname', 'employees.position')
            ->where('tasks.id', $id)
            ->first();

        return view('task.inputfeedback', [
        'task' => $task,
        ]);
    }

    public function inputfeedback(Request $request, $id)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
        ->select('users.*', 'employees.position')
        ->where('users.id', auth()->user()->id)
        ->first();

        if ($employee->role != '3' && $employee->role != '1') {
            return redirect('/task');
        }

        // Mengambil objek Task berdasarkan ID
        $task = Task::findOrFail($id);

        if ($request->has('revisi')) {
            // Jika tombol "Revise" ditekan, perbarui kolom progress menjadi 3
            $task->update(['progress' => 3]);
        } else {
            // Validasi input feedback dan rating jika tombol "Submit Feedback" ditekan
            $validatedData = $request->validate([
                'feedback' => 'required|string',
                'rating' => 'nullable|integer|min:1|max:5',
            ]);

            // Mendapatkan objek Performance yang terkait dengan Task
            $performance = $task->performance;

            // Memperbarui nilai feedback dan rating
            $performance->update([
                'feedback' => $validatedData['feedback'],
                'rating' => $validatedData['rating'],
            ]);

            // Simpan perubahan pada Performance
            $performance->save();

            // Update kolom 'progress' pada Task
            $task->update(['progress' => 2]);
        }

        return redirect('/task')->with('success', 'The task has been successfully updated.');
    }
}
