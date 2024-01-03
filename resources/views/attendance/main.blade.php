@extends('layout.main')

@section('container')

    @include('partials.nav')

    @include('partials.sidebar')

    {{-- Jangan diubah --}}
    <section class="flex h-full w-full items-center px-20 pb-12 pt-36" id="main">
        <div class="flex h-full w-full flex-col items-center rounded-2xl bg-tertiary px-20 py-5" id="main2">
            {{-- Sampai sini --}}
            <div class="@if ($employee->role != 'Branch Manager' || $employee->role != 'Manager') mb-6 @endif flex w-full items-center justify-center">
                <h1 class="mb-1 text-xl uppercase text-primary">
                    Attendance @can('hr')
                        List
                    @endcan
                </h1>
            </div>
            <div class="-mt-9 ml-auto flex rounded-full bg-dark text-white">
                @can('atasan')
                    @if ($employee->role == 'Branch Manager' || $employee->role == 'Manager')
                        <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'attend', 'page' => null]) }}"
                            class="{{ $typeFilter === '' || (request()->path() === 'attendance' && $typeFilter !== 'employeelist') ? 'gradcolor' : 'bg-dark' }} rounded-full px-7 py-2">Attendance</a>
                        <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'employeelist', 'page' => null]) }}"
                            class="{{ request()->path() === 'attendance' && $typeFilter === 'employeelist' ? 'gradcolor' : 'bg-dark' }} rounded-full px-7 py-2">Employee
                            Attendance</a>
                    @endif
                @endcan
            </div>
            <div class="mt-5 w-full">
                @if (session()->has('success'))
                    <div class="relative my-4 h-auto w-full rounded-lg border border-green-400 bg-green-200 p-4 text-green-800"
                        id="success-alert">
                        {{ session('success') }}
                        <button type="button" class="absolute right-0 mr-4 mt-2" id="close-alert">
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="relative my-4 h-auto w-full rounded-lg border border-red-400 bg-red-200 p-4 text-red-800"
                        id="success-alert">
                        {{ session('error') }}
                        <button type="button" class="absolute right-0 mr-4 mt-2" id="close-alert">
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            <div class="mb-5 h-[0.0625rem] w-full bg-slate-400"></div>
            <div class="mb-5 flex h-full w-full flex-col items-center overflow-x-auto">
                <table class="w-full text-center text-primary">
                    <thead>
                        <tr class="w-full">
                            @if ($employee->role == 'Human Resource' || request()->query('type_filter') == 'employeelist')
                                @can('atasan')
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary py-5">
                                            Employee Name
                                        </div>
                                    </th>
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary py-5">
                                            Role
                                        </div>
                                    </th>
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary py-5">
                                            Position
                                        </div>
                                    </th>
                                @endcan
                            @endif

                            @if (request()->query('type_filter') == 'employeelist' ||
                                    request()->query('type_filter') == 'attend' ||
                                    request()->query('type_filter') == '' ||
                                    $employee->role == 'Employee' ||
                                    $employee->role == 'Human Resource')
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary py-5">
                                        Date
                                    </div>
                                </th>
                            @endif

                            <th class="h-14 w-auto">
                                <div class="m-1 rounded-lg bg-secondary py-5">
                                    Attendance
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attend as $employeelist)
                            <tr class="w-full">
                                @if ($employee->role == 'Human Resource' || request()->query('type_filter') == 'employeelist')
                                    @can('atasan')
                                        {{-- Nama Employee --}}
                                        <td class="h-14 w-auto">
                                            <div class="m-1 rounded-lg bg-secondary py-5">
                                                {{ $employeelist->firstname . ' ' . $employeelist->lastname }}
                                            </div>
                                        </td>
                                        {{-- Role Employee --}}
                                        <td class="h-14 w-auto">
                                            <div class="m-1 rounded-lg bg-secondary py-5">
                                                @php
                                                    $rolenMapping = [
                                                        0 => 'Employee',
                                                        1 => 'Manager',
                                                        2 => 'Branch Manager',
                                                        3 => '',
                                                    ];
                                                @endphp
                                                {{ $rolenMapping[$employeelist->role] }}
                                            </div>
                                        </td>
                                        {{-- Position Employee --}}
                                        <td class="h-14 w-auto">
                                            <div class="m-1 rounded-lg bg-secondary py-5">
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

                                @if (request()->query('type_filter') == 'employeelist' ||
                                        request()->query('type_filter') == 'attend' ||
                                        request()->query('type_filter') == '' ||
                                        $employee->role == 'Employee' ||
                                        $employee->role == 'Human Resource')
                                    {{-- Date --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary py-5">
                                            @php
                                                $date = \Carbon\Carbon::parse($employeelist->date);
                                                $today = now()->toDateString();
                                            @endphp
                                            {{ $date->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                    </td>
                                @endif

                                {{-- Attendance --}}
                                <td class="h-14 w-auto">
                                    @php
                                        $today = now()->toDateString();
                                        $currentHour = now();
                                        $lateThreshold = now()
                                            ->setHour(9)
                                            ->setMinute(0)
                                            ->setSecond(0)
                                            ->format('H:i:s');
                                        $workDuration = $currentHour->diff($employeelist->in);
                                    @endphp
                                    <div class="m-1 flex items-center justify-center rounded-lg bg-secondary py-5">
                                        {{-- Absen --}}
                                        @if ($employeelist->status == 0)
                                            {{-- Employee & Manager --}}
                                            @if (
                                                (auth()->user()->role == 0 && request()->query('type_filter') == '') ||
                                                    ((auth()->user()->role == 2 || auth()->user()->role == 1) &&
                                                        (request()->query('type_filter') == 'attend' || request()->query('type_filter') == '')))
                                                {{-- Bisa Absen --}}
                                                @if ($today == $employeelist->date && $currentHour < $lateThreshold)
                                                    <form action="/attendance/present/{{ $employeelist->id }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit"
                                                            class="duration-500 hover:scale-110 hover:underline hover:underline-offset-4">
                                                            Click to attend.
                                                        </button>
                                                    </form>
                                                    {{-- Time Over --}}
                                                @elseif ($currentHour > $lateThreshold)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="h-6 w-auto">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                                {{-- HR --}}
                                            @elseif (auth()->user()->role == 3)
                                                <form action="/attendance/present/{{ $employeelist->id }}" method="post">
                                                    @csrf
                                                    <button type="submit"
                                                        class="duration-500 hover:scale-110 hover:underline hover:underline-offset-4">
                                                        Click to attend.
                                                    </button>
                                                </form>
                                            @endif
                                            {{-- Sudah Absen Masuk --}}
                                        @elseif ($employeelist->status == 1)
                                            {{-- Jika sudah kerja 8 jam atau lebih --}}
                                            @if (($today == $employeelist->date && $workDuration->h >= 8) || auth()->user()->role == 3)
                                                <form action="/attendance/leave/{{ $employeelist->id }}" method="post">
                                                    @csrf
                                                    <button type="submit"
                                                        class="duration-500 hover:scale-110 hover:underline hover:underline-offset-4">
                                                        Click to leave.
                                                    </button>
                                                </form>
                                                {{-- Jika lupa absen pulang --}}
                                            @elseif ($employeelist->out == 0 && $workDuration >= $employeelist->in)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="h-6 w-auto">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{-- Jika belum absensi pulang dan sudah masuk --}}
                                            @else
                                                <img class="h-[3vh] w-auto" src="\img\late.png">
                                            @endif
                                            {{-- Jika sudah absensi pulang --}}
                                        @elseif ($employeelist->status == 2 && $workDuration >= $employeelist->in)
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="h-6 w-auto">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @else
                                            {{-- Tidak bisa --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="h-6 w-auto">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mb-5 h-[0.0625rem] w-full bg-slate-400"></div>
            <div
                class="@if (auth()->user()->role == 3) justify-between @else justify-center items-center @endif flex w-full flex-row">
                @can('hr')
                    <div class="w-2/5 bg-transparent text-transparent">
                        d
                    </div>
                @endcan
                <div class="@can('hr') w-2/5 @endcan">
                    {{ $attend->links() }}
                </div>
                @can('hr')
                    <div class="ml-auto flex rounded-full text-white">
                        <a href="/attendance/createattend" class="gradcolor rounded-md px-7 py-2">Add Attendance</a>
                    </div>
                @endcan
            </div>
        </div>
    </section>

@endsection
