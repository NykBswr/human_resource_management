@extends('layout.main')

@section('container')

@include('partials.nav')

@include('partials.sidebar')

{{-- Jangan diubah --}}
<section class="w-full h-full pt-36 pb-12 px-20 flex items-center" id="main"> 
    <div class="w-full h-full bg-tertiary py-5 px-20 rounded-2xl flex flex-col items-center" id="main2">
        {{-- Sampai sini --}}
        <div class="w-full flex items-center justify-center @if($employee->role != 'Branch Manager' || $employee->role != 'Manager') mb-6 @endif">
            <h1 class="text-xl text-primary mb-1 uppercase">
                Attendance @can('hr')List @endcan
            </h1>
        </div>
        <div class="bg-dark flex rounded-full text-white ml-auto -mt-9">
            @can('atasan')
            @if($employee->role == 'Branch Manager' || $employee->role == 'Manager')
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'attend']) }}" class="{{ ($typeFilter === '' || request()->path() === 'attendance' && $typeFilter !== 'employeelist') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Attendance</a>
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'employeelist']) }}" class="{{ (request()->path() === 'attendance' && $typeFilter === 'employeelist') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Employee Attendance</a>
            @endif
            @endcan
        </div>
        <div class="w-full mt-5">
            @if (session()->has('success'))
            <div class="w-full h-auto bg-green-200 text-green-800 border border-green-400 rounded-lg p-4 my-4 relative" id="success-alert">
                {{ session('success') }}
                <button type="button" class="absolute right-0 mt-2 mr-4" id="close-alert">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                    </svg>
                </button>
            </div>
            @endif
            @if (session()->has('error'))
            <div class="w-full h-auto bg-red-200 text-red-800 border border-red-400 rounded-lg p-4 my-4 relative" id="success-alert">
                {{ session('error') }}
                <button type="button" class="absolute right-0 mt-2 mr-4" id="close-alert">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                    </svg>
                </button>
            </div>
            @endif
        </div>

        <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
        <div class="w-full h-full flex flex-col items-center overflow-x-auto mb-5">
            <table class="w-full text-primary text-center">
                <thead>
                    <tr class="w-full">
                        @if ($employee->role == 'Human Resource' || request()->query('type_filter') == 'employeelist')
                            @can('atasan')
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        Employee Name
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        Role
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        Position
                                    </div>
                                </th>
                            @endcan
                        @endif

                        @if(request()->query('type_filter') == 'employeelist' || request()->query('type_filter') == 'attend' || request()->query('type_filter') == '' || $employee->role == 'Employee' || $employee->role == 'Human Resource')
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Date
                                </div>
                            </th>
                        @endif
                        
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Attendance
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attend as $employeelist)
                        <tr class="w-full">
                            @if ($employee->role == 'Human Resource' || request()->query('type_filter') == 'employeelist')
                            @can('atasan')
                            {{-- Nama Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $employeelist->firstname . " " . $employeelist->lastname }}
                                </div>
                            </td>
                            {{-- Role Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    @php
                                        $rolenMapping = [
                                            0 => 'Employee',
                                            1 => 'Manager',
                                            2 => 'Branch Manager'
                                        ];
                                    @endphp
                                    {{ $rolenMapping[$employeelist->role] }}
                                </div>
                            </td>
                            {{-- Position Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    @php
                                        $positionMapping = [
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
                                    @endphp
                                    {{ $positionMapping[$employeelist->position] }}
                                </div>
                            </td>
                            @endcan
                            @endif


                            @if(request()->query('type_filter') == 'employeelist' || request()->query('type_filter') == 'attend' || request()->query('type_filter') == '' || $employee->role == 'Employee' || $employee->role == 'Human Resource')
                            {{-- Date --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    @php
                                        $date = \Carbon\Carbon::parse($employeelist->date);
                                        $today = now()->toDateString();
                                    @endphp
                                    {{ $date->isoFormat('dddd, D MMMM Y') }}
                                </div>
                            </td>
                            @endif
                            
                            {{-- Attendance --}}
                            <td class="w-auto h-14">
                                @php
                                    $today = now()->toDateString();
                                    $currentHour = now();
                                    $lateThreshold = now()->setHour(9)->setMinute(0)->setSecond(0)->format('H:i:s');
                                    $workDuration = $currentHour->diff($employeelist->in);
                                @endphp
                                <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                    {{-- Absen --}}
                                    @if ($employeelist->status == 0)
                                        {{-- Employee & Manager --}}
                                        @if ((auth()->user()->role == 0 && request()->query('type_filter') == '') || ((auth()->user()->role == 2 || auth()->user()->role == 1) && (request()->query('type_filter') == 'attend' || request()->query('type_filter') == '')))
                                            {{-- Bisa Absen --}}
                                            @if ($today == $employeelist->date && $currentHour < $lateThreshold)
                                                <form action="/attendance/present/{{ $employeelist->id }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="hover:scale-110 hover:underline hover:underline-offset-4 duration-500">
                                                        Click to attend.
                                                    </button>
                                                </form>
                                            {{-- Time Over --}}
                                            @elseif ($currentHour > $lateThreshold)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        {{-- HR --}}
                                        @elseif (auth()->user()->role == 3)
                                            <form action="/attendance/present/{{ $employeelist->id }}" method="post">
                                                @csrf
                                                <button type="submit" class="hover:scale-110 hover:underline hover:underline-offset-4 duration-500">
                                                    Click to attend.
                                                </button>
                                            </form>
                                        @endif
                                    {{-- Sudah Absen Masuk --}}
                                    @elseif ($employeelist->status == 1)
                                        {{-- Jika sudah kerja 8 jam atau lebih --}}
                                        @if ($today == $employeelist->date && $workDuration->h >= 8 || auth()->user()->role == 3)
                                            <form action="/attendance/leave/{{ $employeelist->id }}" method="post">
                                                @csrf
                                                <button type="submit" class="hover:scale-110 hover:underline hover:underline-offset-4 duration-500">
                                                    Click to leave.
                                                </button>
                                            </form>
                                        {{-- Jika lupa absen pulang --}}
                                        @elseif ($employeelist->out == 0 && $workDuration >= $employeelist->in)
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        {{-- Jika belum absensi pulang dan sudah masuk --}}
                                        @else
                                            <img class="w-auto h-[3vh]" src="\img\late.png">
                                        @endif
                                    {{-- Jika sudah absensi pulang --}}
                                    @elseif ($employeelist->status == 2 && $workDuration >= $employeelist->in)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                    {{-- Tidak bisa --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @can('hr')
        <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
        <div class="bg-dark flex rounded-full text-white ml-auto">
            <a href="/attendance/createattend" class="gradcolor rounded-md py-2 px-7">Add Attendance</a>
        </div>
        @endcan
    </div>
</section>

@endsection