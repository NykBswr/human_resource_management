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
                    Facility List
                </h1>
            </div>
            <div class="-mt-9 ml-auto flex rounded-full bg-dark text-white">
                <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'list']) }}"
                    class="{{ $typeFilter === '' || (request()->path() === 'facility' && $typeFilter !== 'employee') ? 'gradcolor' : 'bg-dark' }} rounded-full px-7 py-2">List
                    Facility</a>
                <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'employee']) }}"
                    class="{{ request()->path() === 'facility' && $typeFilter === 'employee' ? 'gradcolor' : 'bg-dark' }} rounded-full px-7 py-2">Employee
                    Facility</a>
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
                        {{-- List --}}
                        @if (request()->query('type_filter') == 'list' || request()->query('type_filter') == '')
                            <tr class="w-full">
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary py-5">
                                        Facility
                                    </div>
                                </th>
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary py-5">
                                        Description
                                    </div>
                                </th>
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary py-5">
                                        Remaining
                                    </div>
                                </th>
                                @can('hr')
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary py-5">
                                            Edit
                                        </div>
                                    </th>
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary py-5">
                                            Delete
                                        </div>
                                    </th>
                                @endcan
                            </tr>
                        @endif
                        {{-- End List --}}
                        {{-- Employee --}}
                        @if (request()->query('type_filter') == 'employee')
                            <tr class="w-full">
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
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary py-5">
                                        Facility
                                    </div>
                                </th>
                                {{-- @can('hr')
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Pengajuan
                            </div>
                        </th>
                        @endcan --}}
                            </tr>
                        @endif
                        {{-- End Employee --}}
                    </thead>
                    <tbody>
                        {{-- List --}}
                        @if (request()->query('type_filter') == 'list' || request()->query('type_filter') == '')
                            @foreach ($facilities as $facility)
                                <tr class="w-full">
                                    {{-- Nama Facility --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary py-5">
                                            {{ $facility->facility_name }}
                                        </div>
                                    </td>
                                    {{-- Desc Facility --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary py-5">
                                            @if ($facility->description == '' && $facility->description == null)
                                                -
                                            @else
                                                {{ $facility->description }}
                                            @endif
                                        </div>
                                    </td>
                                    {{-- Remain Facility --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary py-5">
                                            {{ $facility->remain }}
                                        </div>
                                    </td>
                                    {{-- Edit Facility --}}
                                    @can('hr')
                                        <td class="h-14 w-auto">
                                            <div class="m-1 flex items-center justify-center rounded-lg bg-secondary py-5">
                                                <a href="/facility/edit/{{ $facility->facility_id }}"
                                                    class="duration-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        strokeWidth={1.5} stroke="currentColor" class="h-6 w-auto">
                                                        <path strokeLinecap="round" strokeLinejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                        {{-- DELETE --}}
                                        <td class="h-14 w-auto">
                                            <form class="m-1 flex items-center justify-center rounded-lg bg-secondary py-5"
                                                action='{{ 'facility' . '/' . $facility->facility_id }}' method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    <p class="duration-500 hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                                                            class="h-6 w-auto">
                                                            <path strokeLinecap="round" strokeLinejoin="round"
                                                                d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                                        </svg>
                                                    </p>
                                                </button>
                                            </form>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        @endif
                        {{-- End List --}}
                        {{-- Employee --}}
                        @if (request()->query('type_filter') == 'employee')
                            @php
                                // Inisialisasi array untuk mengelompokkan fasilitas
                                $employeefacilities = [];

                                foreach ($employeeFacilityData as $data) {
                                    $employeeId = $data->employee_id;

                                    // Jika karyawan belum ada dalam $employeefacilities, tambahkan
                                    if (!array_key_exists($employeeId, $employeefacilities)) {
                                        $employeefacilities[$employeeId] = [
                                            'employees' => $data->employee_id,
                                            'employee_facility_id' => $data->employee_facility_id,
                                            'firstname' => $data->firstname,
                                            'lastname' => $data->lastname,
                                            'position' => $data->position,
                                            'role' => $data->role,
                                            'facilities' => [],
                                        ];
                                    }

                                    // Tambahkan fasilitas ke dalam daftar fasilitas karyawan
                                    if (!in_array($data->facility_name, $employeefacilities[$employeeId]['facilities'])) {
                                        $employeefacilities[$employeeId]['facilities'][] = $data->facility_name;
                                    }
                                }

                                if (auth()->user()->role == 0) {
                                    // Filter karyawan berdasarkan peran
                                    $employeefacilities = array_filter($employeefacilities, function ($item) {
                                        return $item['role'] == 0 && $item['employees'] == auth()->user()->id;
                                    });
                                } elseif (auth()->user()->role == 1) {
                                    $userPosition = $employee->position;
                                    $employeefacilities = array_filter($employeefacilities, function ($item) use ($userPosition) {
                                        return $item['role'] == 1 && $item['employees'] == auth()->user()->id;
                                    });
                                } elseif (auth()->user()->role == 2) {
                                    $employeefacilities = array_filter($employeefacilities, function ($item) {
                                        return $item['role'] == 2 && $item['employees'] == auth()->user()->id;
                                    });
                                } else {
                                    $employeefacilities = array_filter($employeefacilities, function ($item) {
                                        return $item['role'] != 3;
                                    });
                                }
                            @endphp
                            @foreach ($employeefacilities as $facility)
                                <tr class="h-auto w-full">
                                    @can('atasan')
                                        {{-- Nama Employee --}}
                                        <td class="h-auto w-auto">
                                            <div class="m-1 h-auto rounded-lg bg-secondary py-5">
                                                {{ $facility['firstname'] . ' ' . $facility['lastname'] }}
                                            </div>
                                        </td>
                                        {{-- Role Employee --}}
                                        <td class="h-auto w-auto">
                                            <div class="m-1 h-auto rounded-lg bg-secondary py-5">
                                                @if ($facility['role'] == 0)
                                                    Employee
                                                @elseif ($facility['role'] == 1)
                                                    Manager
                                                @elseif ($facility['role'] == 2)
                                                    Branch Manager
                                                @endif
                                            </div>
                                        </td>
                                        {{-- Position Employee --}}
                                        <td class="h-auto w-auto">
                                            <div class="m-1 h-auto rounded-lg bg-secondary py-5">
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
                                                {{ $positionMapping[$facility['position']] }}
                                            </div>
                                        </td>
                                    @endcan
                                    {{-- Facility List --}}
                                    <td class="h-auto w-auto">
                                        <div class="m-1 flex h-auto flex-row justify-center rounded-lg bg-secondary py-5">
                                            @if (!empty($facility['facilities']) && array_filter($facility['facilities']))
                                                @php
                                                    $facilityNames = array_filter($facility['facilities']);
                                                @endphp
                                                @if (count($facilityNames) > 1)
                                                    <ul>
                                                        @foreach ($facilityNames as $key => $facilityName)
                                                            <li class="text-start">{{ $key + 1 }}.
                                                                {{ $facilityName }}</li>
                                                        @endforeach
                                                    </ul>
                                        </div>
                                    @elseif (count($facilityNames) === 1)
                                        {{ reset($facilityNames) }}
                            @endif
                        @else
                            -
                        @endif
            </div>
            </td>
            </tr>
            @endforeach
            @endif
            {{-- End Employee --}}
            </tbody>
            </table>
        </div>
        <div class="mb-5 mt-5 h-[0.0625rem] w-full bg-slate-400"></div>
        @can('hr')
            @if (request()->query('type_filter') == 'list' || request()->query('type_filter') == '')
                <div class="ml-auto flex rounded-full bg-dark text-white">
                    <a href="/facility/addfacility" class="gradcolor rounded-md px-7 py-2">Add New Facility</a>
                </div>
            @endif
        @endcan
        @if (request()->query('type_filter') == 'employee')
            <div
                class="@if (auth()->user()->role == 3) justify-between @else justify-center items-center @endif flex w-full flex-row">
                @can('hr')
                    <div class="w-2/5 bg-transparent text-transparent">
                        d
                    </div>
                @endcan

                @can('hr')
                    <div class="@can('hr') w-1/5 @endcan">
                        {{ $employeeFacilityData->links() }}
                    </div>
                @endcan

                @can('hr')
                    <div class="flex w-2/5 justify-end text-white">
                        <a href="/facility/employeeadd/" class="gradcolor rounded-md px-7 py-2">Add or Delete Employee
                            Facility</a>
                    </div>
                @endcan
        @endif
        </div>
        </div>
    </section>

@endsection
