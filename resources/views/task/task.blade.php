@extends('layout.main')

@section('container')

@include('partials.nav')

@include('partials.sidebar')

{{-- Jangan diubah --}}
<section class="w-full h-full pt-36 pb-12 px-20 flex items-center" id="main"> 
    <div class="w-full h-full bg-tertiary py-5 px-20 rounded-2xl flex flex-col items-center" id="main2">
        {{-- Sampai sini --}}
        <div class="w-full flex items-center justify-center">
            <h1 class="text-xl text-primary mb-1">
                TASK
            @can('hr')
                ACCESS
            @endcan
            </h1>
        </div>
        <div class="bg-dark flex rounded-full text-white ml-auto -mt-9">
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'unfinished']) }}" class="{{ ($typeFilter === '' || request()->path() === 'task' && $typeFilter !== 'finished') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-4">Unfinished</a>
            <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'finished']) }}" class="{{ ($typeFilter === 'finished' && request()->path() === 'task') ? 'gradcolor' : 'bg-dark' }} rounded-full py-2 px-4">Finished</a>
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
                        @if(request()->query('type_filter') == 'finished' || request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
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
                        @endif

                        @if(request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Progress
                                </div>
                            </th>
                        @endif

                        @if(request()->query('type_filter') == 'finished' || request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Detail
                                </div>
                            </th>
                        @endif

                        @if(request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Deadline
                                </div>
                            </th>
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Time Remaining
                                </div>
                            </th>
                            @can('karyawan')
                                @if (auth()->user()->role !== 3)
                                <th class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        Submit
                                    </div>
                                </th>
                                @endif
                            @endcan
                        @endif

                        @if(request()->query('type_filter') == 'finished')
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Rating
                                </div>
                            </th>
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Feedback
                                </div>
                            </th>
                        @endif

                        @if(request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                            @can('manager')
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Edit @can('hr')or Submit @endcan
                                </div>
                            </th>
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Feedback
                                </div>
                            </th>
                            @endcan
                            @can('atasan')
                            <th class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg">
                                    Delete
                                </div>
                            </th>
                            @endcan
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr class="w-full">
                            @if(request()->query('type_filter') == 'finished' || request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                @can('atasan')
                                {{-- Nama Employee --}}
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        {{ $task->firstname . ' ' . $task->lastname }}
                                    </div>
                                </td>
                                @endcan
                                {{-- Nama Task --}}
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        {{ $task->taskname }}
                                    </div>
                                </td>
                            @endif

                            @if(request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                            {{-- Progress --}}
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        @if ($task->progress === null)
                                            On Progress
                                        @elseif ($task->progress === 1)
                                            Submitted
                                        @elseif ($task->progress === 2)
                                            Completed
                                        @elseif ($task->progress === 3)
                                            Revise
                                        @elseif ($daysRemaining < 1)
                                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                                Late
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            @endif
                            @if(request()->query('type_filter') == 'finished' || request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                {{-- Detail --}}
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                        <a href="/task/{{ $task->id }}" class="hover:scale-110 duration-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            @endif
                            @if(request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        @php
                                        $today = \Carbon\Carbon::now();
                                        $deadline = \Carbon\Carbon::parse($task->deadline);
                                        $daysRemaining = $today->diffInDays($deadline, false);
                                        @endphp
                                        {{ $deadline->format('d F Y') }}
                                    </div>
                                </td>
                                @can('karyawan')
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        @if ($daysRemaining > 0)
                                            {{ $daysRemaining }} days
                                        @else
                                            You are late {{ abs($daysRemaining) }} days
                                        @endif
                                    </div>
                                </td>
                                @endcan
                                @can('atasan')
                                @if (auth()->user()->role !== 3)
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        @if ($daysRemaining > 0)
                                            {{ $daysRemaining }} days
                                        @else
                                            Late {{ abs($daysRemaining) }} days
                                        @endif
                                    </div>
                                </td>
                                @endif
                                @endcan
                            @endif

                            @can('karyawan')
                            @if (auth()->user()->role !== 3)
                                @if(request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                {{-- Progress --}}
                                    <td class="w-auto h-14">
                                        @if ($task->progress === null)
                                            <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                                <a href="/task/form/{{ $task->id }}/edit" class="hover:scale-110 duration-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                                        <path strokeLinecap="round" strokeLinejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @elseif ($task->progress === 1)
                                            <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                                                </svg>
                                            </div>
                                        @elseif ($task->progress === 2)
                                            <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-auto h-6">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                                                </svg>
                                            </div>
                                        @elseif ($task->progress === 3)
                                            <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                                <a href="/task/form/{{ $task->id }}/edit" class="hover:scale-110 duration-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-6">
                                                        <path d="M9 19h-4v-2h4v2zm2.946-4.036l3.107 3.105-4.112.931 1.005-4.036zm12.054-5.839l-7.898 7.996-3.202-3.202 7.898-7.995 3.202 3.201zm-6 8.92v3.955h-16v-20h7.362c4.156 0 2.638 6 2.638 6s2.313-.635 4.067-.133l1.952-1.976c-2.214-2.807-5.891-5.891-7.83-5.891h-10.189v24h20v-7.98l-2 2.025z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        @elseif ($daysRemaining < 1)
                                            <div class="bg-secondary py-5 m-1 rounded-lg">
                                                Late
                                            </div>
                                        @endif
                                    </td>
                                @endif
                                
                            @endif
                            @endcan

                            @if(request()->query('type_filter') == 'finished')
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        {{ $task->rating ?? '-' }}
                                    </div>
                                </td>
                                <td class="w-auto h-14">
                                    <div class="bg-secondary py-5 m-1 rounded-lg">
                                        {{ $task->feedback ?? '-' }}
                                    </div>
                                </td>
                            @endif

                            @if(request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                            @can('manager')
                            {{-- EDIT or SUBMIT --}}
                            <td class="w-auto h-14">
                                <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                    <a href="/task/form/{{ $task->id }}/edit" class="hover:scale-110 duration-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                </div>
                            </td>

                                {{-- FEEDBACK --}}
                                <td class="w-auto h-14">
                                    @if ($task->progress === 1)
                                        <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                            <a href="/task/feedback/{{ $task->id }}" class="hover:scale-110 duration-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                </svg>
                                            </a>
                                        </div>
                                    @else
                                        {{-- Larang --}}
                                        <div class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-auto h-6">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                            @endcan
                            
                            @can('atasan')
                                {{-- DELETE --}}
                                <td class="w-auto h-14">
                                    <form class="bg-secondary py-5 m-1 rounded-lg flex justify-center items-center" action="{{ '/task' .'/'. $task->id }}" method="POST">
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
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @can('manager')
            <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
            <div class="bg-dark flex rounded-full text-white ml-auto">
                <a href="/createtask" class="gradcolor rounded-md py-2 px-7">Input Task</a>
            </div>
        @endcan
    </div>
</section>

@endsection