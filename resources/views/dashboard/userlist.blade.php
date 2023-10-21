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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const successAlert = document.getElementById('success-alert');
                const closeAlertButton = document.getElementById('close-alert');

                if (successAlert && closeAlertButton) {
                    closeAlertButton.addEventListener('click', function() {
                        successAlert.style.display = 'none';
                    });
                }
            });
        </script>

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
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Edit
                            </div>
                        </th>
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
                            {{-- Position Employee --}}
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
                            {{-- Edit Employee --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                    <a href="/userlist/edituser/{{ $employee->id }}" class="hover:scale-110 duration-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                </div>
                            </td>   
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection