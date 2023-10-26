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
                            @if (request()->query('type_filter') == 'payroll' || request()->query('type_filter') == 'benefit')
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
                            @if (request()->query('type_filter') == 'payroll')
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
                                        Status
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Payment Date
                                    </div>
                                </th>
                                {{-- <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Salary Increase Request
                                    </div>
                                </th> --}}
                            @endif

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
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                        Pengajuan
                                    </div>
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach($offday as $key => $offday) --}}
                            <tr class="w-full">
                                @if (request()->query('type_filter') == 'payroll' || request()->query('type_filter') == 'benefit')
                                    {{-- Employee Name --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            {{-- {{ $offday->firstname . '' . $offday->lastname }}  --}}
                                        </div>
                                    </td>
                                    {{-- Role --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            {{-- @php
                                                $rolenMapping = [
                                                    0 => 'Employee',
                                                    1 => 'Manager',
                                                    2 => 'Branch Manager'
                                                ];
                                            @endphp
                                            {{ $rolenMapping[$offday->role] }} --}}
                                        </div>
                                    </td>
                                    {{-- Position --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            {{-- @php
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
                                            {{ $positionMapping[$offday->position] }} --}}
                                        </div>
                                    </td>
                                @endif

                                @if (request()->query('type_filter') == 'payroll')
                                    {{-- Salary Amount --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            
                                        </div>
                                    </td>
                                    {{-- Tax Deduction --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            
                                        </div>
                                    </td>
                                    {{-- Status  --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            
                                        </div>
                                    </td>
                                    {{-- Payment Date  --}}
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            {{-- @php
                                                $start = \Carbon\Carbon::parse($offday->start);
                                                $end = \Carbon\Carbon::parse($offday->end);
                                            @endphp
                                            @if ($start->isoFormat('Y') === $end->isoFormat('Y'))
                                                {{ $start->isoFormat('D MMMM') . ' - ' . $end->isoFormat('D MMMM Y')}}
                                            @else
                                                {{ $start->isoFormat('D MMMM Y') . ' - ' . $end->isoFormat('D MMMM Y')}}
                                            @endif --}}
                                        </div>
                                    </td>
                                @endif
                                @if (request()->query('type_filter') == 'benefit')
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            
                                        </div>
                                    </td>
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            
                                        </div>
                                    </td>
                                    <td class="w-auto h-14">
                                        <div class="bg-secondary py-5 px-2 m-1 rounded-lg">
                                            
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>
            @if(request()->query('type_filter') == 'payroll' || request()->query('type_filter') == '')
                <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
                <div class="bg-dark flex rounded-full text-white ml-auto">
                    <a href="/sumbitapplication" class="gradcolor rounded-md py-2 px-7">Salary Increase Request</a>
                </div>
            @endif
        {{-- END TAMPILAN HUMAN RESOURCE --}}
        @else
        {{-- TAMPILAN SELAIN HUMAN RESOURCE --}}
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
                                            Pengajuan
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
        {{-- END TAMPILAN SELAIN HUMAN RESOURCE --}}
        @endif
    </div>
</section>

@endsection