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
                    Employee List
                </h1>
            </div>
            <div class="mb-5 w-full">
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
            </div>

            <div class="mb-5 h-[0.0625rem] w-full bg-slate-400"></div>
            <div class="flex h-full w-full flex-col items-center overflow-x-auto">
                <table class="w-full text-center text-primary">
                    <thead>
                        <tr class="w-full">
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
                            <th class="h-14 w-auto">
                                <div class="m-1 rounded-lg bg-secondary py-5">
                                    Salary
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
                    </thead>
                    <tbody>
                        @foreach ($list as $employee)
                            <tr class="w-full">
                                {{-- Nama Employee --}}
                                <td class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary py-5">
                                        {{ $employee->firstname . ' ' . $employee->lastname }}
                                    </div>
                                </td>
                                {{-- Role Employee --}}
                                <td class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary py-5">
                                        {{ $employee->role }}
                                    </div>
                                </td>
                                {{-- Position Employee --}}
                                <td class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary py-5">
                                        {{ $employee->position }}
                                    </div>
                                </td>
                                {{-- Salary Employee --}}
                                <td class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary py-5">
                                        {{ 'Rp.' . number_format($employee->salary_amount, 0, ',', '.') }}
                                    </div>
                                </td>
                                @can('hr')
                                    {{-- Edit Employee --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 flex items-center justify-center rounded-lg bg-secondary py-5">
                                            <a href="/userlist/edituser/{{ $employee->id }}"
                                                class="duration-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="h-6 w-auto">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                    {{-- Delete Employee --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 flex items-center justify-center rounded-lg bg-secondary py-5">
                                            <form action="/userlist/delete/{{ $employee->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="duration-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" class="h-6 w-auto">
                                                        <path strokeLinecap="round" strokeLinejoin="round"
                                                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
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
            <div class="my-5 h-[0.0625rem] w-full bg-slate-400"></div>
            <div
                class="@if (auth()->user()->role == 3) justify-between @else justify-center items-center @endif flex w-full flex-row">
                @can('hr')
                    <div class="w-2/5 bg-transparent text-transparent">
                        d
                    </div>
                @endcan
                <div class="@can('hr') w-2/5 @endcan">
                    {{ $list->links() }}
                </div>
                @can('hr')
                    <div class="flex w-1/5 justify-end text-white">
                        <a href="/createuser" class="gradcolor rounded-md px-7 py-2">Add New Employee</a>
                    </div>
                @endcan
            </div>
        </div>
    </section>
@endsection
