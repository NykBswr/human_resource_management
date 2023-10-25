@extends('layout.main')

@section('container')

@include('partials.nav')

@include('partials.sidebar')

{{-- Jangan diubah --}}
<section class="w-full h-full pt-36 pb-12 px-20 flex items-center" id="main"> 
    <div class="w-full h-full bg-tertiary py-5 px-20 rounded-2xl flex flex-col items-center" id="main2">
        {{-- Sampai sini --}}
        <div class="w-full flex items-center justify-center">
            <h1 class="text-xl text-primary mb-1 uppercase">
                Off Days List
            </h1>
        </div>
        <div class="bg-dark flex rounded-full text-white ml-auto -mt-9">
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'pending']) }}" class="{{ ($typeFilter === '' || request()->path() === 'offdays' && $typeFilter !== 'approve' && $typeFilter !== 'refuse') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Pending Approval</a>
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'approve']) }}" class="{{ (request()->path() === 'offdays' && $typeFilter === 'approve') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Approved</a>
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'refuse']) }}" class="{{ (request()->path() === 'offdays' && $typeFilter === 'refuse') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Refused</a>
        </div>
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

        <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
        <div class="w-full h-full flex flex-col items-center overflow-x-auto">
            <table class="w-full text-primary text-center">
                <thead>
                    <tr class="w-full">
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                No.
                            </div>
                        </th>

                        @can('hr')
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
                        
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Date
                            </div>
                        </th>
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Reason
                            </div>
                        </th>
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Information
                            </div>
                        </th>
                        @if(request()->query('type_filter') == 'pending' || request()->query('type_filter') == '')
                            @can('hr')
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        Refuse
                                    </div>
                                </th>
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        Approve
                                    </div>
                                </th>
                            @endcan
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($offday as $key => $offday)
                        <tr class="w-full">
                            {{-- Nomor --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ '1' + $key }}
                                </div>
                            </td>
                            {{-- Employee Name --}}
                            @can ('hr')
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $offday->firstname . '' . $offday->lastname }} 
                                </div>
                            </td>
                            {{-- Role --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    @php
                                        $rolenMapping = [
                                            0 => 'Employee',
                                            1 => 'Manager',
                                            2 => 'Branch Manager'
                                        ];
                                    @endphp
                                    {{ $rolenMapping[$offday->role] }}
                                </div>
                            </td>
                            {{-- Position --}}
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
                                    {{ $positionMapping[$offday->position] }}
                                </div>
                            </td>
                            @endcan
                            {{-- Date --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    @php
                                        $start = \Carbon\Carbon::parse($offday->start);
                                        $end = \Carbon\Carbon::parse($offday->end);
                                    @endphp
                                    @if ($start->isoFormat('Y') === $end->isoFormat('Y'))
                                        {{ $start->isoFormat('D MMMM') . ' - ' . $end->isoFormat('D MMMM Y')}}
                                    @else
                                        {{ $start->isoFormat('D MMMM Y') . ' - ' . $end->isoFormat('D MMMM Y')}}
                                    @endif
                                </div>
                            </td>
                            {{-- Reason --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $offday->reason }}
                                </div>
                            </td>
                            {{-- Information --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                    <a href="{{'/storage/Proof of Leave Application/' . $offday->info }}" class="hover:scale-110 duration-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    </a>
                                </div>
                            </td>

                            @if(request()->query('type_filter') == 'pending' || request()->query('type_filter') == '')
                                @can('hr')
                                    {{-- Refuse --}}
                                    <td class="w-auto h-14">
                                        <form action="/offdays/refuse/{{ $offday->id }}" method="post" class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                        @csrf
                                            <button type="submit" class="hover:scale-110 duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-auto h-6">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td> 
                                    {{-- Approve --}}
                                    <td class="w-auto h-14">
                                        <form action="/offdays/approve/{{ $offday->id }}" method="post" class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                            @csrf
                                            <button type="submit" class="hover:scale-110 duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-auto h-6">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td> 
                                @endcan
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(request()->query('type_filter') == 'pending' || request()->query('type_filter') == '')
            <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
            <div class="bg-dark flex rounded-full text-white ml-auto">
                <a href="/sumbitapplication" class="gradcolor rounded-md py-2 px-7">Submit a Leave Application</a>
            </div>
        @endif
    </div>
</section>

@endsection