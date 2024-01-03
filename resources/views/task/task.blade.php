@extends('layout.main')

@section('container')

    @include('partials.nav')

    @include('partials.sidebar')

    {{-- Jangan diubah --}}
    <section class="flex h-full w-full items-center px-20 pb-12 pt-36" id="main">
        <div class="flex h-full w-full flex-col items-center rounded-2xl bg-tertiary px-20 py-5" id="main2">
            {{-- Sampai sini --}}
            <div class="flex w-full items-center justify-center">
                <h1 class="mb-1 text-xl text-primary">
                    TASK
                    @can('hr')
                        ACCESS
                    @endcan
                </h1>
            </div>
            <div class="-mt-9 ml-auto flex rounded-full bg-dark text-white">
                <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'unfinished']) }}"
                    class="{{ $typeFilter === '' || (request()->path() === 'task' && $typeFilter !== 'finished') ? 'gradcolor' : 'bg-dark' }} rounded-full px-4 py-2">Unfinished</a>
                <a href="{{ request()->fullUrlWithQuery(['type_filter' => 'finished']) }}"
                    class="{{ $typeFilter === 'finished' && request()->path() === 'task' ? 'gradcolor' : 'bg-dark' }} rounded-full px-4 py-2">Finished</a>
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

            <div class="mb-5 h-[0.0625rem] w-full bg-slate-400"></div>
            <div class="flex h-full w-full flex-col items-center overflow-x-auto">
                <table class="w-full text-center text-primary">
                    <thead>
                        <tr class="w-full">
                            @if (request()->query('type_filter') == 'finished' ||
                                    request()->query('type_filter') == 'unfinished' ||
                                    request()->query('type_filter') == '')
                                @can('atasan')
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            Employee Name
                                        </div>
                                    </th>
                                @endcan
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        Task Name
                                    </div>
                                </th>
                            @endif

                            @if (request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        Progress
                                    </div>
                                </th>
                            @endif

                            @if (request()->query('type_filter') == 'finished' ||
                                    request()->query('type_filter') == 'unfinished' ||
                                    request()->query('type_filter') == '')
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        Detail
                                    </div>
                                </th>
                            @endif

                            @if (request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        Deadline
                                    </div>
                                </th>
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        Time Remaining
                                    </div>
                                </th>
                                @can('karyawan')
                                    @if (auth()->user()->role !== 3)
                                        <th class="h-14 w-auto">
                                            <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                                Submit
                                            </div>
                                        </th>
                                    @endif
                                @endcan
                            @endif

                            @if (request()->query('type_filter') == 'finished')
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        Rating
                                    </div>
                                </th>
                                <th class="h-14 w-auto">
                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                        Feedback
                                    </div>
                                </th>
                            @endif

                            @if (request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                @can('manager')
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            Edit @can('hr')
                                                or Submit
                                            @endcan
                                        </div>
                                    </th>
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            Feedback
                                        </div>
                                    </th>
                                @endcan
                                @can('atasan')
                                    <th class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            Delete
                                        </div>
                                    </th>
                                @endcan
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr class="w-full">
                                @if (request()->query('type_filter') == 'finished' ||
                                        request()->query('type_filter') == 'unfinished' ||
                                        request()->query('type_filter') == '')
                                    @can('atasan')
                                        {{-- Nama Employee --}}
                                        <td class="h-14 w-auto">
                                            <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                                {{ $task->firstname . ' ' . $task->lastname }}
                                            </div>
                                        </td>
                                    @endcan
                                    {{-- Nama Task --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            {{ $task->taskname }}
                                        </div>
                                    </td>
                                @endif

                                @if (request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                    {{-- Progress --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            @if ($task->progress === null)
                                                On Progress
                                            @elseif ($task->progress === 1)
                                                Submitted
                                            @elseif ($task->progress === 2)
                                                Completed
                                            @elseif ($task->progress === 3)
                                                Revise
                                            @elseif ($daysRemaining < 1)
                                                <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                                    Late
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                                @if (request()->query('type_filter') == 'finished' ||
                                        request()->query('type_filter') == 'unfinished' ||
                                        request()->query('type_filter') == '')
                                    {{-- Detail --}}
                                    <td class="h-14 w-auto">
                                        <div class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                            <a href="/task/{{ $task->id }}" class="duration-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" class="h-6 w-auto">
                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                                @if (request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            @php
                                                $today = \Carbon\Carbon::now();
                                                $deadline = \Carbon\Carbon::parse($task->deadline);
                                                $daysRemaining = $today->diffInDays($deadline, false);
                                            @endphp
                                            {{ $deadline->format('d F Y') }}
                                        </div>
                                    </td>
                                    @can('karyawan')
                                        <td class="h-14 w-auto">
                                            <div class="m-1 rounded-lg bg-secondary px-2 py-5">
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
                                            <td class="h-14 w-auto">
                                                <div class="m-1 rounded-lg bg-secondary px-2 py-5">
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
                                        @if (request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                            {{-- Progress --}}
                                            <td class="h-14 w-auto">
                                                @if ($task->progress === null)
                                                    <div
                                                        class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                                        <a href="/task/form/{{ $task->id }}/edit"
                                                            class="duration-500 hover:scale-110">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-auto">
                                                                <path strokeLinecap="round" strokeLinejoin="round"
                                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @elseif ($task->progress === 1)
                                                    <div
                                                        class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="h-6 w-auto">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                                                        </svg>
                                                    </div>
                                                @elseif ($task->progress === 2)
                                                    <div
                                                        class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
                                                            className="w-auto h-6">
                                                            <path strokeLinecap="round" strokeLinejoin="round"
                                                                d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                                                        </svg>
                                                    </div>
                                                @elseif ($task->progress === 3)
                                                    <div
                                                        class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                                        <a href="/task/form/{{ $task->id }}/edit"
                                                            class="duration-500 hover:scale-110">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                                viewBox="0 0 24 24" class="h-6 w-5">
                                                                <path
                                                                    d="M9 19h-4v-2h4v2zm2.946-4.036l3.107 3.105-4.112.931 1.005-4.036zm12.054-5.839l-7.898 7.996-3.202-3.202 7.898-7.995 3.202 3.201zm-6 8.92v3.955h-16v-20h7.362c4.156 0 2.638 6 2.638 6s2.313-.635 4.067-.133l1.952-1.976c-2.214-2.807-5.891-5.891-7.83-5.891h-10.189v24h20v-7.98l-2 2.025z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @elseif ($daysRemaining < 1)
                                                    <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                                        Late
                                                    </div>
                                                @endif
                                            </td>
                                        @endif
                                    @endif
                                @endcan

                                @if (request()->query('type_filter') == 'finished')
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            {{ $task->rating ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="h-14 w-auto">
                                        <div class="m-1 rounded-lg bg-secondary px-2 py-5">
                                            {{ $task->feedback ?? '-' }}
                                        </div>
                                    </td>
                                @endif

                                @if (request()->query('type_filter') == 'unfinished' || request()->query('type_filter') == '')
                                    @can('manager')
                                        {{-- EDIT or SUBMIT --}}
                                        <td class="h-14 w-auto">
                                            <div
                                                class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                                <a href="/task/form/{{ $task->id }}/edit"
                                                    class="duration-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-auto">
                                                        <path strokeLinecap="round" strokeLinejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>

                                        {{-- FEEDBACK --}}
                                        <td class="h-14 w-auto">
                                            @if ($task->progress === 1)
                                                <div
                                                    class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                                    <a href="/task/feedback/{{ $task->id }}"
                                                        class="duration-500 hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-auto">
                                                            <path strokeLinecap="round" strokeLinejoin="round"
                                                                d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            @else
                                                {{-- Larang --}}
                                                <div
                                                    class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-auto">
                                                        <path strokeLinecap="round" strokeLinejoin="round"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                    @endcan

                                    @can('atasan')
                                        {{-- DELETE --}}
                                        <td class="h-14 w-auto">
                                            <form
                                                class="m-1 flex items-center justify-center rounded-lg bg-secondary px-2 py-5"
                                                action="{{ '/task' . '/' . $task->id }}" method="POST">
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
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mb-5 mt-5 h-[0.0625rem] w-full bg-slate-400"></div>
            <div
                class="@if (auth()->user()->role == 3) justify-between @else justify-center items-center @endif flex w-full flex-row">
                @can('manager')
                    <div class="w-2/5 bg-transparent text-transparent">
                        d
                    </div>
                @endcan
                <div class="@can('manager') w-2/5 @endcan">
                    {{ $tasks->links() }}
                </div>
                @can('manager')
                    <div class="ml-auto flex rounded-full text-white">
                        <a href="/createtask" class="gradcolor rounded-md px-7 py-2">Input Task</a>
                    </div>
                @endcan
            </div>
        </div>
    </section>

@endsection
