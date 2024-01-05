<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Benefit;
use App\Models\Offdays;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BenefitsApplication;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $employee = User::join('employees', 'users.employee_id', '=', 'employees.id')
            ->select('users.*', 'employees.firstname', 'employees.lastname', 'employees.position', 'employees.salary')
            ->where('users.id', auth()->user()->id)
            ->first();

        if (!$employee || !$employee->employee || auth()->user()->id !== $employee->id) {
            return redirect('/employee');
        }
        // Task List
        $tasksQuery = DB::table('tasks')
            ->join('employees', 'tasks.employee_id', '=', 'employees.id')
            ->join('users', 'tasks.employee_id', '=', 'users.employee_id')
            ->join('performances', 'tasks.id', '=', 'performances.task_id')
            ->select('tasks.*', 'employees.firstname', 'employees.lastname', 'employees.position',
                'users.role', 'employees.salary',
                'performances.rating', 'performances.feedback');

        if ($employee->role == 3 || $employee->role == 2) {
            $tasksQuery->where('users.role', 0);
        } elseif ($employee->role == 1) {
            $tasksQuery->where('employees.position', $employee->position)->where('users.role', 0);
        } elseif ($employee->role == 0) {
            $tasksQuery->where('employees.id', auth()->user()->id)->where('users.role', 0);
        }

        $ratings = $tasksQuery->average('rating');

        // Employee List
        $list = DB::table('employees')
            ->join('users', 'users.employee_id', '=', 'employees.id')
            ->leftJoin('payrolls', function ($join) {
                $join->on('payrolls.employee_id', '=', 'employees.id')
                ->where('payrolls.status', '=', 1);
            })
            ->leftJoin('benefits_applications', function ($join) {
                $join->on('benefits_applications.employee_id', '=', 'employees.id')
                ->where('benefits_applications.status', '=', 1);
            })
            ->leftJoin('offdays', function ($join) {
                $join->on('offdays.employee_id', '=', 'employees.id')
                ->where('offdays.status', '=', 0);
            })
            ->select('employees.*', 'employees.id as employee_id','employees.firstname', 'employees.lastname',
            'employees.position',
            'payrolls.salary_amount', 'users.role', 'payrolls.status as payroll_status',
            'benefits_applications.status as benefit_status',
            'offdays.status as offday_status');

        // dd($list->where('payrolls.status', '=', 1)->get());
        if (auth()->user()->role == 1) {
            $list->where('users.role', 0)->where('employees.position', $employee->position);
        } elseif (auth()->user()->role == 2) {
            $list->where(function ($query) {
            $query->where('users.role', 0)->orWhere('users.role', 1);
            });
        } elseif (auth()->user()->role == 0) {
            $list->where('employees.position', $employee->position)
                ->where('users.id', auth()->user()->id);
        } else {
            $list->where(function ($query) {
                $query->where('users.role', 0)
                    ->orWhere('users.role', 1)
                    ->orWhere('users.role', 2);
            });
        }

        // Employee List
        $list2 = DB::table('employees')
            ->join('users', 'users.employee_id', '=', 'employees.id')
            ->join('payrolls','payrolls.employee_id', '=', 'employees.id')
            ->select('employees.*', 'employees.id as employee_id','employees.firstname', 'employees.lastname',
            'employees.position',
            'payrolls.salary_amount', 'users.role');

        if (auth()->user()->role == 1) {
            $list2->where('employees.position', $employee->position)
                ->where('users.role', 0);
        } elseif (auth()->user()->role == 2) {
            $list2->where(function ($query) {
                $query->where('users.role', 0)
                    ->orWhere('users.role', 1);
            });
        } elseif (auth()->user()->role == 0) {
            $list2->where('employees.position', $employee->position)
                ->where('users.id', auth()->user()->id);
        } else {
            $list2->where(function ($query) {
                $query->where('users.role', 0)
                    ->orWhere('users.role', 1)
                    ->orWhere('users.role', 2);
            });
        }

        // Payroll, Benefit, and Offdays List
        $payroll = Payroll::where('employee_id', auth()->user()->id)->get();
        $benefit = BenefitsApplication::join('benefits', 'benefits.id', '=', 'benefits_applications.benefit_id')
            ->where('benefits_applications.employee_id', auth()->user()->id)
            ->select('benefits_applications.*', 'benefits.benefit_name', 'benefits_applications.status')
            ->get();
        $offdays = Offdays::where('employee_id', auth()->user()->id)->orderByDesc('id')->get();

        $CategoryFilter = $request->input('category_filter');
        $FilterAttend = $request->input('filter_attend');
        $requestFilter = $request->input('request_filter');
        $filterPlot = $request->input('filter_plot');

        $facilityData = DB::table('facilities');

        $employeeFacilityData = DB::table('employees')
        ->select('employees.id as employee_id', 'employees.firstname', 'employees.lastname', 'employees.position',
        'users.role', 'employee_facility.id as employee_facility_id', 'facilities.facility_name',
        'facilities.facility_id as facility_id')
        ->leftJoin('users', 'employees.id', '=', 'users.employee_id')
        ->leftJoin('employee_facility', 'employees.id', '=', 'employee_facility.employee_id')
        ->leftJoin('facilities', 'employee_facility.facility_id', '=', 'facilities.facility_id')
        ->get();
        
        // $employeeFacilityData = DB::table('fact_employee_facility')
        // ->select('employees.id as employee_id', 'employees.firstname', 'employees.lastname', 'employees.position',
        // 'users.role', 'employee_facility.id as employee_facility_id', 'facilities.facility_name',
        // 'facilities.facility_id as facility_id')
        // ->leftJoin('users', 'employees.id', '=', 'users.employee_id')
        // ->leftJoin('employee_facility', 'employees.id', '=', 'employee_facility.employee_id')
        // ->leftJoin('facilities', 'employee_facility.facility_id', '=', 'facilities.facility_id')
        // ->get();


        $attend = DB::table('attendances')
            ->leftJoin('users', 'users.employee_id', '=', 'attendances.employee_id')
            ->leftJoin('employees', 'employees.id', '=', 'attendances.employee_id')
            ->select('attendances.*', 'attendances.in as in', 'attendances.out as out', 'attendances.date as date', 'users.role as role',
            'employees.position as position');

        // $attend = DB::table('fact_attendance_details')
        //     ->leftJoin('users', 'users.employee_id', '=', 'attendances.employee_id')
        //     ->leftJoin('employees', 'employees.id', '=', 'attendances.employee_id')
        //     ->select('attendances.*', 'attendances.in as in', 'attendances.out as out', 'attendances.date as date', 'users.role as role',
        //     'employees.position as position');
        
        if (auth()->user()->role == 1) {
            if ($FilterAttend == 'all_employees'){
                $attend->where('employees.position', $employee->position)
                    ->where('users.role', 0);
            } elseif ($FilterAttend == '' || $FilterAttend == 'employees') {
                if ($filterPlot == 'line' || $filterPlot == ''){
                    $filterPlot = 'pie';
                }
                $attend->where('employees.position', $employee->position)
                    ->where('employees.id', auth()->user()->id);
            } else {
                return redirect('/dashboard');
            }
        } elseif (auth()->user()->role == 2) {
            if ($FilterAttend == '' || $FilterAttend == 'employees') {
                if ($filterPlot == 'line' || $filterPlot == ''){
                    $filterPlot = 'pie';
                }
                $attend->where('employees.position', $employee->position)
                    ->where('employees.id', auth()->user()->id);
            } elseif ($FilterAttend == 'all_employees') {
                return redirect('/dashboard');
            } else {
                $attend->where(function ($query) {
                    $query->where('users.role', 0)
                        ->orWhere('users.role', 1);
                    });
            }
        } elseif (auth()->user()->role == 0) {
            if ($FilterAttend == '' || $FilterAttend == 'employees') {
                if ($filterPlot == 'line' || $filterPlot == ''){
                    $filterPlot = 'pie';
                }
                $attend->where('employees.position', $employee->position)
                    ->where('attendances.employee_id', auth()->user()->id);
            } else {
                return redirect('/dashboard');
            }
        } else {
            if ($FilterAttend == 'all_employees' || $FilterAttend == 'employees') {
                return redirect('/dashboard');
            } else {
                $attend->where(function ($query) {
                    $query->where('users.role', 0)
                        ->orWhere('users.role', 1)
                        ->orWhere('users.role', 2);
                });
            }
        }
        
        if ($request->query('start') == null) {
            $startDate = '2023-10-26';
        } else {
            $startDate = $request->query('start');
        }
        
        if ($request->query('end') == null) {
            $endDate = date('Y-m-d');
        } else {
            $endDate = $request->query('end');
        }

        if ($request->query('start2') == null) {
            $startDate2 = '2023-12-26';
        } else {
            $startDate2 = $request->query('start2');
        }
        
        if ($request->query('end2') == null) {
            $endDate2 = date('Y-m-d');
        } else {
            $endDate2 = $request->query('end2');
        }

        if (!auth()->user()->role == 0) {
            if (auth()->user()->role == 1){
                $workHour = DB::table('fact_working_hours')->where('role', 0)->where('position',
                $employee->position)->get();
            } else {
                $workHour = DB::table('fact_working_hours')->get();
            }
        } else {
            $workHour = 0;
        }

        $work = DB::table('fact_working_hours');

        $emplName = $employee->firstname;

        $employeeNameFilter = $request->input('employeeNameFilter');

        if ($employeeNameFilter != null) {
            $work->where('employee_name', 'like', "%{$employeeNameFilter}%");
        } elseif ($employeeNameFilter == null) {
            if (auth()->user()->role == 3) {
                $work->where('employee_name', 'like', "%aditya%");
            } else {
                $work->where('employee_name', 'like', "%{$emplName}%");
            }
        }

        $work = $work->get();

        $workHourData = [];

        foreach ($work as $w) {
            $startDateFormatted = date('Y-m-d H:i:s', strtotime($startDate2));
            $endDateFormatted = date('Y-m-d H:i:s', strtotime($endDate2));
            if ($w->date >= $startDateFormatted && $w->date <= $endDateFormatted) {
                $workHourData[] = [
                    'date' => $w->date,
                    'working_hours' => $w->working_hours,
                ];
            }
        }

        $date = array_column($workHourData, 'date');
        $workingHours = array_column($workHourData, 'working_hours');

        $dates = [];
        $workingHourss = [];

        foreach ($date as $dat) {
            // Format tanggal
            $formattedDate = date('d/m/y', strtotime($dat));
            $dates[] = $formattedDate;
        }
        foreach ($workingHours as $hour) {
            $workingHourss[] = number_format($hour, 2);
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

        return view('dashboard.main', [
            'employee' => $employee,
            'tasksQuery' => $tasksQuery->get(),
            'list' => $list->get(),
            'list2' => $list2->get(),
            'payroll' => $payroll,
            'benefit' => $benefit,
            'offdays' => $offdays,
            'ratings' => $ratings,
            'categoryFilter' => $CategoryFilter,
            'employeeFacilityData' => $employeeFacilityData,
            'facilityData' => $facilityData->get(),
            'attend' => $attend->get(),
            'filterAttend' => $FilterAttend,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'requestFilter' => $requestFilter,
            'filterPlot' => $filterPlot,
            'startDate2' => $startDate2,
            'endDate2' => $endDate2,
            'workHour' => $workHour,
            'employeeNameFilter' => $employeeNameFilter,
            'date' => $dates,
            'workingHours' => $workingHourss,
        ]);
    }
}
