@extends('layout.main')

@section('container')

@include('partials.nav')

@include('partials.sidebar')

{{-- Jangan diubah --}}
<section class="w-full h-full pt-36 pb-12 px-20 flex items-center" id="main"> 
    <div class="w-full h-full bg-tertiary py-5 px-20 rounded-2xl flex flex-col items-center" id="main2">
        {{-- Sampai sini --}}
        <h1 class="w-full text-xl text-center text-primary mb-5">
            TASK
        </h1>
        <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
        <div class="w-full h-full flex flex-col items-center overflow-x-auto">
            <table class="w-full text-primary text-center">
                <thead>
                    <tr class="w-full">
                        @can('atasan')
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Employee Name
                            </div> 
                        </th>
                        @endcan
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Task Name
                            </div> 
                        </th>
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Progress
                            </div>
                        </th>
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Task
                            </div>
                        </th>
                        @can('karyawan')
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Submit Task
                            </div>
                        </th>
                        @endcan
                        @can('manager')
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Input Task
                            </div>
                        </th>
                        @endcan
                        @can('kepalacabang')
                        <th class="w-auto h-14">
                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                Delete Task
                            </div>
                        </th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr class="w-full">
                            @can('atasan')
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $task->firstname . ' ' . $task->lastname }}
                                </div>
                            </td>
                            @endcan
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    {{ $task->taskname }}
                                </div>
                            </td>
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    @if ($task->progress === null)
                                        On Progress
                                    @elseif ($task->progress === 1)
                                        Submitted
                                    @endif
                                </div>
                            </td>
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                    <a href="/task/{{ $task->id }}">
                                        <img src="{{ URL::asset('img/dashboard-file.svg') }}" class="h-[3vh] w-auto hover:scale-110 duration-500">
                                    </a>
                                </div>
                            </td>
                            @can('karyawan')
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    <a href="/task/form/{{ $task->id }}/edit" class="hover:scale-110 duration-500">Submit</a>
                                </div>
                            </td>
                            @endcan
                            @can('manager')
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    <a href="/task/form/{{ $task->id }}/edit" class="hover:scale-110 duration-500">Input</a>
                                </div>
                            </td>
                            @endcan
                            @can('kepalacabang')
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    <a href="/task/form/{{ $task->id }}/edit" class="hover:scale-110 duration-500">Input</a>
                                </div>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>