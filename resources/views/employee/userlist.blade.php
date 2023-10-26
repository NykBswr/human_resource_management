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
                Employee List
            </h1>
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
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Salary
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
                </thead>
                <tbody>
                    @foreach($list as $employee)
                        <tr class="w-full">
                            {{-- Nama Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $employee->firstname . ' ' . $employee->lastname }}
                                </div>
                            </td>
                            {{-- Role Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $employee->role}}
                                </div>
                            </td>
                            {{-- Position Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $employee->position}}
                                </div>
                            </td>
                            {{-- Salary Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ 'Rp.' . number_format($employee->salary, 0, ',', '.') }}
                                </div>
                            </td>
                            @can('hr')
                            {{-- Edit Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                    <a href="/userlist/edituser/{{ $employee->id }}" class="hover:scale-110 duration-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                </div>
                            </td>   
                            {{-- Delete Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                    <form action="/userlist/delete/{{ $employee->id }}" method="post">
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
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @can('hr')
        <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
        <div class="bg-dark flex rounded-full text-white ml-auto">
            <a href="/createuser" class="gradcolor rounded-md py-2 px-7">Add New Employee</a>
        </div>
        @endcan
    </div>
</section>

@endsection