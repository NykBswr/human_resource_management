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
                Facility List
            </h1>
        </div>
        <div class="bg-dark flex rounded-full text-white ml-auto -mt-9">
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'list']) }}" class="{{ ($typeFilter === '' || request()->path() === 'facility' && $typeFilter !== 'employee') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">List Facility</a>
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'employee']) }}" class="{{ (request()->path() === 'facility' && $typeFilter === 'employee') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-7">Employee Facility</a>
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
                    {{-- List --}}
                    @if(request()->query('type_filter') == 'list' || request()->query('type_filter') == '')
                    <tr class="w-full">
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Facility
                            </div>
                        </th>
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Description
                            </div>
                        </th>
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Remaining
                            </div>
                        </th>
                        @can('hr')
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Edit
                            </div>
                        </th>
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Delete
                            </div>
                        </th>
                        @endcan
                    </tr>
                    @endif
                    {{-- End List --}}
                    {{-- Employee --}}
                    @if(request()->query('type_filter') == 'employee')
                    <tr class="w-full">
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
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
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
                    @if(request()->query('type_filter') == 'list' || request()->query('type_filter') == '')
                    @foreach($facilities as $facility)
                        <tr class="w-full">
                            {{-- Nama Facility --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $facility->facility_name}}
                                </div>
                            </td>
                            {{-- Desc Facility --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    @if ($facility->description == '' && $facility->description == null) 
                                        -
                                    @else
                                        {{ $facility->description }}
                                    @endif
                                </div>
                            </td>
                            {{-- Remain Facility --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $facility->remain}}
                                </div>
                            </td>
                            {{-- Edit Facility --}}
                            @can('hr')
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                    <a href="/facility/edit/{{ $facility->facility_id }}" class="hover:scale-110 duration-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-auto h-6">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                </div>
                            </td> 
                            {{-- DELETE --}}
                                <td class="w-auto h-14">
                                    <form class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center" action='{{'facility' . '/' . $facility->facility_id }}' method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <p class="hover:scale-110 duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-auto h-6">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                                </svg>
                                            </p>
                                        </button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    @endif
                    {{--End List --}}
                    {{-- Employee --}}
                    @if(request()->query('type_filter') == 'employee')
                    @foreach ($employeefacilities as $facility)
                        <tr class="w-full h-auto">
                            @can('atasan')
                                {{-- Nama Employee --}}
                                <td class="w-auto h-auto">
                                    <div class="bg-secondary py-5 m-1 rounded-lg h-auto">
                                        {{ $facility['firstname'] . ' ' . $facility['lastname'] }}
                                    </div>
                                </td>
                                {{-- Role Employee --}}
                                <td class="w-auto h-auto">
                                    <div class="bg-secondary py-5 m-1 rounded-lg h-auto">
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
                                <td class="w-auto h-auto">
                                    <div class="bg-secondary py-5 m-1 rounded-lg h-auto">
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
                            <td class="w-auto h-auto">
                                <div class="bg-secondary py-5 m-1 rounded-lg h-auto flex flex-row justify-center">
                                @if (!empty($facility['facilities']) && array_filter($facility['facilities']))
                                    @php
                                        $facilityNames = array_filter($facility['facilities']);
                                    @endphp
                                    @if (count($facilityNames) > 1)
                                        <ul>
                                            @foreach ($facilityNames as $key => $facilityName)
                                                <li class="text-start">{{ $key + 1 }}. {{ $facilityName }}</li>
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
        @can('hr')
        @if(request()->query('type_filter') == 'list' || request()->query('type_filter') == '')
        <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
        <div class="bg-dark flex rounded-full text-white ml-auto">
            <a href="/facility/addfacility" class="gradcolor rounded-md py-2 px-7">Add New Facility</a>
        </div>
        @endif
        @if(request()->query('type_filter') == 'employee')
        <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
        <div class="bg-dark flex rounded-full text-white ml-auto">
            <a href="/facility/employeeadd/" class="gradcolor rounded-md py-2 px-7">Add or Delete Employee Facility</a>
        </div>
        @endif
        @endcan
    </div>
</section>

@endsection