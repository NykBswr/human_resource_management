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
                                @if (request()->query('type_filter') == 'benefit' && request()->query('benefitsFilter') == 'benefitlist' || request()->query('benefitsFilter') != 'employeebenefits')
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Edit
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Delete
                                    </div>
                                </th>
                                @endif
                                @if (request()->query('benefitsFilter') == 'employeebenefits')
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Requested Benefits
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
                                                Rp. {{ number_format($payroll->salary_amount, 0, ',', '.') }}
                                            @endif
                                        </div>
                                    </td>
                                    {{-- Tax Deduction --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            @if ($payroll->tax_deduction == null)
                                                -
                                            @else
                                                {{ number_format($payroll->tax_deduction, 2, ',', '.') }}%
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
                                            <a href="/PayrollandBenefit/editpayroll/{{ $payroll->id }}" class="hover:scale-110 duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                    {{-- Application --}}
                                    <td class="w-auto h-14">
                                        @if ($payroll->status === 1)
                                            {{-- Progress --}}
                                            <div class="bg-secondary py-5 px-2 m-1 rounded-lg flex justify-center items-center">
                                                <a href="/PayrollandBenefit/acceptedrequest/{{ $payroll->id }}" class="hover:scale-110 duration-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        {{-- @elseif ($payroll->status === 2) --}}
                                            {{-- Approve --}}
                                            {{-- <div class="bg-secondary py-5 px-2 m-1 rounded-lg flex justify-center items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                                                </svg>
                                            </div> --}}
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
                                        Rp. {{ number_format($benefit->benefit_amount, 0, ',', '.') }}
                                    </div>
                                </td>
                                {{-- Edit --}}
                                @if (request()->query('type_filter') == 'benefit' && request()->query('benefitsFilter') == 'benefitlist' || request()->query('benefitsFilter') != 'employeebenefits')
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg flex justify-center items-center">
                                        <a href="/PayrollandBenefit/editbenefit/{{ $benefit->id }}" class="hover:scale-110 duration-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                {{-- Delete --}}
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg flex justify-center items-center">
                                        <form action="/PayrollandBenefit/delete/{{ $benefit->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="hover:scale-110 duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                                @if (request()->query('benefitsFilter') == 'employeebenefits')
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg flex justify-center items-center">
                                    @if ($benefit->status == 1)
                                        <a href="/PayrollandBenefit/acceptedapplication/{{ $benefit->id }}" class="hover:scale-110 duration-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                            </svg>
                                        </a>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                    @endif
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
                <div class="w-full h-[0.0625rem] bg-slate-400 mb-5 mt-5"></div>
                <div class="bg-dark flex rounded-full text-white ml-auto">
                    <a href="/PayrollandBenefit/increaseform" class="gradcolor rounded-md py-2 px-7">Increase Request</a>
                </div>
            @elseif(request()->query('type_filter') == 'benefit' && request()->query('benefitsFilter') == 'benefitlist' || request()->query('benefitsFilter') == '')
                <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
                <div class="bg-dark flex rounded-full text-white ml-auto">
                    <a href="/PayrollandBenefit/addbenefit" class="gradcolor rounded-md py-2 px-7">Add Employee Benefit</a>
                </div>
            @elseif(request()->query('type_filter') == 'benefit' && request()->query('benefitsFilter') == 'employeebenefits')
                <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
                <div class="bg-dark flex rounded-full text-white ml-auto">
                    <a href="/PayrollandBenefit/applyform" class="gradcolor rounded-md py-2 px-7">Benefit Application</a>
                </div>
            @endif
        {{-- END TAMPILAN HUMAN RESOURCE --}}
        @else
        {{-- TAMPILAN SELAIN EMPLOYEE --}}
            <div class="flex flex-row w-full h-full">
                <div class="bg-secondary rounded-2xl w-1/2 h-full flex flex-col items-center justify-center overflow-x-auto mr-5 p-5">
                    <div class="w-full flex items-center justify-center">
                        <h1 class="text-xl text-primary mb-3 uppercase">
                            Payroll
                        </h1>
                    </div>
                    <div class="bg-dark flex rounded-full text-white ml-auto -mt-10">
                        <a href="/PayrollandBenefit" class="{{ ($typeFilter === '' || request()->path() === 'PayrollandBenefit' && $payrollFilter !== 'application') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Info</a>
                        <a href="{{ request()->fullUrlWithQuery(['payrollFilter' => 'application']) }}" class="{{ (request()->path() === 'PayrollandBenefit' && $payrollFilter === 'application') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Application</a>
                    </div>
                    <div class="w-full h-[0.0625rem] bg-slate-400 mb-5 mt-5"></div>
                    <table class="w-full text-primary text-start @if (request()->path() === 'PayrollandBenefit' && $payrollFilter == '') flex @endif">
                        @if (request()->path() === 'PayrollandBenefit' && $payrollFilter == '')
                            <thead class="w-1/2 h-full">
                                <tr class="w-full h-full flex flex-col">
                                    <th class="w-full h-full text-start">
                                        <div class="bg-tertiary py-5 px-5 m-1 rounded-lg">
                                            Received 
                                        </div>
                                    </th>
                                    <th class="w-full h-full text-start">
                                        <div class="bg-tertiary py-5 px-5 m-1 rounded-lg">
                                            Salary Per Month
                                        </div>
                                    </th>
                                    <th class="w-full h-full text-start">
                                        <div class="bg-tertiary py-5 px-5 m-1 rounded-lg">
                                            Tax Deduction 
                                        </div>
                                    </th>
                                    <th class="w-full h-full text-start">
                                        <div class="bg-tertiary py-5 px-5 m-1 rounded-lg">
                                            Payment Date
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                        @else
                            <thead>
                                <tr class="w-full">
                                    <th class="w-auto h-14">
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            Requested Amount
                                        </div>
                                    </th>
                                    <th class="w-auto h-14">
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                            Status
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                        @endif
                        @if (request()->path() === 'PayrollandBenefit' && $payrollFilter == '')
                            <tbody class="w-1/2 h-full">
                                <tr class="w-full h-14 flex flex-col">
                                    <td>
                                        <div class="w-full bg-tertiary py-5 px-5 m-1 rounded-lg">
                                            Rp. {{ number_format($payroll->salary, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="w-full bg-tertiary py-5 px-5 m-1 rounded-lg">
                                            Rp. {{ number_format($payroll->salary_amount, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="w-full bg-tertiary py-5 px-5 m-1 rounded-lg">
                                            @if($payroll->tax_deduction == 0)
                                                -
                                            @else
                                                {{ $payroll->tax_deduction }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="w-full bg-tertiary py-5 px-5 m-1 rounded-lg">
                                            @if($payroll->payment_date == 0)
                                                -
                                            @else
                                                @php
                                                    $payment_date = \Carbon\Carbon::parse($payroll->payment_date);
                                                @endphp
                                                {{ $payment_date->isoFormat('D MMMM Y') }}
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        @else
                            <tbody class="w-full text-center">
                            <tr class="w-full">
                                <td class="w-auto h-14">
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Rp. {{ number_format($payroll->request_amount, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="w-auto h-14">
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg flex justify-center">
                                        @if($payroll->status == 1)
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="white"  viewBox="0 0 24 24" class="w-auto h-6">
                                                <path d="M18.513 7.119c.958-1.143 1.487-2.577 1.487-4.036v-3.083h-16v3.083c0 1.459.528 2.892 1.487 4.035l3.086 3.68c.567.677.571 1.625.009 2.306l-3.13 3.794c-.936 1.136-1.452 2.555-1.452 3.995v3.107h16v-3.107c0-1.44-.517-2.858-1.453-3.994l-3.13-3.794c-.562-.681-.558-1.629.009-2.306l3.087-3.68zm-4.639 7.257l3.13 3.794c.652.792.996 1.726.996 2.83h-1.061c-.793-2.017-4.939-5-4.939-5s-4.147 2.983-4.94 5h-1.06c0-1.104.343-2.039.996-2.829l3.129-3.793c1.167-1.414 1.159-3.459-.019-4.864l-3.086-3.681c-.66-.785-1.02-1.736-1.02-2.834h12c0 1.101-.363 2.05-1.02 2.834l-3.087 3.68c-1.177 1.405-1.185 3.451-.019 4.863z"/>
                                            </svg>
                                        @elseif ($payroll->status == 2)
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif ($payroll->status == 3)
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endif
                    </table>
                    
                    @php
                        $joiningDate = \Carbon\Carbon::parse($employee->joining_date);
                        $currentDate = \Carbon\Carbon::now();
                        $daysSinceJoining = $currentDate->diffInDays($joiningDate);
                    @endphp
                    <div class="w-full h-[0.0625rem] bg-slate-400 mb-5 mt-5"></div>
                    @if (auth()->user()->role == 2 && $daysSinceJoining > 30)
                        <div class="bg-dark flex rounded-full text-white ml-auto">
                            <a href="/PayrollandBenefit/increaseform" class="gradcolor rounded-md py-2 px-7">Increase Request</a>
                        </div>
                    @elseif(auth()->user()->role == 1 && $daysSinceJoining > 300)
                        <div class="bg-dark flex rounded-full text-white ml-auto">
                            <a href="/PayrollandBenefit/increaseform" class="gradcolor rounded-md py-2 px-7">Increase Request</a>
                        </div>
                    @elseif (auth()->user()->role == 0 && $daysSinceJoining > 30)
                        <div class="bg-dark flex rounded-full text-white ml-auto">
                            <a href="/PayrollandBenefit/increaseform" class="gradcolor rounded-md py-2 px-7">Increase Request</a>
                        </div>
                    @endif
                    <div class="bg-dark flex rounded-full text-white ml-auto">
                            <a href="/PayrollandBenefit/increaseform" class="gradcolor rounded-md py-2 px-7">Increase Request</a>
                        </div>
                </div>
                <div class="bg-secondary rounded-2xl w-1/2 h-full flex flex-col items-center justify-center overflow-x-auto ml-5 p-10">
                    <div class="w-full flex items-center justify-center">
                        <h1 class="text-xl text-primary mb-3 uppercase">
                            Benefit
                        </h1>
                    </div>
                    <div class="bg-dark flex rounded-full text-white ml-auto -mt-10">
                        <a href="/PayrollandBenefit" class="{{ ($typeFilter === '' || request()->path() === 'PayrollandBenefit' && $benefitsFilter !== 'application') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">List</a>
                        <a href="{{ request()->fullUrlWithQuery(['benefitsFilter' => 'application']) }}" class="{{ (request()->path() === 'PayrollandBenefit' && $benefitsFilter === 'application') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Application</a>
                    </div>
                    <div class="w-full h-[0.0625rem] bg-slate-400 mb-5 mt-5"></div>
                    {{-- BENEFIT USER --}}
                    <table class="w-full text-primary ">
                        <thead>
                            <tr class="w-full">
                                <th class="w-auto h-14">
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Benefit
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                @if(request()->query('benefitsFilter') == '')
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Benefit Amount
                                    </div>
                                @elseif (request()->query('benefitsFilter') == 'application')
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Requested Amount
                                    </div>
                                @endif
                                </th>
                                @if(request()->query('benefitsFilter') == 'application')
                                <th class="w-auto h-14">
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Status
                                    </div>
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="w-full text-center">
                            @foreach ($listbenefit as $benefit)
                            <tr class="w-full">
                                <td class="w-auto h-14">
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        {{ $benefit->benefit_name }}
                                    </div>
                                </td>
                                <td class="w-auto h-14">
                                @if(request()->query('benefitsFilter') == '')
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Rp. {{ number_format($benefit->amount, 0, ',', '.') }}
                                    </div>
                                @elseif (request()->query('benefitsFilter') == 'application')
                                    <div class="bg-tertiary py-5 px-2 m-1 rounded-lg">
                                        Rp. {{ number_format($benefit->requested_amount, 0, ',', '.') }}
                                    </div>
                                @endif
                                </td>
                                @if(request()->query('benefitsFilter') == 'application' && $benefit->status != 0)
                                    <td class="w-auto h-14">
                                        <div class="bg-tertiary py-5 px-2 m-1 rounded-lg flex justify-center items-center">
                                            @if($benefit->status == 1)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="white"  viewBox="0 0 24 24" class="w-auto h-6">
                                                    <path d="M18.513 7.119c.958-1.143 1.487-2.577 1.487-4.036v-3.083h-16v3.083c0 1.459.528 2.892 1.487 4.035l3.086 3.68c.567.677.571 1.625.009 2.306l-3.13 3.794c-.936 1.136-1.452 2.555-1.452 3.995v3.107h16v-3.107c0-1.44-.517-2.858-1.453-3.994l-3.13-3.794c-.562-.681-.558-1.629.009-2.306l3.087-3.68zm-4.639 7.257l3.13 3.794c.652.792.996 1.726.996 2.83h-1.061c-.793-2.017-4.939-5-4.939-5s-4.147 2.983-4.94 5h-1.06c0-1.104.343-2.039.996-2.829l3.129-3.793c1.167-1.414 1.159-3.459-.019-4.864l-3.086-3.681c-.66-.785-1.02-1.736-1.02-2.834h12c0 1.101-.363 2.05-1.02 2.834l-3.087 3.68c-1.177 1.405-1.185 3.451-.019 4.863z"/>
                                                </svg>
                                            @elseif ($benefit->status == 2)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @elseif ($benefit->status == 3)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="w-full h-[0.0625rem] bg-slate-400 mb-5 mt-5"></div>
                    <div class="bg-dark flex rounded-full text-white ml-auto">
                        <a href="/PayrollandBenefit/applyform" class="gradcolor rounded-md py-2 px-7">Benefit Application</a>
                    </div>
                </div>
            </div>
        {{-- END TAMPILAN SELAIN EMPLOYEE --}}
        @endif
    </div>
</section>

@endsection