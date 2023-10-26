@extends('layout.main')

@section('container')

@include('partials.nav')

@include('partials.sidebar')

{{-- Jangan diubah --}}
<section class="w-full h-full pt-36 pb-12 px-20 flex items-center" id="main"> 
    <div class="w-full h-full bg-tertiary py-5 px-20 rounded-2xl flex flex-col items-center" id="main2">
        {{-- Sampai sini --}}

        {{-- Judul --}}
        <div class="w-full flex items-center justify-center">
            <h1 class="text-xl text-primary mb-1 uppercase">
                Payroll and Benefit
            </h1>
        </div>
        {{-- End Judul --}}
        
        @can('hr')
        {{-- Type Filter --}}
            <div class="bg-dark flex rounded-full text-white ml-auto -mt-9">
                <a href="/PayrollandBenefit?type_filter=payroll" class="{{ ($typeFilter === '' || request()->path() === 'PayrollandBenefit' && $typeFilter !== 'benefit') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Payroll</a>
                <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'benefit']) }}" class="{{ (request()->path() === 'PayrollandBenefit' && $typeFilter === 'benefit') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Benefit</a>
            </div>
        {{-- End Type Filter --}}
        @endcan
        
        {{-- SUCCESS ALERT --}}
        <div class="w-full mb-2">
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
        {{-- END SUCCESS ALERT --}}

        <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
        @if (auth()->user()->role == 3)
        {{-- TAMPILAN HUMAN RESOURCE --}}
            <div class="w-full h-full flex flex-col items-center overflow-x-auto">
                @if (request()->query('type_filter') == 'benefit')
                    <div class="flex justify-center mt-2 mb-5">
                        <div class="bg-dark flex rounded-full text-white ml-auto">
                            <a href="{{ request()->fullUrlWithQuery(['benefitsFilter' => 'benefitlist']) }}" class="{{ ($typeFilter === '' || request()->path() === 'PayrollandBenefit' && $benefitsFilter !== 'employeebenefits') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Benefits List</a>
                            <a href="{{ request()->fullUrlWithQuery(['benefitsFilter' => 'employeebenefits']) }}" class="{{ (request()->path() === 'PayrollandBenefit' && $benefitsFilter === 'employeebenefits') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Employee Benefits</a>
                        </div>
                    </div>
                @endif
                <table class="w-full text-primary text-center">
                    <thead>
                        <tr class="w-full">
                            {{-- JUDUL --}}
                            @if (request()->query('type_filter') == 'payroll' || request()->query('type_filter') == '' || request()->query('benefitsFilter') == 'employeebenefits')
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Employee Name
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Role
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Position
                                    </div>
                                </th>
                            @endif

                            {{-- JUDUL PAYROLL --}}
                            @if (request()->query('type_filter') == 'payroll' || request()->query('type_filter') == '')
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Salary Amount
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Tax Deduction 
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Payment Date
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Edit
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Application
                                    </div>
                                </th>
                            @endif
                            {{-- END JUDUL PAYROLL --}}

                            {{-- END BENEFIT --}}
                            @if (request()->query('type_filter') == 'benefit')
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Benefit
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Benefit Amount
                                    </div>
                                </th>
                                @if (request()->query('benefitsFilter') == 'employeebenefits')
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Application
                                    </div>
                                </th>
                                @endif
                            @endif
                            {{-- END JUDUL BENEFIT --}}

                            {{-- END JUDUL --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- ISI PAYROLL HR --}}
                        @if (request()->query('type_filter') == 'payroll' || request()->query('type_filter') == '')
                            @foreach($payroll as $payroll)
                                <tr class="w-full">
                                    {{-- Employee Name --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            {{ $payroll->firstname . '' . $payroll->lastname }} 
                                        </div>
                                    </td>
                                    {{-- Role --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            @php
                                                $rolenMapping = [
                                                    0 => 'Employee',
                                                    1 => 'Manager',
                                                    2 => 'Branch Manager'
                                                ];
                                            @endphp
                                            {{ $rolenMapping[$payroll->role] }}
                                        </div>
                                    </td>
                                    {{-- Position --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
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
                                            {{ $positionMapping[$payroll->position] }}
                                        </div>
                                    </td>
                                    {{-- Salary Amount --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            @if ($payroll->salary_amount == null)
                                                -
                                            @else
                                                {{ $payroll->salary_amount }} 
                                            @endif
                                        </div>
                                    </td>
                                    {{-- Tax Deduction --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            @if ($payroll->tax_deduction == null)
                                                -
                                            @else
                                                {{ $payroll->tax_deduction }} 
                                            @endif
                                        </div>
                                    </td>
                                    {{-- Payment Date  --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            @php
                                                $payment_date = \Carbon\Carbon::parse($payroll->payment_date);
                                            @endphp
                                            {{ $payment_date->isoFormat('D MMMM Y') }}
                                        </div>
                                    </td>
                                    {{-- Edit --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg flex justify-center items-center">
                                            <a href="" class="hover:scale-110 duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                    {{-- Application --}}
                                    <td class="w-auto h-14">
                                        @if ($payroll->status === 1)
                                            <div class="bg-secondary py-5 px-2 m-1 rounded-lg flex justify-center items-center">
                                                <a href="/task/feedback/{{ $task->id }}" class="hover:scale-110 duration-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                                        <path strokeLinecap="round" strokeLinejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @elseif ($payroll->status === 2)
                                            <div class="bg-secondary py-5 px-2 m-1 rounded-lg flex justify-center items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                                                </svg>
                                            </div>
                                        @else 
                                            {{-- Larang --}}
                                            <div class="bg-secondary py-5 px-2 m-1 rounded-lg flex justify-center items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        {{-- ISI BENEFIT HR --}}
                        @if (request()->query('type_filter') == 'benefit')
                            @foreach ($listbenefit as $benefit)
                            <tr class="w-full">
                                @if (request()->query('benefitsFilter') == 'employeebenefits')
                                    {{-- Employee Name --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            {{ $benefit->firstname . ' ' . $benefit->lastname }} 
                                        </div>
                                    </td>
                                    {{-- Role --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            @php
                                                $rolenMapping = [
                                                    0 => 'Employee',
                                                    1 => 'Manager',
                                                    2 => 'Branch Manager'
                                                ];
                                            @endphp
                                            {{ $rolenMapping[$benefit->role] }}
                                        </div>
                                    </td>
                                    {{-- Position --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
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
                                            {{ $positionMapping[$benefit->position] }}
                                        </div>
                                    </td>
                                @endif
                                {{-- Benefits Name --}}
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        {{ $benefit->benefit_name }}
                                    </div>
                                </td>
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        {{ $benefit->benefit_amount }}
                                    </div>
                                </td>
                                @if (request()->query('benefitsFilter') == 'employeebenefits')
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if(request()->query('type_filter') == 'payroll' || request()->query('type_filter') == '')
                <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
                <div class="bg-dark flex rounded-full text-white ml-auto">
                    <a href="" class="gradcolor rounded-md py-2 px-7">Salary Increase Request</a>
                </div>
            @elseif(request()->query('type_filter') == 'benefit' && request()->query('benefitsFilter') == 'benefitlist' || request()->query('benefitsFilter') == '')
                <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
                <div class="bg-dark flex rounded-full text-white ml-auto">
                    <a href="" class="gradcolor rounded-md py-2 px-7">Add or Delete Employee Benefit</a>
                </div>
            @elseif(request()->query('type_filter') == 'benefit' && request()->query('benefitsFilter') == 'employeebenefits')
                <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
                <div class="bg-dark flex rounded-full text-white ml-auto">
                    <a href="" class="gradcolor rounded-md py-2 px-7">Benefit Application</a>
                </div>
            @endif
        {{-- END TAMPILAN HUMAN RESOURCE --}}
        @else
        {{-- TAMPILAN SELAIN EMPLOYEE --}}
            <div class="flex flex-row w-full h-full">
                <div class="bg-secondary rounded-2xl w-1/2 h-full flex flex-col items-center overflow-x-auto mr-5 p-5">
                    <table class="w-full text-primary text-start flex">
                        {{-- <thead>
                            <tr class="w-full">
                                <th class="w-auto h-14" colspan="2">
                                    <div class="text-xl bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        PAYROLL
                                    </div>
                                </th>
                            </tr>
                        </thead> --}}
                        <thead class="w-1/2 h-full">
                            <tr class="w-full h-full flex flex-col">
                                <th class="w-full h-full text-start">
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Salary Amount
                                    </div>
                                </th>
                                <th class="w-full h-full text-start">
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Tax Deduction 
                                    </div>
                                </th>
                                <th class="w-full h-full text-start">
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Status
                                    </div>
                                </th>
                                <th class="w-full h-full text-start">
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Payment Date
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="w-1/2 h-full">
                            <tr class="w-full h-14 flex flex-col">
                                <td>
                                    <div class="w-full bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        1
                                    </div>
                                </td>
                                <td>
                                    <div class="w-full bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        2
                                    </div>
                                </td>
                                <td>
                                    <div class="w-full bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        3
                                    </div>
                                </td>
                                <td>
                                    <div class="w-full bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        4
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bg-secondary rounded-2xl w-1/2 h-full flex flex-col items-center overflow-x-auto ml-5 p-5">
                    <div class="flex justify-center mt-2 mb-5">
                        <div class="bg-tertiary flex rounded-full text-white ml-auto">
                            <a href="{{ request()->fullUrlWithQuery(['benefitsFilter' => 'benefitlist']) }}" class="{{ ($typeFilter === '' || request()->path() === 'PayrollandBenefit' && $benefitsFilter !== 'employeebenefits') ? 'gradcolor' : 'bg-tertiary' }} rounded-full py-2 px-7">Benefits List</a>
                            <a href="{{ request()->fullUrlWithQuery(['benefitsFilter' => 'employeebenefits']) }}" class="{{ (request()->path() === 'PayrollandBenefit' && $benefitsFilter === 'employeebenefits') ? 'gradcolor' : 'bg-tertiary' }} rounded-full py-2 px-7">Employee Benefits</a>
                        </div>
                    </div>
                    @if($benefitsFilter === 'benefitlist')
                        <table class="w-full text-primary">
                            <thead>
                                <tr class="w-full">
                                    <th class="w-auto h-14">
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            Benefit
                                        </div>
                                    </th>
                                    <th class="w-auto h-14">
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            Benefit Amount
                                        </div>
                                    </th>
                                    <th class="w-auto h-14">
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            Application
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="w-auto h-14">
                                    <td>
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            
                                        </div>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <table class="w-full text-primary flex">
                            <thead class="w-1/2 h-full">
                                <tr class="w-full h-full flex flex-col">
                                    <th class="w-full h-full text-start">
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            Salary Amount
                                        </div>
                                    </th>
                                    <th class="w-full h-full text-start">
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            Tax Deduction 
                                        </div>
                                    </th>
                                    <th class="w-full h-full text-start">
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            Status
                                        </div>
                                    </th>
                                    <th class="w-full h-full text-start">
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            Payment Date
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="w-1/2 h-full">
                                <tr class="w-full h-14 flex flex-col">
                                    <td>
                                        <div class="w-full bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            1
                                        </div>
                                    </td>
                                    <td>
                                        <div class="w-full bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            2
                                        </div>
                                    </td>
                                    <td>
                                        <div class="w-full bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            3
                                        </div>
                                    </td>
                                    <td>
                                        <div class="w-full bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            4
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        {{-- END TAMPILAN SELAIN EMPLOYEE --}}
        @endif
    </div>
</section>

@endsection