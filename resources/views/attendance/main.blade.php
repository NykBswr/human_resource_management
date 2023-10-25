@extends('layout.main')

@section('container')

@include('partials.nav')

@include('partials.sidebar')

{{-- Jangan diubah --}}
<section class="w-full h-full pt-36 pb-12 px-20 flex items-center" id="main"> 
    <div class="w-full h-full bg-tertiary py-5 px-20 rounded-2xl flex flex-col items-center" id="main2">
        {{-- Sampai sini --}}
        <div class="w-full flex items-center justify-center @if($employee->role != 2 || $employee->role != 1) mb-6 @endif">
            <h1 class="text-xl text-primary mb-1 uppercase">
                Attendance @can('hr')List @endcan
            </h1>
        </div>
        <div class="bg-dark flex rounded-full text-white ml-auto -mt-9">
            @can('atasan')
            @if($employee->role == 2 || $employee->role == 1)
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'attend']) }}" class="{{ ($typeFilter === '' || request()->path() === 'attendance' && $typeFilter !== 'employeelist') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Attendance</a>
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'employeelist']) }}" class="{{ (request()->path() === 'attendance' && $typeFilter === 'employeelist') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Employee Attendance</a>
            @endif
            @endcan
        </div>
        <div class="w-full mb-5">
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
        </div>

        <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
        <div class="w-full h-full flex flex-col items-center overflow-x-auto">
            <table class="w-full text-primary text-center">
                <thead>
                    <tr class="w-full">
                        @if ($employee->role == 3 || request()->query('type_filter') == 'employeelist')
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

                        @if(request()->query('type_filter') == 'employeelist' || request()->query('type_filter') == 'attend' || request()->query('type_filter') == '' || $employee->role == 0 || $employee->role == 3)
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Date
                                </div>
                            </th>
                        @endif
                        
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Attend
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attend as $employeelist)
                        <tr class="w-full">
                            @if ($employee->role == 3 || request()->query('type_filter') == 'employeelist')
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
                                    {{ $employeelist->role }}
                                </div>
                            </td>
                            {{-- Position Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $employeelist->position }}
                                </div>
                            </td>
                            @endcan
                            @endif


                            @if(request()->query('type_filter') == 'employeelist' || request()->query('type_filter') == 'attend' || request()->query('type_filter') == '' || $employee->role == 0 || $employee->role == 3)
                            {{-- Date --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    @php
                                        $date = \Carbon\Carbon::parse($employeelist->date);
                                    @endphp

                                    {{ $date->isoFormat('dddd, D MMMM Y') }}
                                </div>
                            </td>
                            @endif
                            {{-- Attend --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                    @if ($date->isToday() && $employeelist->status == 0 && $employee->role == 0 || $employee->role == 3)
                                        <a href="" class="hover:scale-110 hover:underline hover:underline-offset-4 duration-500">
                                            Click to Present
                                        </a>
                                    @elseif ($date->isFuture() && $employeelist->status == 0)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif ($employeelist->status == 1)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else 
                                        Not Yet Present
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