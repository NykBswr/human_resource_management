@extends('layout.main')

@section('container')
    @include('partials.nav')

    @include('partials.sidebar')

    {{-- Jangan diubah --}}
    <section class="flex h-full w-full items-center px-20 pb-12 pt-36" id="main">
        <div class="flex h-full w-full flex-col items-center rounded-2xl bg-tertiary px-20 py-5" id="main2">
            {{-- Sampai sini --}}
            <div class="flex w-full items-center justify-center">
                <h1 class="mb-1 text-xl uppercase text-primary">
                    Off Days List
                </h1>
            </div>
            <div class="-mt-9 ml-auto flex rounded-full bg-dark text-white">
                <a href="/offdays?type_filter=pending"
                    class="{{ $typeFilter === '' || (request()->path() === 'offdays' && $typeFilter !== 'approve' && $typeFilter !== 'refuse') ? 'gradcolor' : 'bg-dark' }} rounded-full px-7 py-2">Pending
                    Approval</a>
                <a href="/offdays?type_filter=approve"
                    class="{{ request()->path() === 'offdays' && $typeFilter === 'approve' ? 'gradcolor' : 'bg-dark' }} rounded-full px-7 py-2">Approved</a>
                <a href="/offdays?type_filter=refuse"
                    class="{{ request()->path() === 'offdays' && $typeFilter === 'refuse' ? 'gradcolor' : 'bg-dark' }} rounded-full px-7 py-2">Refused</a>
            </div>
            <div class="mb-2 w-full">
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
            <div class="flex h-full w-full flex-col items-center overflow-x-auto">
                <table class="w-full text-center text-primary">
                    <thead>
                        <tr class="w-full">
                            <th class="h-14 w-auto">
                                <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                    No
                                </div>
                            </th>

                            @can('hr')
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        Employee Name
                                    </div>
                                </th>
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        Role
                                    </div>
                                </th>
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        Position
                                    </div>
                                </th>
                            @endcan

                            <th class="h-14 w-auto">
                                <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                    Date
                                </div>
                            </th>
                            <th class="h-14 w-auto">
                                <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                    Reason
                                </div>
                            </th>
                            <th class="h-14 w-auto">
                                <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                    Information
                                </div>
                            </th>
                            @if (request()->query('type_filter') == 'pending' || request()->query('type_filter') == '')
                                @can('hr')
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            Refuse
                                        </div>
                                    </th>
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            Approve
                                        </div>
                                    </th>
                                @endcan
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offday as $key => $offdays)
                            <tr class="w-full">
                                {{-- Nomor --}}
                                <td class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        {{ $offday->firstItem() + $key }}
                                    </div>
                                </td>
                                {{-- Employee Name --}}
                                @can('hr')
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            {{ $offdays->firstname . '' . $offdays->lastname }}
                                        </div>
                                    </td>
                                    {{-- Role --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            @php
                                                $rolenMapping = [
                                                    0 => 'Employee',
                                                    1 => 'Manager',
                                                    2 => 'Branch Manager',
                                                ];
                                            @endphp
                                            {{ $rolenMapping[$offdays->role] }}
                                        </div>
                                    </td>
                                    {{-- Position --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
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
                                            {{ $positionMapping[$offdays->position] }}
                                        </div>
                                    </td>
                                @endcan
                                {{-- Date --}}
                                <td class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        @php
                                            $start = \Carbon\Carbon::parse($offdays->start);
                                            $end = \Carbon\Carbon::parse($offdays->end);
                                        @endphp
                                        @if ($start->isoFormat('Y') === $end->isoFormat('Y'))
                                            {{ $start->isoFormat('D MMMM') . ' - ' . $end->isoFormat('D MMMM Y') }}
                                        @else
                                            {{ $start->isoFormat('D MMMM Y') . ' - ' . $end->isoFormat('D MMMM Y') }}
                                        @endif
                                    </div>
                                </td>
                                {{-- Reason --}}
                                <td class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        {{ $offdays->reason }}
                                    </div>
                                </td>
                                {{-- Information --}}
                                <td class="h-14 w-auto">
                                    <div class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                        <a href="{{ '/storage/Proof of Leave Application/' . $offdays->info }}"
                                            class="duration-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="h-6 w-auto">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>

                                @if (request()->query('type_filter') == 'pending' || request()->query('type_filter') == '')
                                    @can('hr')
                                        {{-- Refuse --}}
                                        <td class="h-14 w-auto">
                                            <form action="/offdayss/refuse/{{ $offdays->id }}" method="post"
                                                class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                                @csrf
                                                <button type="submit" class="duration-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        strokeWidth={1.5} stroke="currentColor" class="h-6 w-auto">
                                                        <path strokeLinecap="round" strokeLinejoin="round"
                                                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                        {{-- Approve --}}
                                        <td class="h-14 w-auto">
                                            <form action="/offdayss/approve/{{ $offdays->id }}" method="post"
                                                class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                                @csrf
                                                <button type="submit" class="duration-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        strokeWidth={1.5} stroke="currentColor" class="h-6 w-auto">
                                                        <path strokeLinecap="round" strokeLinejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
            <div class="mb-5 mt-5 h-[0.0625rem] w-full bg-slate-400"></div>
            <div
                class="@if (request()->query('type_filter') == 'pending' || request()->query('type_filter') == '') justify-between @else justify-center items-center @endif flex w-full flex-row">
                @if (request()->query('type_filter') == 'pending' || request()->query('type_filter') == '')
                    <div class="w-2/5 bg-transparent text-transparent">
                        d
                    </div>
                @endif
                <div class="@if (request()->query('type_filter') == 'pending' || request()->query('type_filter') == '') w-2/5 @endif">
                    {{ $offday->links() }}
                </div>
                @if (request()->query('type_filter') == 'pending' || request()->query('type_filter') == '')
                    <div class="ml-auto flex rounded-full bg-dark text-white">
                        <a href="/sumbitapplication" class="gradcolor rounded-md px-7 py-2">Submit a Leave Application</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
