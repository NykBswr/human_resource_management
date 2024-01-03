@extends('layout.main')

@section('container')

    @include('partials.nav')

    @include('partials.sidebar')

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <section class="flex h-auto w-full items-center bg-dark px-20 pb-12 pt-36" id="main">
        <div class="flex h-full w-full flex-col items-center rounded-2xl bg-tertiary px-20 py-5" id="main2">
            <h1 class="mb-5 w-full text-center text-xl text-primary">
                DASHBOARD
            </h1>
            <div class="mb-5 h-[0.0625rem] w-full bg-slate-400"></div>
            <div class="@if (auth()->user()->role == 3) justify-between @endif flex h-auto w-full flex-row">
                {{-- First Column --}}
                <div
                    class="@if (auth()->user()->role == 1) flex-col @endif @if (auth()->user()->role == 3 || auth()->user()->role == 2) w-5/12 @else w-1/2 @endif mr-5 h-full">
                    {{-- Task --}}
                    <div class="h-2/5 w-full">
                        @php
                            $todaysDate = now()->toDateString();
                            $totalTasks = $tasksQuery->count();
                            $checkTasks = $tasksQuery->where('progress', 1)->count();
                            $completedTasks = $tasksQuery->where('progress', 2)->count();
                            $revisedTasks = $tasksQuery->where('progress', 3)->count();
                            $lateTasks = $tasksQuery
                                ->where('progress', 0)
                                ->filter(function ($task) use ($todaysDate) {
                                    return $task->deadline <= $todaysDate;
                                })
                                ->count();

                            $remainingTasks = $totalTasks - $completedTasks - $revisedTasks - $checkTasks - $lateTasks;

                            $completionPercentage = ($completedTasks / $totalTasks) * 100;
                            $checkPercentage = ($checkTasks / $totalTasks) * 100;
                            $revisedPercentage = ($revisedTasks / $totalTasks) * 100;
                            $remainingTasksPercentage = ($remainingTasks / $totalTasks) * 100;
                            $lateTasksPercentage = ($lateTasks / $totalTasks) * 100;

                            if ($completedTasks == 0 || $completedTasks == null) {
                                $overallRating = $ratings;
                            } else {
                                $overallRating = $ratings * 10;
                            }

                            $positions = [0, 1, 2, 3, 4, 5, 6, 7];
                            $userrole = auth()->user()->role;
                            $totals = $completed = $revised = $checked = $remaining = $completionPosPercentage = $checkPosPercentage = $revisedPosPercentage = $remainingPosPercentage = [];
                            if (auth()->user()->role == 2 || auth()->user()->role == 3) {
                                // Loop untuk setiap posisi
                                foreach ($positions as $position) {
                                    // Total tasks
                                    $totals[$position] = $tasksQuery->where('position', $position)->count();
                                    // Checked tasks
                                    $checked[$position] = $tasksQuery
                                        ->where('position', $position)
                                        ->where('progress', 1)
                                        ->count();
                                    // Completed tasks
                                    $completed[$position] = $tasksQuery
                                        ->where('position', $position)
                                        ->where('progress', 2)
                                        ->count();
                                    // Revised tasks
                                    $revised[$position] = $tasksQuery
                                        ->where('position', $position)
                                        ->where('progress', 3)
                                        ->count();
                                    $late[$position] = $tasksQuery
                                        ->where('position', $position)
                                        ->where('progress', 0)
                                        ->filter(function ($task) use ($todaysDate) {
                                            return $task->deadline >= $todaysDate;
                                        })
                                        ->count();
                                    // Remaining tasks
                                    $remaining[$position] = $totals[$position] - $completed[$position] - $revised[$position] - $checked[$position] - $late[$position];

                                    // Percentage
                                    $completionPosPercentage[$position] = number_format(($completed[$position] / $totals[$position]) * 100, 0);
                                    $checkPosPercentage[$position] = number_format(($checked[$position] / $totals[$position]) * 100, 0);
                                    $revisedPosPercentage[$position] = number_format(($revised[$position] / $totals[$position]) * 100, 0);
                                    $remainingPosPercentage[$position] = number_format(($remaining[$position] / $totals[$position]) * 100, 0);
                                    $latePosPercentage[$position] = number_format(($late[$position] / $totals[$position]) * 100, 0);
                                }
                            }
                        @endphp

                        <div class="w-full rounded-lg bg-secondary p-4 shadow md:p-6">
                            <div class="mb-3 flex w-full justify-between">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center">
                                        <h5 class="mb-2 pe-1 text-xl font-bold leading-none text-white">Your employee's
                                            progress
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="h-full rounded-lg bg-tertiary p-3">
                                <div class="mb-2 grid grid-cols-3 gap-3">
                                    <dl
                                        class="flex h-[78px] w-full flex-col items-center justify-center rounded-lg bg-dark">
                                        <dt
                                            class="mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-red-50 text-sm font-medium text-red-600">
                                            {{ $remainingTasks }}</dt>
                                        <dd class="text-center text-sm font-medium text-red-500">
                                            @if (auth()->user()->id == 0)
                                                To do
                                            @else
                                                In progress
                                            @endif
                                        </dd>
                                    </dl>
                                    <dl class="flex h-[78px] flex-col items-center justify-center rounded-lg bg-dark">
                                        <dt
                                            class="mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-yellow-50 text-sm font-medium text-yellow-600">
                                            {{ $revisedTasks }}</dt>
                                        <dd class="text-center text-sm font-medium text-yellow-300">Revised</dd>
                                    </dl>
                                    <dl class="flex h-[78px] flex-col items-center justify-center rounded-lg bg-dark">
                                        <dt
                                            class="mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-green-50 text-sm font-medium text-green-500">
                                            {{ $completedTasks }}</dt>
                                        <dd class="text-center text-sm font-medium text-green-500">Done</dd>
                                    </dl>
                                </div>
                                <button data-collapse-toggle="more-details" type="button"
                                    class="inline-flex h-full items-center text-xs font-medium text-gray-300 hover:underline">Show
                                    more
                                    details <svg class="ms-1 h-2 w-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <div id="more-details" class="mt-3 hidden h-full space-y-2 border-t border-gray-200 pt-3">
                                    {{-- @if (!auth()->user()->role == 3)
                                        <dl class="flex items-center justify-between">
                                            <dt class="text-sm font-normal text-gray-400">Average task completion rate:</dt>
                                            <dd
                                                class="inline-flex items-center rounded-md bg-green-100 px-2.5 py-1 text-xs font-medium text-green-900">
                                                <svg class="me-1.5 h-2.5 w-2.5" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13V1m0 0L1 5m4-4 4 4" />
                                                </svg> {{ number_format($overallRating, 2) }}%
                                            </dd>
                                        </dl>
                                    @endif --}}
                                    <dl class="flex items-center justify-between">
                                        <dt class="text-sm font-normal text-gray-400">Being checked:</dt>
                                        <dd
                                            class="inline-flex items-center rounded-md bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-500">
                                            {{ $checkTasks }}</dd>
                                    </dl>
                                    <dl class="flex items-center justify-between">
                                        <dt class="text-sm font-normal text-gray-400">Late:</dt>
                                        <dd
                                            class="inline-flex items-center rounded-md bg-red-100 px-2.5 py-1 text-xs font-medium text-red-500">
                                            {{ $lateTasks }}</dd>
                                    </dl>
                                </div>
                            </div>

                            <!-- Radial Chart -->
                            <div class="py-6" id="donut-chart"></div>
                            @if (auth()->user()->role == 3 || auth()->user()->role == 2)
                                <div id="accordion-collapse" data-accordion="collapse" class="rounded-xl bg-tertiary">
                                    <h3 id="accordion-collapse-heading-1">
                                        <button type="button"
                                            class="flex w-full items-center justify-between gap-3 rounded-xl bg-tertiary px-5 py-2 font-medium text-white hover:underline hover:underline-offset-4 rtl:text-right"
                                            data-accordion-target="#accordion-collapse-body-1" aria-expanded="false"
                                            aria-controls="accordion-collapse-body-1">
                                            <span>Select Position</span>
                                            <svg data-accordion-icon class="h-2 w-2 shrink-0 rotate-180" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M9 5 5 1 1 5" />
                                            </svg>
                                        </button>
                                    </h3>

                                    <div id="accordion-collapse-body-1" class="hidden"
                                        aria-labelledby="accordion-collapse-heading-1">
                                        <div class="flex flex-col rounded-xl bg-tertiary px-5 py-2" id="position">
                                            <div class="mb-2 flex justify-between">
                                                <div class="me-4 flex items-center">
                                                    <input id="business" type="checkbox" value="business"
                                                        class="h-4 w-4 rounded bg-gray-700 ring-offset-gray-800 focus:ring-2 focus:ring-blue-600">
                                                    <label for="business"
                                                        class="ms-2 text-xs font-medium text-gray-100">Business
                                                        Analyst</label>
                                                </div>
                                                <div class="me-4 flex items-center">
                                                    <input id="scientist" type="checkbox" value="scientist"
                                                        class="h-4 w-4 rounded bg-gray-700 ring-offset-gray-800 focus:ring-2 focus:ring-blue-600">
                                                    <label for="scientist"
                                                        class="ms-2 text-xs font-medium text-gray-100">Data
                                                        Scientist</label>
                                                </div>
                                            </div>
                                            <div class="mb-2 flex justify-stretch">
                                                <div class="me-4 flex items-center">
                                                    <input id="analysis" type="checkbox" value="analysis"
                                                        class="h-4 w-4 rounded bg-gray-700 ring-offset-gray-800 focus:ring-2 focus:ring-blue-600">
                                                    <label for="analysis"
                                                        class="ms-2 text-xs font-medium text-gray-100">Data
                                                        Analysis</label>
                                                </div>
                                                <div class="me-4 flex items-center">
                                                    <input id="auditor" type="checkbox" value="auditor"
                                                        class="h-4 w-4 rounded bg-gray-700 ring-offset-gray-800 focus:ring-2 focus:ring-blue-600">
                                                    <label for="auditor"
                                                        class="ms-2 text-xs font-medium text-gray-100">Auditor</label>
                                                </div>
                                                <div class="me-4 flex items-center">
                                                    <input id="staff" type="checkbox" value="staff"
                                                        class="h-4 w-4 rounded bg-gray-700 ring-offset-gray-800 focus:ring-2 focus:ring-blue-600">
                                                    <label for="staff"
                                                        class="ms-2 text-xs font-medium text-gray-100">Staff</label>
                                                </div>
                                            </div>
                                            <div class="mb-2 flex justify-stretch">
                                                <div class="me-4 flex items-center">
                                                    <input id="teller" type="checkbox" value="teller"
                                                        class="h-4 w-4 rounded bg-gray-700 ring-offset-gray-800 focus:ring-2 focus:ring-blue-600">
                                                    <label for="teller"
                                                        class="ms-2 text-xs font-medium text-gray-100">Teller</label>
                                                </div>
                                                <div class="me-4 flex items-center">
                                                    <input id="sales" type="checkbox" value="sales"
                                                        class="h-4 w-4 rounded bg-gray-700 ring-offset-gray-800 focus:ring-2 focus:ring-blue-600">
                                                    <label for="sales"
                                                        class="ms-2 text-xs font-medium text-gray-100">Sales</label>
                                                </div>
                                                <div class="me-4 flex items-center">
                                                    <input id="akuntan" type="checkbox" value="akuntan"
                                                        class="h-4 w-4 rounded bg-gray-700 ring-offset-gray-800 focus:ring-2 focus:ring-blue-600">
                                                    <label for="akuntan"
                                                        class="ms-2 text-xs font-medium text-gray-100">Akuntan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-5 grid grid-cols-1 items-center justify-between border-t border-gray-200">
                                <div class="flex items-center justify-end pt-5">
                                    <a href="/task"
                                        class="inline-flex items-center rounded-lg px-5 py-2 text-sm font-semibold uppercase text-white hover:bg-tertiary hover:text-white">
                                        See all task
                                        <svg class="ms-1.5 h-2.5 w-2.5 rtl:rotate-180" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- ApexCharts options and config -->
                        <script>
                            window.addEventListener("load", function() {
                                const getChartOptions = () => {
                                    return {
                                        series: [{{ number_format($lateTasksPercentage, 2) }},
                                            {{ number_format($remainingTasksPercentage, 2) }},
                                            {{ number_format($revisedPercentage, 2) }},
                                            {{ number_format($checkPercentage, 2) }},
                                            {{ number_format($completionPercentage, 2) }}
                                        ],
                                        colors: ["#f64f59", "#DC67CE", "#A367DC", "#6771DC", "#6794DC", ],
                                        chart: {
                                            height: 320,
                                            width: "100%",
                                            type: "donut",
                                        },
                                        stroke: {
                                            colors: ["transparent"],
                                            lineCap: "",
                                        },
                                        plotOptions: {
                                            pie: {
                                                donut: {
                                                    labels: {
                                                        show: false,
                                                        name: {
                                                            show: true,
                                                            fill: "#FFFFFF",
                                                            fontFamily: "Inter, sans-serif",
                                                            offsetY: 20,
                                                        },

                                                        value: {
                                                            show: true,
                                                            fill: "#FFFFFF",
                                                            fontFamily: "Inter, sans-serif",
                                                            offsetY: -20,
                                                            formatter: function(value) {
                                                                return value + "%";
                                                            },
                                                        },
                                                    },
                                                    size: "80%",
                                                },
                                            },
                                        },
                                        grid: {
                                            padding: {
                                                top: -2,
                                            },
                                        },
                                        labels: ["Late", "Remaining Task", "Revised", "In assessment", "Done"],
                                        dataLabels: {
                                            enabled: false,
                                        },
                                        legend: {
                                            position: "bottom",
                                            fontFamily: "Inter, sans-serif",
                                            fill: "#FFFFFF",
                                            labels: {
                                                useSeriesColors: false,
                                                fillColors: "#FFFFFF",
                                            },
                                            markers: {
                                                fillColors: ["#f64f59", "#DC67CE", "#A367DC", "#6771DC", "#67B7DC"],
                                            },
                                        },
                                        yaxis: {
                                            labels: {
                                                formatter: function(value) {
                                                    return value + "%";
                                                },
                                            },
                                        },
                                        xaxis: {
                                            labels: {
                                                formatter: function(value) {
                                                    return value + "%";
                                                },
                                            },
                                            axisTicks: {
                                                show: false,
                                            },
                                            axisBorder: {
                                                show: false,
                                            },
                                        },
                                    };
                                };

                                if (document.getElementById("donut-chart") && typeof ApexCharts !== 'undefined') {
                                    const chart = new ApexCharts(document.getElementById("donut-chart"), getChartOptions());
                                    chart.render();

                                    // Get all the checkboxes by their class name
                                    const checkboxes = document.querySelectorAll('#position input[type="checkbox"]');

                                    // Function to handle the checkbox change event
                                    function handleCheckboxChange(event, chart) {
                                        const checkbox = event.target;
                                        if (checkbox.checked) {
                                            switch (checkbox.value) {
                                                @if ($userrole !== 1 && $userrole !== 0 && $userrole !== null)
                                                    case 'business':
                                                    chart.updateSeries([{{ $latePosPercentage[0] }}, {{ $remainingPosPercentage[0] }},
                                                        {{ $revisedPosPercentage[0] }}, {{ $checkPosPercentage[0] }},
                                                        {{ $completionPosPercentage[0] }}
                                                    ]);
                                                    break;
                                                    case 'analysis':
                                                    chart.updateSeries([{{ $latePosPercentage[1] }}, {{ $remainingPosPercentage[1] }},
                                                        {{ $revisedPosPercentage[1] }}, {{ $checkPosPercentage[1] }},
                                                        {{ $completionPosPercentage[1] }}
                                                    ]);
                                                    break;
                                                    case 'scientist':
                                                    chart.updateSeries([{{ $latePosPercentage[2] }}, {{ $remainingPosPercentage[2] }},
                                                        {{ $revisedPosPercentage[2] }}, {{ $checkPosPercentage[2] }},
                                                        {{ $completionPosPercentage[2] }}
                                                    ]);
                                                    break;
                                                    case 'teller':
                                                    chart.updateSeries([{{ $latePosPercentage[3] }}, {{ $remainingPosPercentage[3] }},
                                                        {{ $revisedPosPercentage[3] }}, {{ $checkPosPercentage[3] }},
                                                        {{ $completionPosPercentage[3] }}
                                                    ]);
                                                    break;
                                                    case 'auditor':
                                                    chart.updateSeries([{{ $latePosPercentage[4] }}, {{ $remainingPosPercentage[4] }},
                                                        {{ $revisedPosPercentage[4] }}, {{ $checkPosPercentage[4] }},
                                                        {{ $completionPosPercentage[4] }}
                                                    ]);
                                                    break;
                                                    case 'staff':
                                                    chart.updateSeries([{{ $latePosPercentage[5] }}, {{ $remainingPosPercentage[5] }},
                                                        {{ $revisedPosPercentage[5] }}, {{ $checkPosPercentage[5] }},
                                                        {{ $completionPosPercentage[5] }}
                                                    ]);
                                                    break;
                                                    case 'sales':
                                                    chart.updateSeries([{{ $latePosPercentage[6] }}, {{ $remainingPosPercentage[6] }},
                                                        {{ $revisedPosPercentage[6] }}, {{ $checkPosPercentage[6] }},
                                                        {{ $completionPosPercentage[6] }}
                                                    ]);
                                                    break;
                                                    case 'akuntan':
                                                    chart.updateSeries([{{ $latePosPercentage[7] }}, {{ $remainingPosPercentage[7] }},
                                                        {{ $revisedPosPercentage[7] }}, {{ $checkPosPercentage[7] }},
                                                        {{ $completionPosPercentage[7] }}
                                                    ]);
                                                    break;
                                                @endif
                                                default:
                                                    chart.updateSeries([{{ number_format($lateTasksPercentage, 0) }},
                                                        {{ number_format($remainingTasksPercentage, 0) }},
                                                        {{ number_format($revisedPercentage, 0) }},
                                                        {{ number_format($checkPercentage, 0) }},
                                                        {{ number_format($completionPercentage, 0) }}
                                                    ]);
                                            }
                                        } else {
                                            chart.updateSeries([{{ number_format($lateTasksPercentage, 0) }},
                                                {{ number_format($remainingTasksPercentage, 0) }},
                                                {{ number_format($revisedPercentage, 0) }},
                                                {{ number_format($checkPercentage, 0) }},
                                                {{ number_format($completionPercentage, 0) }}
                                            ]);
                                        }
                                    }

                                    // Attach the event listener to each checkbox
                                    checkboxes.forEach((checkbox) => {
                                        checkbox.addEventListener('change', (event) => handleCheckboxChange(event,
                                            chart));
                                    });
                                }
                            });
                        </script>
                    </div>
                    {{-- End of Task --}}

                    {{-- Rating --}}
                    @if (auth()->user()->role == 3 || auth()->user()->role == 2 || auth()->user()->role == 1)
                        <div class="mt-5 h-1/5 w-full rounded-lg bg-secondary p-4 shadow md:p-6">
                            <div class="mb-3 flex h-full w-full justify-between">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center">
                                        <h5 class="mb-2 pe-1 text-xl font-bold leading-none text-white">Your employee's
                                            rating
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="@if (auth()->user()->role == 3 || auth()->user()->role == 2) mb-5 @endif flex h-full items-center">
                                <p
                                    class="@if (number_format($ratings, 1) > 7.5) excellentColor
                                    @elseif (number_format($ratings, 1) > 5) greatColor
                                    @elseif (number_format($ratings, 1) > 3.5) averageColor
                                    @else poorColor @endif inline-flex items-center rounded p-1.5 text-sm font-semibold text-white">
                                    {{ number_format($ratings, 1) }}
                                </p>

                                <p class="ms-2 font-medium text-gray-900 dark:text-white">
                                    @if (number_format($ratings, 1) > 7.5)
                                        Excellent
                                    @elseif (number_format($ratings, 1) > 5)
                                        Great
                                    @elseif (number_format($ratings, 1) > 3.5)
                                        Average
                                    @else
                                        Poor
                                    @endif
                                </p>

                                <a href="/task?type_filter=finished"
                                    class="ms-auto text-sm font-medium text-white hover:underline">See
                                    all
                                    rating</a>
                            </div>
                            @if (auth()->user()->role == 3 || auth()->user()->role == 2)
                                @php
                                    // Inisialisasi variabel
                                    $positions2 = [0, 1, 2, 3, 4, 5, 6, 7];
                                    $ratingPos = [];

                                    // Memeriksa peran pengguna
                                    if (auth()->user()->role == 2 || auth()->user()->role == 3) {
                                        // Loop untuk setiap posisi
                                        foreach ($positions2 as $position) {
                                            $totals[$position] = $tasksQuery->where('position', $position)->count();
                                            $rate[$position] = $tasksQuery->where('position', $position)->average('rating');
                                            // Percentage
                                            $ratingPos[$position] = number_format($rate[$position], 1);
                                        }
                                    }
                                @endphp
                                <div class="h-full gap-8 sm:grid sm:grid-cols-2">
                                    <div class="h-full w-full">
                                        <dl>
                                            <dt class="text-sm font-medium text-white">Business Analyst</dt>
                                            <dd class="mb-3 flex items-center">
                                                <div class="me-2 h-2.5 w-full rounded bg-gray-200 dark:bg-gray-700">
                                                    <div class="@if (number_format($ratingPos[0], 1) > 7.5) excellentColor
                                                    @elseif (number_format($ratingPos[0], 1) > 5)
                                                        greatColor
                                                    @elseif (number_format($ratingPos[0], 1) > 3.5)
                                                        averageColor
                                                    @else
                                                    poorColor @endif h-2.5 rounded"
                                                        style="width: {{ $ratingPos[0] * 10 }}">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium text-white">{{ $ratingPos[0] }}</span>
                                            </dd>
                                        </dl>
                                        <dl>
                                            <dt class="text-sm font-medium text-white">Data Scientist</dt>
                                            <dd class="mb-3 flex items-center">
                                                <div class="me-2 h-2.5 w-full rounded bg-gray-200 dark:bg-gray-700">
                                                    <div class="@if (number_format($ratingPos[1], 1) > 7.5) excellentColor
                                                    @elseif (number_format($ratingPos[1], 1) > 5)
                                                        greatColor
                                                    @elseif (number_format($ratingPos[1], 1) > 3.5)
                                                        averageColor
                                                    @else
                                                    poorColor @endif h-2.5 rounded"
                                                        style="width: {{ $ratingPos[1] * 10 }}">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium text-white">{{ $ratingPos[1] }}</span>
                                            </dd>
                                        </dl>
                                        <dl>
                                            <dt class="text-sm font-medium text-white">Data Analyst</dt>
                                            <dd class="mb-3 flex items-center">
                                                <div class="me-2 h-2.5 w-full rounded bg-gray-200 dark:bg-gray-700">
                                                    <div class="@if (number_format($ratingPos[2], 1) > 7.5) excellentColor
                                                    @elseif (number_format($ratingPos[2], 1) > 5)
                                                        greatColor
                                                    @elseif (number_format($ratingPos[2], 1) > 3.5)
                                                        averageColor
                                                    @else
                                                    poorColor @endif h-2.5 rounded"
                                                        style="width: {{ $ratingPos[2] * 10 }}">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium text-white">{{ $ratingPos[2] }}</span>
                                            </dd>
                                        </dl>
                                        <dl>
                                            <dt class="text-sm font-medium text-white">Teller</dt>
                                            <dd class="flex items-center">
                                                <div class="me-2 h-2.5 w-full rounded bg-gray-200 dark:bg-gray-700">
                                                    <div class="@if (number_format($ratingPos[3], 1) > 7.5) excellentColor
                                                    @elseif (number_format($ratingPos[3], 1) > 5)
                                                        greatColor
                                                    @elseif (number_format($ratingPos[3], 1) > 3.5)
                                                        averageColor
                                                    @else
                                                    poorColor @endif h-2.5 rounded"
                                                        style="width: {{ $ratingPos[3] * 10 }}">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium text-white">{{ $ratingPos[3] }}</span>
                                            </dd>
                                        </dl>
                                    </div>
                                    <div>
                                        <dl>
                                            <dt class="text-sm font-medium text-white">Auditor</dt>
                                            <dd class="mb-3 flex items-center">
                                                <div class="me-2 h-2.5 w-full rounded bg-gray-200 dark:bg-gray-700">
                                                    <div class="@if (number_format($ratingPos[4], 1) > 7.5) excellentColor
                                                    @elseif (number_format($ratingPos[4], 1) > 5)
                                                        greatColor
                                                    @elseif (number_format($ratingPos[4], 1) > 3.5)
                                                        averageColor
                                                    @else
                                                    poorColor @endif h-2.5 rounded"
                                                        style="width: {{ $ratingPos[4] * 10 }}">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium text-white">{{ $ratingPos[4] }}</span>
                                            </dd>
                                        </dl>
                                        <dl>
                                            <dt class="text-sm font-medium text-white">Staff</dt>
                                            <dd class="mb-3 flex items-center">
                                                <div class="me-2 h-2.5 w-full rounded bg-gray-200 dark:bg-gray-700">
                                                    <div class="@if (number_format($ratingPos[5], 1) > 7.5) excellentColor
                                                    @elseif (number_format($ratingPos[5], 1) > 5)
                                                        greatColor
                                                    @elseif (number_format($ratingPos[5], 1) > 3.5)
                                                        averageColor
                                                    @else
                                                    poorColor @endif h-2.5 rounded"
                                                        style="width: {{ $ratingPos[5] * 10 }}">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium text-white">{{ $ratingPos[5] }}</span>
                                            </dd>
                                        </dl>
                                        <dl>
                                            <dt class="text-sm font-medium text-white">Sales</dt>
                                            <dd class="mb-3 flex items-center">
                                                <div class="me-2 h-2.5 w-full rounded bg-gray-200 dark:bg-gray-700">
                                                    <div class="@if (number_format($ratingPos[6], 1) > 7.5) excellentColor
                                                    @elseif (number_format($ratingPos[6], 1) > 5)
                                                        greatColor
                                                    @elseif (number_format($ratingPos[6], 1) > 3.5)
                                                        averageColor
                                                    @else
                                                    poorColor @endif h-2.5 rounded"
                                                        style="width: {{ $ratingPos[6] * 10 }}">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium text-white">{{ $ratingPos[6] }}</span>
                                            </dd>
                                        </dl>
                                        <dl>
                                            <dt class="text-sm font-medium text-white">Akuntan</dt>
                                            <dd class="flex items-center">
                                                <div class="me-2 h-2.5 w-full rounded bg-gray-200 dark:bg-gray-700">
                                                    <div class="@if (number_format($ratingPos[7], 1) > 7.5) excellentColor
                                                    @elseif (number_format($ratingPos[7], 1) > 5)
                                                        greatColor
                                                    @elseif (number_format($ratingPos[7], 1) > 3.5)
                                                        averageColor
                                                    @else
                                                    poorColor @endif h-2.5 rounded"
                                                        style="width: {{ $ratingPos[7] * 10 }}">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-medium text-white">{{ $ratingPos[7] }}</span>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    {{-- End of Rating --}}

                    {{-- Attendance --}}
                    <div class="mt-5 h-2/5 w-full rounded-lg bg-secondary p-4 shadow md:p-6">
                        <div class="mb-3 flex h-full w-full flex-col items-center justify-between">
                            <div class="flex h-auto w-full items-center justify-center text-center">
                                <h5 class="mb-2 pe-1 text-xl font-bold leading-none text-white">Attendance
                                    Information
                                </h5>
                            </div>
                            <div class="mb-5 flex w-full items-center justify-center">
                                <!-- Dropdown menu -->
                                @if (auth()->user()->role == 3 || auth()->user()->role == 2)
                                    <button id="dropdownDefaultButton" data-dropdown-toggle="category11"
                                        class="mr-2 inline-flex w-1/2 items-center justify-between rounded-lg bg-tertiary px-5 py-2.5 text-center text-sm font-medium text-white"
                                        type="button">
                                        @if ($filterAttend == '')
                                            Category
                                        @elseif ($filterAttend == 'all_attend')
                                            All Attendance
                                        @elseif ($filterAttend == 'absent')
                                            Absent
                                        @elseif ($filterAttend == 'lateness')
                                            Lateness
                                        @elseif ($filterAttend == 'missingOut')
                                            Missing Out
                                        @elseif ($filterAttend == 'present')
                                            Present
                                        @elseif ($filterAttend == 'business_analyst')
                                            Business Analyst
                                        @elseif ($filterAttend == 'data_scientist')
                                            Data Scientist
                                        @elseif ($filterAttend == 'data_analyst')
                                            Data Analyst
                                        @elseif ($filterAttend == 'teller')
                                            Teller
                                        @elseif ($filterAttend == 'auditor')
                                            Auditor
                                        @elseif ($filterAttend == 'sales')
                                            Sales
                                        @elseif ($filterAttend == 'staff')
                                            Staff
                                        @elseif ($filterAttend == 'akuntan')
                                            Akuntan
                                        @endif
                                        <svg class="ms-3 h-2.5 w-2.5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div id="category11"
                                        class="z-10 hidden w-72 cursor-pointer rounded-lg bg-tertiary shadow">
                                        <div id="category11" class="w-full py-2 text-sm text-white"
                                            aria-labelledby="dropdownDefaseultButton">
                                            <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'all_attend']) }}"
                                                class="block w-full border-b border-white px-4 py-2 text-center hover:bg-gray-600 hover:text-white">
                                                All Attendance
                                            </a>
                                            <p
                                                class="block w-full cursor-default border-b border-white px-4 py-2 text-center">
                                                By Position
                                            </p>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'business_analyst']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">Business
                                                    Analyst
                                                </a>
                                                <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'data_analyst']) }}"
                                                    class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Data Analyst
                                                </a>
                                            </div>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'data_scientist']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Data Scientist
                                                </a>
                                                <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'teller']) }}"
                                                    class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Teller
                                                </a>
                                            </div>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'auditor']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Auditor
                                                </a>
                                                <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'staff']) }}"
                                                    class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Staff
                                                </a>
                                            </div>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'sales']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Sales
                                                </a>
                                                <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'akuntan']) }}"
                                                    class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Akuntan
                                                </a>
                                            </div>
                                            {{-- <p class="block w-full cursor-default border-y border-white px-4 py-2 text-center">
                                            By Status
                                        </p>
                                        <div class="flex w-full flex-row">
                                            <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'absent']) }}"
                                                class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                Absent
                                            </a>
                                            <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'late']) }}"
                                                class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                Lateness
                                            </a>
                                        </div>
                                        <div class="flex w-full flex-row">
                                            <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'missingOut']) }}"
                                                class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                Missing Out
                                            </a>
                                            <a href="{{ request()->fullUrlWithQuery(['filter_attend' => 'present']) }}"
                                                class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                Present
                                            </a>
                                        </div> --}}
                                        </div>
                                    </div>
                                @endif

                                @php
                                    if (auth()->user()->role == 2 || auth()->user()->role == 3) {
                                        if ($filterAttend == '' || $filterAttend == 'all_attend') {
                                            // Lakukan sesuatu jika kondisi terpenuhi
                                            $attend = $attend;
                                        } else {
                                            if ($filterAttend == 'business_analyst') {
                                                $filling = 0;
                                            } elseif ($filterAttend == 'data_analyst') {
                                                $filling = 1;
                                            } elseif ($filterAttend == 'data_scientist') {
                                                $filling = 2;
                                            } elseif ($filterAttend == 'teller') {
                                                $filling = 3;
                                            } elseif ($filterAttend == 'auditor') {
                                                $filling = 4;
                                            } elseif ($filterAttend == 'staff') {
                                                $filling = 5;
                                            } elseif ($filterAttend == 'sales') {
                                                $filling = 6;
                                            } elseif ($filterAttend == 'akuntan') {
                                                $filling = 7;
                                            }
                                            // Lakukan sesuatu jika kondisi tidak terpenuhi
                                            $attend = $attend->where('position', $filling);
                                        }
                                    }

                                    // Menghitung total kehadiran
                                    $totalAttend = $attend->whereBetween('date', [date('Y-m-d', strtotime($startDate)), date('Y-m-d', strtotime($endDate))])->count();

                                    // Menghitung persentase absent
                                    $absent =
                                        ($attend
                                            ->whereBetween('date', [date('Y-m-d', strtotime($startDate)), date('Y-m-d', strtotime($endDate))])
                                            ->whereBetween('date', [$startDate, $endDate])
                                            ->where('in', null)
                                            ->where('out', null)
                                            ->count() /
                                            $totalAttend) *
                                        100;

                                    // Menghitung persentase missingOut
                                    $missingOut =
                                        ($attend
                                            ->whereBetween('date', [date('Y-m-d', strtotime($startDate)), date('Y-m-d', strtotime($endDate))])
                                            ->whereNotNull('in')
                                            ->where('out', null)
                                            ->count() /
                                            $totalAttend) *
                                        100;

                                    // Menghitung persentase lateness
                                    $lateness =
                                        ($attend
                                            ->whereBetween('date', [date('Y-m-d', strtotime($startDate)), date('Y-m-d', strtotime($endDate))])
                                            ->where('in', '>', '09:00:00')
                                            ->whereNotNull('out')
                                            ->count() /
                                            $totalAttend) *
                                        100;

                                    // Menghitung persentase present
                                    $present =
                                        ($attend
                                            ->whereBetween('date', [date('Y-m-d', strtotime($startDate)), date('Y-m-d', strtotime($endDate))])
                                            ->where('in', '<=', '09:00:00')
                                            ->whereNotNull('out')
                                            ->count() /
                                            $totalAttend) *
                                        100;

                                    $attendanceData = [];

                                    $currentDate = $startDate;

                                    while (strtotime($currentDate) <= strtotime($endDate)) {
                                        $dailyData = [
                                            'date' => $currentDate,
                                            'present' => 0,
                                            'absent' => 0,
                                            'late' => 0,
                                            'missingOut' => 0,
                                        ];

                                        $dailyAttendance = $attend->where('date', $currentDate);

                                        // Menghitung jumlah harian untuk setiap kategori
                                        $dailyData['present'] = $dailyAttendance
                                            ->where('in', '<=', '09:00:00')
                                            ->whereNotNull('out')
                                            ->count();

                                        $dailyData['absent'] = $dailyAttendance
                                            ->whereNull('in')
                                            ->whereNull('out')
                                            ->count();

                                        $dailyData['missingOut'] = $dailyAttendance
                                            ->whereNotNull('in')
                                            ->whereNull('out')
                                            ->count();

                                        $dailyData['late'] = $dailyAttendance
                                            ->where('in', '>', '09:00:00')
                                            ->whereNotNull('out')
                                            ->count();

                                        // Menambahkan data harian ke dalam array hasil
                                        $attendanceData[] = $dailyData;

                                        // Pindah ke hari berikutnya
                                        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                                    }

                                    // Memisahkan data berdasarkan kategori
                                    $presentData = array_column($attendanceData, 'present');
                                    $absentData = array_column($attendanceData, 'absent');
                                    $missingOutData = array_column($attendanceData, 'missingOut');
                                    $lateData = array_column($attendanceData, 'late');

                                    $dateRange = [];
                                    $currentDate = $startDate;

                                    while (strtotime($currentDate) <= strtotime($endDate)) {
                                        $dateRange[] = date('d/m/y', strtotime($currentDate));
                                        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                                    }
                                @endphp

                                <button id="dateRangeButton" data-dropdown-toggle="dateRangeDropdown"
                                    data-dropdown-ignore-click-outside-class="datepicker" type="button"
                                    class="ml-2 inline-flex items-center rounded-lg bg-tertiary px-5 py-2.5 font-medium text-white hover:underline">
                                    {{ date('d M Y', strtotime($startDate)) }}
                                    <p class="ms-1"> - {{ date('d M Y', strtotime($endDate)) }} </p> <svg
                                        class="ms-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>

                                <div id="dateRangeDropdown"
                                    class="w-50 lg:w-50 z-10 hidden divide-y divide-gray-600 rounded-lg bg-tertiary shadow">
                                    <div class="p-3" aria-labelledby="dateRangeButton">
                                        <form id="dateRangeForm" onsubmit="updateDateRange()">
                                            <div date-rangepicker datepicker-autohide
                                                class="flex flex-col items-center justify-center">
                                                <div class="relative">
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                                        <svg class="h-4 w-4 text-white" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                        </svg>
                                                    </div>
                                                    <input id="startDateInput" name="start" type="text"
                                                        class="block w-full rounded-lg border border-gray-600 bg-dark p-2.5 ps-10 text-sm text-white placeholder-white focus:border-white focus:ring-white"
                                                        placeholder="Start date">
                                                </div>
                                                <span class="py-1 text-white">to</span>
                                                <div class="relative">
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                                        <svg class="h-4 w-4 text-white" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                        </svg>
                                                    </div>
                                                    <input id="endDateInput" name="end" type="text"
                                                        class="block w-full rounded-lg border border-gray-600 bg-dark p-2.5 ps-10 text-sm text-white placeholder-white focus:border-white focus:ring-white"
                                                        placeholder="End date">
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-center">
                                                <button type="submit"
                                                    class="mt-3 rounded-lg bg-dark px-4 py-2 text-white hover:border hover:border-white">Apply</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function updateDateRange() {
                                    var startDateInput = document.getElementById('startDateInput').value;
                                    var endDateInput = document.getElementById('endDateInput').value;

                                    // Mengatur nilai input tersembunyi
                                    document.getElementById('startDateInputHidden').value = startDateInput;
                                    document.getElementById('endDateInputHidden').value = endDateInput;

                                    // Submit formulir
                                    document.getElementById('dateRangeForm').submit();
                                }
                            </script>

                            <div class="mb-5 flex w-full items-center justify-center">
                                <button id="dropdownDefaultButton" data-dropdown-toggle="category33"
                                    class="inline-flex w-1/2 items-center justify-between rounded-lg bg-tertiary px-5 py-2.5 text-center text-sm font-medium text-white"
                                    type="button">
                                    @if ($filterPlot == '')
                                        Plot
                                    @elseif ($filterPlot == 'pie')
                                        Pie Chart
                                    @elseif ($filterPlot == 'line')
                                        Line Chart
                                    @endif
                                    <svg class="ms-3 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="category33"
                                    class="z-10 hidden w-auto cursor-pointer rounded-lg bg-tertiary shadow">
                                    <div id="category33" class="w-full py-2 text-sm text-white"
                                        aria-labelledby="dropdownDefaseultButton">
                                        <a href="{{ request()->fullUrlWithQuery(['filter_plot' => 'pie']) }}"
                                            class="block w-full px-4 py-2 text-center hover:bg-gray-600 hover:text-white">
                                            Pie Chart
                                        </a>
                                        <a href="{{ request()->fullUrlWithQuery(['filter_plot' => 'line']) }}"
                                            class="w-ful block px-4 py-2 text-center hover:bg-gray-600 hover:text-white">
                                            Line Chart
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="flex h-full w-full items-center justify-between">
                                <div class="flex h-full w-full items-center justify-between">
                                    <canvas id="myChartAttend" class="h-full max-h-[30vh] w-full"></canvas>
                                </div>

                                {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
                                <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>

                                <script>
                                    const ctxAttend = document.getElementById('myChartAttend');

                                    new Chart(ctxAttend, {
                                        @if ($filterPlot == 'pie')
                                            type: 'pie',
                                        @else
                                            type: 'line',
                                        @endif
                                        data: {
                                            @if ($filterPlot == 'pie')
                                                labels: ['Absent', 'Lateness', 'Missing Out', 'Present'],
                                            @else
                                                labels: {!! json_encode($dateRange) !!},
                                            @endif
                                            @if ($filterPlot == 'pie')
                                                datasets: [{
                                                    label: 'Total',
                                                    data: [{{ $absent }}, {{ $lateness }}, {{ $missingOut }},
                                                        {{ $present }}
                                                    ],
                                                    backgroundColor: ["#f64f59", "#DC67CE", "#6771DC", "#6794DC"],
                                                    borderWidth: 1,
                                                    borderColor: 'black',
                                                }]
                                            @else
                                                datasets: [{
                                                        label: 'Absent',
                                                        data: {!! json_encode($absentData) !!},
                                                        backgroundColor: ['#f64f59'],
                                                        borderColor: '#f64f59',
                                                        borderWidth: 1,
                                                        order: 0
                                                    },
                                                    {
                                                        label: 'Lateness',
                                                        data: {!! json_encode($lateData) !!},
                                                        backgroundColor: ['#DC67CE'],
                                                        borderColor: '#DC67CE',
                                                        borderWidth: 1,
                                                        order: 0
                                                    },
                                                    {
                                                        label: 'Missing Out',
                                                        data: {!! json_encode($missingOutData) !!},
                                                        backgroundColor: ['#6771DC'],
                                                        borderColor: '#6771DC',
                                                        borderWidth: 1,
                                                        order: 0
                                                    },
                                                    {
                                                        label: 'Present',
                                                        data: {!! json_encode($presentData) !!},
                                                        backgroundColor: ['#6794DC'],
                                                        borderColor: '#6794DC',
                                                        borderWidth: 1,
                                                        order: 0
                                                    },
                                                ]
                                            @endif
                                        },
                                        options: {
                                            scales: {
                                                @if ($filterPlot == 'pie')
                                                    y: {
                                                        display: false
                                                    }
                                                @else
                                                    x: {
                                                        display: true,
                                                        border: {
                                                            display: true,
                                                            color: '#FFFFFF',
                                                        },
                                                        ticks: {
                                                            font: 'normal',
                                                            size: 5,
                                                            color: '#FFFFFF',
                                                        }
                                                    },
                                                    y: {
                                                        display: true,
                                                        border: {
                                                            display: true,
                                                            color: '#FFFFFF',
                                                        },
                                                        ticks: {
                                                            font: 'normal',
                                                            size: 5,
                                                            color: '#FFFFFF',
                                                        }
                                                    },
                                                @endif
                                            },
                                            plugins: {
                                                legend: {
                                                    display: true,
                                                    labels: {
                                                        boxWidth: 15,
                                                        boxHeight: 15,
                                                        color: 'white',
                                                        @if ($filterPlot == 'pie')
                                                            useBorderRadius: true,
                                                            borderRadius: 15,
                                                        @endif
                                                    },
                                                }
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    {{-- End of Attendance --}}
                </div>
                {{-- End of First Column --}}

                {{-- Second Column --}}
                <div
                    class="@if (auth()->user()->role == 1) flex-col @endif @cannot('atasan') flex-col items-center @endcannot @can('atasan') flex-row @endcan @if (auth()->user()->role == 3 || auth()->user()->role == 2) w-4/12 flex-col mr-5 @else w-1/2 @endif flex h-full">
                    {{-- Employee Rating --}}
                    @if ($userrole == 0)
                        <div class="mb-5 h-auto w-full rounded-lg bg-secondary px-4 py-6 shadow md:p-6">
                            <div class="mb-3 flex w-full justify-between">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center">
                                        <h5 class="mb-2 pe-1 text-xl font-bold leading-none text-white">Your
                                            employee's rating
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <p
                                    class="@if (number_format($ratings, 1) > 7.5) bg-green-200 text-green-800
                                    @elseif (number_format($ratings, 1) > 5) bg-blue-200 text-blue-800
                                    @elseif (number_format($ratings, 1) > 3.5) bg-yellow-200 text-yellow-800
                                    @else bg-red-200 text-red-800 @endif inline-flex items-center rounded p-1.5 text-sm font-semibold">
                                    {{ number_format($ratings, 1) }}
                                </p>

                                <p class="ms-2 font-medium text-gray-900 dark:text-white">
                                    @if (number_format($ratings, 1) > 7.5)
                                        Excellent
                                    @elseif (number_format($ratings, 1) > 5)
                                        Great
                                    @elseif (number_format($ratings, 1) > 3.5)
                                        Average
                                    @else
                                        Poor
                                    @endif
                                </p>

                                <a href="/task?type_filter=finished"
                                    class="ms-auto text-sm font-medium text-white hover:underline">See
                                    all
                                    rating</a>
                            </div>
                        </div>
                    @endif
                    {{-- End of Employee Rating --}}

                    {{-- Employee Detail --}}
                    <div class="@if ($userrole == 3 || $userrole == 2) mb-5 min-w-[5vw] max-w-[40vw] @endif h-5/12 w-full">
                        @php
                            $totalEmployee = $list->count();
                            $totalPayroll = $list2->sum('salary_amount');
                        @endphp

                        <div class="h-full w-full rounded-lg bg-secondary p-4 shadow md:p-6">
                            @if (!auth()->user()->role == 0)
                                <div class="h-full rounded-xl bg-tertiary px-5 py-5">
                                    <div class="@if ($userrole == 3 || $userrole == 2) mb-5 @endif flex h-auto w-auto">
                                        <dl>
                                            <div class="flex h-full flex-row items-center">
                                                <div
                                                    class="me-3 flex h-16 w-16 items-center justify-center rounded-lg bg-gray-700">
                                                    <svg class="h-10 w-10 text-gray-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        viewBox="0 0 20 19">
                                                        <path
                                                            d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                                        <path
                                                            d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                                                    </svg>
                                                    </dd>
                                                </div>
                                                <div class="">
                                                    <dt class="pb-1 text-xl font-bold text-white">{{ $totalEmployee }}
                                                    </dt>
                                                    <dd class="text-lg font-medium leading-none text-gray-300">
                                                        Employee works here
                                                </div>
                                            </div>
                                        </dl>
                                    </div>
                                    @if ($userrole !== 0 && $userrole !== 1)
                                        {{-- chart --}}
                                        @php
                                            $business = $list->where('position', 0)->count();
                                            $analyst = $list->where('position', 1)->count();
                                            $scientist = $list->where('position', 2)->count();
                                            $teller = $list->where('position', 3)->count();
                                            $auditor = $list->where('position', 4)->count();
                                            $staff = $list->where('position', 5)->count();
                                            $sales = $list->where('position', 6)->count();
                                            $akuntan = $list->where('position', 7)->count();
                                            $business = number_format(($business / $totalEmployee) * 100, 2);
                                            $analyst = number_format(($analyst / $totalEmployee) * 100, 2);
                                            $scientist = number_format(($scientist / $totalEmployee) * 100, 2);
                                            $teller = number_format(($teller / $totalEmployee) * 100, 2);
                                            $auditor = number_format(($auditor / $totalEmployee) * 100, 2);
                                            $staff = number_format(($staff / $totalEmployee) * 100, 2);
                                            $sales = number_format(($sales / $totalEmployee) * 100, 2);
                                            $akuntan = number_format(($akuntan / $totalEmployee) * 100, 2);

                                            $poss = [
                                                0 => 'Business Analyst',
                                                1 => 'Data Analyst',
                                                2 => 'Data Scientist',
                                                3 => 'Teller',
                                                4 => 'Auditor',
                                                5 => 'Staff',
                                                6 => 'Sales',
                                                7 => 'Akuntan',
                                            ];

                                            $Posss = [$business, $analyst, $scientist, $teller, $auditor, $staff, $sales, $akuntan];

                                            # Sorting Posss
                                            arsort($Posss);

                                            # Buatkan sort Position berdasarkan Sort dari $Posss
                                            // $sortedListPosition = '';

                                            // foreach ($Posss as $positionId => $count) {
                                            //     $sortedListPosition .= '"' . $poss[$positionId] . '",';
                                            // }

                                            // // Menghapus koma di akhir
                                            // $sortedListPosition = rtrim($sortedListPosition, ',');
                                            $sortedListPosition = [];

                                            foreach ($Posss as $positionId => $count) {
                                                $sortedListPosition[] = $poss[$positionId];
                                            }

                                            $sortedPosss = array_values($Posss);
                                        @endphp

                                        <div class="flex h-full w-auto items-center justify-center">
                                            <div class="chart flex h-full max-h-[40vh] w-full items-center justify-center">
                                                <div class="h-full max-h-[40vh] w-full rounded-xl">
                                                    <canvas id="myChart"
                                                        class="h-full max-h-[35vh] w-full text-white"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
                                        <script>
                                            // setup 
                                            const data = {
                                                labels: {!! json_encode($sortedListPosition) !!},
                                                datasets: [{
                                                    label: 'Employees',
                                                    data: [{{ str_replace(['[', ']', '"', ' '], '', json_encode($sortedPosss)) }}],
                                                    backgroundColor: ["#67B7DC", "#6794DC", "#6771DC", "#8067DC", "#A367DC", "#C767DC", "#DC67CE",
                                                        "#DC67AB"
                                                    ],
                                                    borderColor: ["#67B7DC", "#6794DC", "#6771DC", "#8067DC", "#A367DC", "#C767DC", "#DC67CE",
                                                        "#DC67AB"
                                                    ],
                                                    borderWidth: 1,
                                                    borderRadius: 5,
                                                    circumference: 180,
                                                    rotation: 270
                                                }]
                                            };

                                            const doughnutLabel = {
                                                id: 'doughnutLabel',
                                                afterDraw(chart, args, options) {
                                                    const {
                                                        ctx,
                                                        chartArea: {
                                                            left,
                                                            right,
                                                            top,
                                                            bottom,
                                                            width,
                                                            height
                                                        }
                                                    } = chart;

                                                    ctx.save();

                                                    if (chart._active.length > 0) {
                                                        const textLabel = chart.config.data.labels[chart._active[0].index];
                                                        const numberLabel = chart.config.data.datasets[chart._active[0].datasetIndex].data[chart._active[0]
                                                            .index];
                                                        const color = chart.config.data.datasets[chart._active[0].datasetIndex].borderColor[chart._active[0]
                                                            .index];
                                                        const xCoor = chart.getDatasetMeta(0).data[0].x;
                                                        const yCoor = chart.getDatasetMeta(0).data[0].y;

                                                        ctx.font = '15px sans-serif';
                                                        ctx.fillStyle = '#FFFFFF';
                                                        ctx.textAlign = 'center';
                                                        ctx.textBaseline = 'middle';
                                                        ctx.fillText(`${textLabel}: ${numberLabel} %`, xCoor, yCoor);
                                                    }

                                                    ctx.restore();
                                                }
                                            };

                                            // config 
                                            const config = {
                                                type: 'doughnut',
                                                data,
                                                options: {
                                                    plugins: {
                                                        layout: {
                                                            padding: {
                                                                bottom: 0,
                                                            }
                                                        },
                                                        legend: {
                                                            position: 'bottom',
                                                            labels: {
                                                                boxHeight: 25,
                                                                boxWidth: 25,
                                                                useBorderRadius: true,
                                                                borderRadius: 5,
                                                                padding: 20,
                                                                color: "#FFFFFF",
                                                            }
                                                        },
                                                    }
                                                },
                                                plugins: [doughnutLabel],
                                            };



                                            // render init block
                                            const myChart = new Chart(
                                                document.getElementById('myChart'),
                                                config
                                            );

                                            // Instantly assign Chart.js version
                                            const chartVersion = document.getElementById('chartVersion');
                                            chartVersion.innerText = Chart.version;
                                        </script>
                                    @endif
                                </div>
                            @else
                                <div class="w-full py-2">
                                    <dl>
                                        <dt class="mb-5 pb-1 text-xl font-medium leading-none text-white">Salary Permonth
                                        </dt>
                                        <dd class="text-xl font-bold leading-none text-green-500 dark:text-green-400">
                                            {{ 'Rp.' . number_format($totalPayroll, 0, ',', '.') }}
                                        </dd>
                                    </dl>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- End of Employee Detail --}}

                    @if ($userrole !== 0)
                        {{-- Salary --}}
                        <div class="h-auto max-h-[80vh] w-full rounded-lg bg-secondary p-4 shadow md:p-6">
                            <div class="grid h-auto w-full grid-cols-2 py-3">
                                <dl>
                                    <dt class="pb-1 text-xl font-bold text-white">Total Employee
                                        Salary</dt>
                                    <dd class="text-xl font-bold leading-none text-green-400">
                                        {{ 'Rp.' . number_format($totalPayroll, 0, ',', '.') }} </dd>
                                </dl>
                            </div>
                            @if ($userrole !== 1)
                                @php
                                    // Employee Lists
                                    $businessEmployee = $list2->where('position', 0);
                                    $dataAnalystEmployee = $list2->where('position', 1);
                                    $dataScientistEmployee = $list2->where('position', 2);
                                    $tellerEmployee = $list2->where('position', 3);
                                    $auditorEmployee = $list2->where('position', 4);
                                    $staffEmployee = $list2->where('position', 5);
                                    $salesEmployee = $list2->where('position', 6);
                                    $akuntanEmployee = $list2->where('position', 7);
                                    // Employee Lists Total Salary
                                    $businessEmployeeTotalSalary = $businessEmployee->sum('salary_amount');
                                    $dataAnalystEmployeeTotalSalary = $dataAnalystEmployee->sum('salary_amount');
                                    $dataScientistEmployeeTotalSalary = $dataScientistEmployee->sum('salary_amount');
                                    $tellerEmployeeTotalSalary = $tellerEmployee->sum('salary_amount');
                                    $auditorEmployeeTotalSalary = $auditorEmployee->sum('salary_amount');
                                    $staffEmployeeTotalSalary = $staffEmployee->sum('salary_amount');
                                    $salesEmployeeTotalSalary = $salesEmployee->sum('salary_amount');
                                    $akuntanEmployeeTotalSalary = $akuntanEmployee->sum('salary_amount');
                                @endphp
                                <div class="h-full w-auto" id="bar-chart"></div>
                                <script>
                                    // ApexCharts options and config
                                    window.addEventListener("load", function() {
                                        var options = {
                                            series: [{
                                                name: "Salary",
                                                color: "#31C48D",
                                                data: [{{ $businessEmployeeTotalSalary }},
                                                    {{ $dataAnalystEmployeeTotalSalary }},
                                                    {{ $dataScientistEmployeeTotalSalary }},
                                                    {{ $tellerEmployeeTotalSalary }},
                                                    {{ $auditorEmployeeTotalSalary }}, {{ $staffEmployeeTotalSalary }},
                                                    {{ $salesEmployeeTotalSalary }},
                                                    {{ $akuntanEmployeeTotalSalary }}
                                                ],
                                            }, ],
                                            chart: {
                                                sparkline: {
                                                    enabled: false,
                                                },
                                                type: "bar",
                                                width: "100%",
                                                maxWidth: "50vw",
                                                height: '400px',
                                                toolbar: {
                                                    show: true,
                                                }
                                            },
                                            fill: {
                                                opacity: 1,
                                            },
                                            plotOptions: {
                                                bar: {
                                                    horizontal: true,
                                                    columnWidth: "100%",
                                                    borderRadiusApplication: "end",
                                                    borderRadius: 6,
                                                    dataLabels: {
                                                        position: "top",
                                                    },
                                                },
                                            },
                                            legend: {
                                                show: true,
                                                position: "bottom",
                                            },
                                            dataLabels: {
                                                enabled: false,
                                            },
                                            tooltip: {
                                                shared: true,
                                                intersect: false,
                                                formatter: function(value) {
                                                    return "Rp." + value.toLocaleString('id-ID');
                                                }
                                            },
                                            xaxis: {
                                                labels: {
                                                    show: true,
                                                    style: {
                                                        fontFamily: "Inter, sans-serif",
                                                        cssClass: 'text-xs font-normal fill-white'
                                                    },
                                                    formatter: function(value) {
                                                        return "Rp." + (value / 1000000) + " Juta"
                                                    }
                                                },
                                                categories: ['Business Analyst', 'Data Analyst', 'Data Scientist', 'Teller', 'Auditor',
                                                    'Staff', 'Sales', 'Akuntan'
                                                ],
                                                axisTicks: {
                                                    show: false,
                                                },
                                                axisBorder: {
                                                    show: false,
                                                },
                                            },
                                            yaxis: {
                                                labels: {
                                                    show: true,
                                                    style: {
                                                        fontFamily: "Inter, sans-serif",
                                                        cssClass: 'text-xs font-normal fill-white'
                                                    }
                                                }
                                            },
                                            grid: {
                                                show: true,
                                                strokeDashArray: 4,
                                                padding: {
                                                    left: 2,
                                                    right: 2,
                                                    top: -20
                                                },
                                            },
                                            fill: {
                                                opacity: 1,
                                            }
                                        }

                                        if (document.getElementById("bar-chart") && typeof ApexCharts !== 'undefined') {
                                            const chart = new ApexCharts(document.getElementById("bar-chart"), options);
                                            chart.render();
                                        }
                                    });
                                </script>
                            @endif
                        </div>
                        {{-- End of Salary --}}
                        <a href="/userlist"
                            class="@if (auth()->user()->role == 1) mb-5 @endif h-2/12 mt-5 grid grid-cols-1 items-center justify-between rounded-lg bg-secondary p-3 text-white shadow hover:bg-dark hover:text-white">
                            <div class="flex items-center justify-end">
                                <div class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-semibold uppercase">
                                    See Employee List
                                    <svg class="ms-1.5 h-2.5 w-2.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endif
                    {{-- End of Detail --}}

                    {{-- Work Hours --}}
                    <div class="mt-5 h-full w-full rounded-lg bg-secondary p-4 shadow md:p-6">
                        <div class="mb-3 flex h-full w-full flex-col items-center justify-between">
                            <div class="flex h-auto w-full items-center justify-center text-center">
                                <h5 class="mb-5 pe-1 text-xl font-bold leading-none text-white">Working Hour Information
                                </h5>
                            </div>
                            {{-- Dropdown Tanggal --}}
                            <button id="dateRangeButton2" data-dropdown-toggle="dateRangeDropdown2"
                                data-dropdown-ignore-click-outside-class="datepicker" type="button"
                                class="ml-2 inline-flex items-center rounded-lg bg-tertiary px-5 py-2.5 font-medium text-white hover:underline">
                                {{ date('d M Y', strtotime($startDate2)) }}
                                <p class="ms-1"> - {{ date('d M Y', strtotime($endDate2)) }} </p> <svg
                                    class="ms-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>

                            <div id="dateRangeDropdown2"
                                class="w-50 lg:w-50 z-10 hidden divide-y divide-gray-600 rounded-lg bg-tertiary shadow">
                                <div class="p-3" aria-labelledby="dateRangeButton2">
                                    <form id="dateRangeForm2" onsubmit="updateDateRange()">
                                        <div date-rangepicker datepicker-autohide
                                            class="flex flex-col items-center justify-center">
                                            <div class="relative">
                                                <div
                                                    class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                                    <svg class="h-4 w-4 text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                    </svg>
                                                </div>
                                                <input id="startDateInp" name="start2" type="text"
                                                    class="block w-full rounded-lg border border-gray-600 bg-dark p-2.5 ps-10 text-sm text-white placeholder-white focus:border-white focus:ring-white"
                                                    placeholder="Start date">
                                            </div>
                                            <span class="py-1 text-white">to</span>
                                            <div class="relative">
                                                <div
                                                    class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                                    <svg class="h-4 w-4 text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                    </svg>
                                                </div>
                                                <input id="endDateInp" name="end2" type="text"
                                                    class="block w-full rounded-lg border border-gray-600 bg-dark p-2.5 ps-10 text-sm text-white placeholder-white focus:border-white focus:ring-white"
                                                    placeholder="End date">
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <button type="submit"
                                                class="mt-3 rounded-lg bg-dark px-4 py-2 text-white hover:border hover:border-white">Apply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @php
                                // Mendapatkan parameter yang sudah ada dari URL
                                $existingParams = request()->getQueryString();
                            @endphp

                            <script>
                                function updateDateRange() {
                                    var startDateInp = document.getElementById('startDateInp').value;
                                    var endDateInp = document.getElementById('endDateInp').value;

                                    // Mendapatkan parameter yang sudah ada dari URL
                                    var existingParams = new URLSearchParams(window.location.search);

                                    // Menambahkan atau memperbarui nilai parameter start2 dan end2
                                    existingParams.set('start2', startDateInp);
                                    existingParams.set('end2', endDateInp);

                                    // Menambahkan parameter yang sudah ada ke dalam formulir
                                    document.getElementById('dateRangeForm2').action = window.location.pathname + '?' + existingParams.toString();

                                    // Submit formulir
                                    document.getElementById('dateRangeForm2').submit();
                                }
                            </script>
                            {{-- End of Dropdown Tanggal --}}

                            {{-- Dropdown Employee --}}
                            {{-- End of Dropdown Employee --}}
                        </div>
                    </div>
                    {{-- End of Work Hours --}}

                    {{-- Benefit, Payroll, and Off days Request Info --}}
                    @if (auth()->user()->role == 0 || auth()->user()->role == 1)
                        <div
                            class="@cannot('atasan') mt-5 @endcannot @if ($userrole == 3) w-auto max-w-[20vw] @elseif($userrole == 2) w-2/5 @else w-full @endif h-auto">
                            <div class="w-auto rounded-lg bg-secondary p-4 shadow md:p-6">
                                <div class="w-auto">
                                    <div class="w-auto">
                                        <dl class="mb-5 flex items-center justify-between">
                                            <div class="flex flex-row items-center">
                                                <dd class="text-center text-xl font-bold leading-none text-white">
                                                    Requested Infomation
                                            </div>
                                        </dl>
                                        <div
                                            class="mb-5 w-full rounded-lg bg-tertiary px-3 py-3 text-white hover:bg-slate-800">
                                            <a href="/PayrollandBenefit?payrollFilter=application">
                                                <div class="mb-1 flex w-full items-center justify-between">
                                                    <span class="text-base font-medium">Payroll</span>
                                                    <span class="flex w-1/2 justify-end text-xs font-medium">
                                                        @if ($payroll->first()->status === 0)
                                                            Accepted
                                                        @elseif($payroll->first()->status === 1)
                                                            Pending
                                                        @elseif($payroll->first()->status === 2)
                                                            Rejected
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="h-2.5 w-full rounded-full bg-secondary">
                                                    <div class="@if ($payroll->first()->status === 2) poorColor @else gradcolor @endif h-2.5 rounded-full"
                                                        style="@if ($payroll->first()->status === 0) width: 100% @elseif($payroll->first()->status === 1) width: 20% @elseif($payroll->first()->status === 2) width: 100% @endif">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="mb-5 rounded-lg bg-tertiary px-5 py-3 text-white hover:bg-slate-800">
                                            <span class="w-32 text-base font-medium">
                                                Benefit</span>
                                            @foreach ($benefit as $benefit)
                                                <a href="/PayrollandBenefit?benefitsFilter=application">
                                                    <div class="mb-1 mt-2 flex flex-row items-center justify-between">
                                                        <span class="w-32 text-sm font-medium">
                                                            {{ $benefit->benefit_name }}</span>
                                                        <span class="flex w-1/2 justify-end text-xs font-medium">
                                                            @if ($benefit->status == 0)
                                                                No Request
                                                            @elseif($benefit->status == 1)
                                                                Pending
                                                            @elseif($benefit->status == 2)
                                                                Accepted
                                                            @elseif($benefit->status == 3)
                                                                Rejected
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="h-2.5 w-full rounded-full bg-secondary">
                                                        <div class="@if ($benefit->status == 3) poorColor @else gradcolor @endif h-2.5 rounded-full"
                                                            style="@if ($benefit->status == 0) width: 0% @elseif ($benefit->status == 1) width: 20% @elseif($benefit->status == 2) width: 100% @elseif($benefit->status = 3) width: 100% @endif">
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                        <div class="rounded-lg bg-tertiary px-5 py-3 text-white hover:bg-slate-800">
                                            <a href="/offdays">
                                                <div class="mb-1 flex items-center justify-between">
                                                    <span class="text-base font-medium">Off Days</span>
                                                    <span class="flex w-1/2 justify-end text-xs font-medium">
                                                        @if ($offdays->first()->status == 0)
                                                            Pending
                                                        @elseif($offdays->first()->status == 1)
                                                            Accepted
                                                        @elseif($offdays->first()->status == 2)
                                                            Rejected
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="h-2.5 w-full rounded-full bg-secondary">
                                                    <div class="@if ($offdays->first()->status == 2) poorColor @else gradcolor @endif h-2.5 rounded-full"
                                                        style="@if ($offdays->first()->status == 0) width: 20% @elseif($offdays->first()->status == 1) width: 100% @elseif($offdays->first()->status == 2) width: 100% @endif">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- End of Benefit, Payroll, and Off days Request Info --}}
                </div>
                {{-- End of Second Column --}}

                {{-- Third Column --}}
                {{-- Benefit, Payroll, and Off days Request Info --}}
                @if (auth()->user()->role == 2)
                    <div class="h-auto w-3/12">
                        <div class="w-auto rounded-lg bg-secondary p-4 shadow md:p-6">
                            <div class="w-auto">
                                <div class="w-auto">
                                    <dl class="mb-5 flex items-center justify-between">
                                        <div class="flex flex-row items-center">
                                            <dd class="text-center text-xl font-bold leading-none text-white">
                                                Requested Infomation
                                        </div>
                                    </dl>
                                    <div
                                        class="mb-5 w-full rounded-lg bg-tertiary px-3 py-3 text-white hover:bg-slate-800">
                                        <a href="/PayrollandBenefit?payrollFilter=application">
                                            <div class="mb-1 flex w-full items-center justify-between">
                                                <span class="text-base font-medium">Payroll</span>
                                                <span class="flex w-1/2 justify-end text-xs font-medium">
                                                    @if ($payroll->first()->status === 0)
                                                        Accepted
                                                    @elseif($payroll->first()->status === 1)
                                                        Pending
                                                    @elseif($payroll->first()->status === 2)
                                                        Rejected
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="h-2.5 w-full rounded-full bg-secondary">
                                                <div class="@if ($payroll->first()->status === 2) poorColor @else gradcolor @endif h-2.5 rounded-full"
                                                    style="@if ($payroll->first()->status === 0) width: 100% @elseif($payroll->first()->status === 1) width: 20% @elseif($payroll->first()->status === 2) width: 100% @endif">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="mb-5 rounded-lg bg-tertiary px-5 py-3 text-white hover:bg-slate-800">
                                        <span class="w-32 text-base font-medium">
                                            Benefit</span>
                                        @foreach ($benefit as $benefit)
                                            <a href="/PayrollandBenefit?benefitsFilter=application">
                                                <div class="mb-1 mt-2 flex flex-row items-center justify-between">
                                                    <span class="w-32 text-sm font-medium">
                                                        {{ $benefit->benefit_name }}</span>
                                                    <span class="flex w-1/2 justify-end text-xs font-medium">
                                                        @if ($benefit->status == 0)
                                                            No Request
                                                        @elseif($benefit->status == 1)
                                                            Pending
                                                        @elseif($benefit->status == 2)
                                                            Accepted
                                                        @elseif($benefit->status == 3)
                                                            Rejected
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="h-2.5 w-full rounded-full bg-secondary">
                                                    <div class="@if ($benefit->status == 3) poorColor @else gradcolor @endif h-2.5 rounded-full"
                                                        style="@if ($benefit->status == 0) width: 0% @elseif ($benefit->status == 1) width: 20% @elseif($benefit->status == 2) width: 100% @elseif($benefit->status = 3) width: 100% @endif">
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="rounded-lg bg-tertiary px-5 py-3 text-white hover:bg-slate-800">
                                        <a href="/offdays">
                                            <div class="mb-1 flex items-center justify-between">
                                                <span class="text-base font-medium">Off Days</span>
                                                <span class="flex w-1/2 justify-end text-xs font-medium">
                                                    @if ($offdays->first()->status == 0)
                                                        Pending
                                                    @elseif($offdays->first()->status == 1)
                                                        Accepted
                                                    @elseif($offdays->first()->status == 2)
                                                        Rejected
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="h-2.5 w-full rounded-full bg-secondary">
                                                <div class="@if ($offdays->first()->status == 2) poorColor @else gradcolor @endif h-2.5 rounded-full"
                                                    style="@if ($offdays->first()->status == 0) width: 20% @elseif($offdays->first()->status == 1) width: 100% @elseif($offdays->first()->status == 2) width: 100% @endif">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- End of Benefit, Payroll, and Off days Request Info --}}
                @if ($userrole == 3)
                    <div class="flex h-full w-3/12 flex-col items-center justify-between">
                        {{-- Benefit, Payroll, and Off days Request Info --}}
                        <div class="mb-2 h-1/2 w-full">
                            <div class="w-auto rounded-lg bg-secondary p-4 shadow md:p-6">
                                <div class="w-full">
                                    <div class="mb-5 w-full">
                                        @php
                                            $benefitstatus = $list->where('benefit_status', '=', 1);
                                            $offdaystatus = $list->where('offday_status', 0)->filter(function ($item) {
                                                return $item->offday_status !== null;
                                            });
                                            $payrollstatus = $list->where('payroll_status', 1);

                                            // All
                                            $benefitCount = $benefitstatus->count();
                                            $offdayCount = $offdaystatus->count();
                                            $payrollCount = $payrollstatus->count();

                                            $positions = [
                                                0 => 'Business',
                                                1 => 'Analyst',
                                                2 => 'Scientist',
                                                3 => 'Teller',
                                                4 => 'Auditor',
                                                5 => 'Staff',
                                                6 => 'Sales',
                                                7 => 'Akuntan',
                                            ];

                                            $result = [];

                                            foreach ($positions as $positionId => $positionName) {
                                                $result["benefit{$positionName}"] = $benefitstatus->where('position', $positionId)->count();
                                                $result["offday{$positionName}"] = $offdaystatus->where('position', $positionId)->count();
                                                $result["payroll{$positionName}"] = $payrollstatus->where('position', $positionId)->count();
                                            }
                                        @endphp

                                        <dl class="mb-5 flex w-full items-center justify-between">
                                            <div class="flex w-full flex-row items-center">
                                                <dd class="text-xl font-bold leading-none text-white">
                                                    Requested Info
                                            </div>
                                            <div class="flex justify-start rounded-lg bg-tertiary p-1 pl-2">
                                                <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown"
                                                    data-dropdown-placement="bottom"
                                                    class="@if ($requestFilter == 'request' || $requestFilter == 'position') text-white @else text-gray-400 @endif inline-flex items-center text-center text-xs font-medium hover:text-white"
                                                    type="button">
                                                    @if ($requestFilter == 'request')
                                                        All Requested
                                                    @elseif ($requestFilter == 'position')
                                                        By Position
                                                    @else
                                                        Category
                                                    @endif
                                                    <svg class="m-2.5 ms-1.5 w-2.5" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 10 6">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                                    </svg>
                                                </button>
                                                <!-- Dropdown menu -->
                                                <div id="lastDaysdropdown"
                                                    class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-tertiary shadow">
                                                    <ul class="py-2 text-sm text-gray-200"
                                                        aria-labelledby="dropdownDefaultButton">
                                                        <li>
                                                            <a href="{{ request()->fullUrlWithQuery(['request_filter' => 'request']) }}"
                                                                class="block px-4 py-2 hover:bg-dark hover:text-white">All
                                                                Requested</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ request()->fullUrlWithQuery(['request_filter' => 'position']) }}"
                                                                class="block px-4 py-2 hover:bg-dark hover:text-white">
                                                                Position</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </dl>
                                        <div class="w-full rounded-lg bg-tertiary p-3">
                                            <div class="mb-2 grid grid-cols-3 gap-3">
                                                <a href="/PayrollandBenefit" class="rounded-lg bg-dark hover:bg-gray-800">
                                                    <dl class="flex h-[78px] flex-col items-center justify-center">
                                                        <dt
                                                            class="mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-medium text-red-800">
                                                            {{ $payrollCount }}</dt>
                                                        <dd class="text-center text-sm font-medium text-white">
                                                            Payroll
                                                        </dd>
                                                    </dl>
                                                </a>
                                                <a href="/PayrollandBenefit?type_filter=benefit"
                                                    class="rounded-lg bg-dark hover:bg-gray-800">
                                                    <dl class="flex h-[78px] flex-col items-center justify-center">
                                                        <dt
                                                            class="mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-medium text-red-800">
                                                            {{ $benefitCount }}</dt>
                                                        <dd class="text-center text-sm font-medium text-white">
                                                            Benefit
                                                        </dd>
                                                    </dl>
                                                </a>
                                                <a href="/offdays" class="rounded-lg bg-dark hover:bg-gray-800">
                                                    <dl class="flex h-[78px] flex-col items-center justify-center">
                                                        <dt
                                                            class="mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-medium text-red-800">
                                                            {{ $offdayCount }}</dt>
                                                        <dd class="text-center text-sm font-medium text-white">
                                                            Off Days
                                                        </dd>
                                                    </dl>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- chart --}}
                                    @if (!$requestFilter == 'position')
                                        <div class="h-full w-full">
                                            <canvas id="myChart3" class="h-full min-h-[10vh] w-auto"></canvas>
                                        </div>
                                    @else
                                        <div id="bar-chart2"></div>
                                    @endif
                                    @if (!$requestFilter == 'position')
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                        <script>
                                            const ctx3 = document.getElementById('myChart3');

                                            new Chart(ctx3, {
                                                type: 'bar',
                                                data: {
                                                    labels: ['Payroll', 'Benefit', 'Offdays'],
                                                    datasets: [{
                                                        label: 'Request',
                                                        data: [{{ $payrollCount }}, {{ $benefitCount }},
                                                            {{ $offdayCount }}
                                                        ],
                                                        backgroundColor: [
                                                            // '#6794DC ',
                                                            // '#6771DC ',
                                                            '#8067DC ',
                                                            '#A367DC',
                                                            '#C767DC'
                                                        ],
                                                        borderColor: '#00000',
                                                        borderWidth: 1,
                                                        borderRadius: {
                                                            topLeft: 10,
                                                            topRight: 10,
                                                        }
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        x: {
                                                            border: {
                                                                display: true,
                                                                color: '#FFFFFF',
                                                            },
                                                            grid: {
                                                                display: false,
                                                            },
                                                            ticks: {
                                                                font: 'normal',
                                                                size: 5,
                                                                color: '#FFFFFF',
                                                            }
                                                        },
                                                        y: {
                                                            border: {
                                                                display: true,
                                                                color: '#FFFFFF',
                                                            },
                                                            grid: {
                                                                display: true,
                                                            },
                                                            ticks: {
                                                                font: 'normal',
                                                                size: 5,
                                                                color: '#FFFFFF',
                                                            }
                                                        }
                                                    },
                                                    layout: {
                                                        autoPadding: false,
                                                    },
                                                    legend: {
                                                        display: false,
                                                    },
                                                    plugins: {
                                                        legend: {
                                                            display: false,
                                                        }
                                                    }
                                                }
                                            });
                                        </script>
                                    @else
                                        <script>
                                            window.addEventListener("load", function() {
                                                var options = {
                                                    series: [{
                                                        name: "Payroll Increase Request",
                                                        color: "#442A82",
                                                        data: [{{ $result['payrollBusiness'] }}, {{ $result['payrollAnalyst'] }},
                                                            {{ $result['payrollScientist'] }}, {{ $result['payrollTeller'] }},
                                                            {{ $result['payrollAuditor'] }}, {{ $result['payrollStaff'] }},
                                                            {{ $result['payrollSales'] }}, {{ $result['payrollAkuntan'] }}
                                                        ],
                                                    }, {
                                                        name: "Benefit Application Request",
                                                        color: "#8B538A",
                                                        data: [{{ $result['benefitBusiness'] }}, {{ $result['benefitAnalyst'] }},
                                                            {{ $result['benefitScientist'] }}, {{ $result['benefitTeller'] }},
                                                            {{ $result['benefitAuditor'] }}, {{ $result['benefitStaff'] }},
                                                            {{ $result['benefitSales'] }}, {{ $result['benefitAkuntan'] }}
                                                        ],
                                                    }, {
                                                        name: "Off Days Request",
                                                        color: "#EB8C96",
                                                        data: [{{ $result['offdayBusiness'] }}, {{ $result['offdayAnalyst'] }},
                                                            {{ $result['offdayScientist'] }}, {{ $result['offdayTeller'] }},
                                                            {{ $result['offdayAuditor'] }}, {{ $result['offdayStaff'] }},
                                                            {{ $result['offdaySales'] }}, {{ $result['offdayAkuntan'] }}
                                                        ],
                                                    }],
                                                    chart: {
                                                        sparkline: {
                                                            enabled: false,
                                                        },
                                                        type: "bar",
                                                        width: "100%",
                                                        height: '700px',
                                                        toolbar: {
                                                            show: false,
                                                        }
                                                    },
                                                    fill: {
                                                        opacity: 1,
                                                    },
                                                    plotOptions: {
                                                        bar: {
                                                            horizontal: true,
                                                            columnWidth: "70%",
                                                            borderRadiusApplication: "end",
                                                            borderRadius: 6,
                                                            dataLabels: {
                                                                position: "top",
                                                            },
                                                        },
                                                    },
                                                    legend: {
                                                        show: true,
                                                        position: "bottom",
                                                    },
                                                    dataLabels: {
                                                        enabled: false,
                                                    },
                                                    tooltip: {
                                                        shared: true,
                                                        intersect: false,
                                                        formatter: function(value) {
                                                            return value
                                                        }
                                                    },
                                                    xaxis: {
                                                        labels: {
                                                            show: true,
                                                            style: {
                                                                fontFamily: "Inter, sans-serif",
                                                                cssClass: 'text-xs font-normal fill-white'
                                                            },
                                                            formatter: function(value) {
                                                                return value
                                                            }
                                                        },
                                                        categories: ["Business Analyst", "Data Analyst", "Data Scientist", "Teller", "Auditor",
                                                            "Staff", "Sales", "Akuntan"
                                                        ],
                                                        axisTicks: {
                                                            show: false,
                                                        },
                                                        axisBorder: {
                                                            show: false,
                                                        },
                                                    },
                                                    yaxis: {
                                                        labels: {
                                                            show: true,
                                                            style: {
                                                                fontFamily: "Inter, sans-serif",
                                                                cssClass: 'text-xs font-normal fill-white'
                                                            }
                                                        }
                                                    },
                                                    grid: {
                                                        show: true,
                                                        strokeDashArray: 4,
                                                        padding: {
                                                            left: 2,
                                                            right: 2,
                                                            top: -20
                                                        },
                                                    },
                                                    fill: {
                                                        opacity: 1,
                                                    }
                                                }
                                                if (document.getElementById("bar-chart2") && typeof ApexCharts !== 'undefined') {
                                                    const chart = new ApexCharts(document.getElementById("bar-chart2"), options);
                                                    chart.render();
                                                }
                                            });
                                        </script>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- End of Benefit, Payroll, and Off days Request Info --}}

                        {{-- Facility --}}
                        <div class="h-1/2 w-full">
                            <div class="mt-2 h-full w-full rounded-lg bg-secondary p-4 shadow md:p-6">
                                <dl class="mb-5 flex w-full items-center justify-between">
                                    <div class="flex w-full flex-row items-center">
                                        <dd class="w-full text-center text-xl font-bold leading-none text-white">
                                            Facility Information
                                    </div>
                                </dl>
                                <div class="mb-5 flex w-full items-center justify-center">
                                    <!-- Dropdown menu -->
                                    <button id="dropdownDefaultButton" data-dropdown-toggle="category22"
                                        class="inline-flex w-72 items-center justify-between rounded-lg bg-tertiary px-5 py-2.5 text-center text-sm font-medium text-white"
                                        type="button">
                                        @if ($categoryFilter == '')
                                            Category
                                        @elseif ($categoryFilter == 'all_remains' || $categoryFilter == 'position')
                                            All Remaining
                                        @elseif ($categoryFilter == 'brio')
                                            Honda Brio
                                        @elseif ($categoryFilter == 'alphard')
                                            Toyota Alphard
                                        @elseif ($categoryFilter == 'inova')
                                            Toyota Inova
                                        @elseif ($categoryFilter == 'pcx')
                                            Honda PCX
                                        @elseif ($categoryFilter == 'vario')
                                            Honda Vario
                                        @elseif ($categoryFilter == 'business_analyst')
                                            Business Analyst
                                        @elseif ($categoryFilter == 'data_scientist')
                                            Data Scientist
                                        @elseif ($categoryFilter == 'data_analyst')
                                            Data Analyst
                                        @elseif ($categoryFilter == 'teller')
                                            Teller
                                        @elseif ($categoryFilter == 'auditor')
                                            Auditor
                                        @elseif ($categoryFilter == 'sales')
                                            Sales
                                        @elseif ($categoryFilter == 'staff')
                                            Staff
                                        @elseif ($categoryFilter == 'akuntan')
                                            Akuntan
                                        @endif
                                        <svg class="ms-3 h-2.5 w-2.5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div id="category22"
                                        class="z-10 hidden w-72 cursor-pointer rounded-lg bg-tertiary shadow">
                                        <div id="category2" class="w-full py-2 text-sm text-white"
                                            aria-labelledby="dropdownDefaseultButton">
                                            <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'all_remains']) }}"
                                                class="block w-full border-b border-white px-4 py-2 text-center hover:bg-gray-600 hover:text-white">
                                                All Remaining
                                            </a>
                                            <p
                                                class="block w-full cursor-default border-b border-white px-4 py-2 text-center">
                                                By Position
                                            </p>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'business_analyst']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">Business
                                                    Analyst
                                                </a>
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'data_analyst']) }}"
                                                    class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Data Analyst
                                                </a>
                                            </div>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'data_scientist']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Data Scientist
                                                </a>
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'teller']) }}"
                                                    class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Teller
                                                </a>
                                            </div>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'auditor']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Auditor
                                                </a>
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'staff']) }}"
                                                    class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Staff
                                                </a>
                                            </div>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'sales']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Sales
                                                </a>
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'akuntan']) }}"
                                                    class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Akuntan
                                                </a>
                                            </div>
                                            <p
                                                class="block w-full cursor-default border-y border-white px-4 py-2 text-center">
                                                By Facility
                                            </p>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'alphard']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Toyota Alphard
                                                </a>
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'inova']) }}"
                                                    class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Toyota Inova
                                                </a>
                                            </div>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'brio']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Honda Brio
                                                </a>
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'vario']) }}"
                                                    class="block w-1/2 px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Honda Vario
                                                </a>
                                            </div>
                                            <div class="flex w-full flex-row">
                                                <a href="{{ request()->fullUrlWithQuery(['category_filter' => 'pcx']) }}"
                                                    class="block w-1/2 border-r border-white px-4 py-2 hover:bg-gray-600 hover:text-white">
                                                    Honda PCX
                                                </a>
                                                <p class="block w-1/2 cursor-default px-4 py-2">

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="h-full w-full">
                                    <canvas id="myChart2" class="h-full min-h-[5vh] w-auto"></canvas>
                                </div>

                                <div class="mt-5 grid grid-cols-1 items-center justify-between border-t border-white pt-5">
                                    <div class="flex items-center justify-end">
                                        <a href="/facility"
                                            class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-semibold uppercase text-white hover:bg-tertiary hover:text-white">
                                            See Facility List
                                            <svg class="ms-1.5 h-2.5 w-2.5 rtl:rotate-180" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                @php
                                    $brio = $facilityData->where('facility_id', 1)->first()->remain;
                                    $vario = $facilityData->where('facility_id', 2)->first()->remain;
                                    $alphard = $facilityData->where('facility_id', 3)->first()->remain;
                                    $inova = $facilityData->where('facility_id', 4)->first()->remain;
                                    $pcx = $facilityData->where('facility_id', 5)->first()->remain;

                                    $poss = [
                                        0 => 'Business Analyst',
                                        1 => 'Data Analyst',
                                        2 => 'Data Scientist',
                                        3 => 'Teller',
                                        4 => 'Auditor',
                                        5 => 'Staff',
                                        6 => 'Sales',
                                        7 => 'Akuntan',
                                    ];

                                    $facilityIds = [
                                        1 => 'Honda Brio',
                                        2 => 'Honda Vario',
                                        3 => 'Toyota Alphard',
                                        4 => 'Toyota Inova',
                                        5 => 'Honda PCX',
                                    ];

                                    $facilityCount = [];

                                    foreach ($poss as $positionId => $positionName) {
                                        foreach ($facilityIds as $facilityId => $facilityName) {
                                            $facilityCount["{$positionId}Facility{$facilityId}"] = $employeeFacilityData
                                                ->where('facility_id', $facilityId)
                                                ->where('position', $positionId)
                                                ->count();
                                        }
                                    }

                                    $BrioPos = [$facilityCount['0Facility1'], $facilityCount['1Facility1'], $facilityCount['2Facility1'], $facilityCount['3Facility1'], $facilityCount['4Facility1'], $facilityCount['5Facility1'], $facilityCount['6Facility1'], $facilityCount['7Facility1']];

                                    # Sorting BrioPos
                                    arsort($BrioPos);

                                    # Buatkan sort Position berdasarkan Sort dari $BrioPos
                                    $sortedListPositionBrio = [];

                                    foreach ($BrioPos as $positionId => $count) {
                                        $sortedListPositionBrio[] = $poss[$positionId];
                                    }

                                    $sortedBrioPos = array_values($BrioPos);

                                    $VarioPos = [$facilityCount['0Facility2'], $facilityCount['1Facility2'], $facilityCount['2Facility2'], $facilityCount['3Facility2'], $facilityCount['4Facility2'], $facilityCount['5Facility2'], $facilityCount['6Facility2'], $facilityCount['7Facility2']];

                                    # Sorting VarioPos
                                    arsort($VarioPos);

                                    # Buatkan sort Position berdasarkan Sort dari $VarioPos
                                    $sortedListPositionVario = [];

                                    foreach ($VarioPos as $positionId => $count) {
                                        $sortedListPositionVario[] = $poss[$positionId];
                                    }

                                    $sortedVarioPos = array_values($VarioPos);

                                    $AlphardPos = [$facilityCount['0Facility3'], $facilityCount['1Facility3'], $facilityCount['2Facility3'], $facilityCount['3Facility3'], $facilityCount['4Facility3'], $facilityCount['5Facility3'], $facilityCount['6Facility3'], $facilityCount['7Facility3']];

                                    # Sorting AlphardPos
                                    arsort($AlphardPos);

                                    # Buatkan sort Position berdasarkan Sort dari $AlphardPos
                                    $sortedListPositionAlphard = [];

                                    foreach ($AlphardPos as $positionId => $count) {
                                        $sortedListPositionAlphard[] = $poss[$positionId];
                                    }

                                    $sortedAlphardPos = array_values($AlphardPos);

                                    $InovaPos = [$facilityCount['0Facility5'], $facilityCount['1Facility5'], $facilityCount['2Facility5'], $facilityCount['3Facility5'], $facilityCount['4Facility5'], $facilityCount['5Facility5'], $facilityCount['6Facility5'], $facilityCount['7Facility5']];

                                    # Sorting InovaPos
                                    arsort($InovaPos);

                                    # Create a sorted Position list for Inova
                                    $sortedListPositionInova = [];

                                    foreach ($InovaPos as $positionId => $count) {
                                        $sortedListPositionInova[] = $poss[$positionId];
                                    }

                                    $sortedInovaPos = array_values($InovaPos);

                                    $PCXPos = [$facilityCount['0Facility4'], $facilityCount['1Facility4'], $facilityCount['2Facility4'], $facilityCount['3Facility4'], $facilityCount['4Facility4'], $facilityCount['5Facility4'], $facilityCount['6Facility4'], $facilityCount['7Facility4']];

                                    # Sorting PCXPos
                                    arsort($PCXPos);

                                    # Create a sorted Position list for PCX
                                    $sortedListPositionPCX = [];

                                    foreach ($PCXPos as $positionId => $count) {
                                        $sortedListPositionPCX[] = $poss[$positionId];
                                    }

                                    $sortedPCXPos = array_values($PCXPos);

                                    $facilityID = [
                                        0 => 'Honda Brio',
                                        1 => 'Honda Vario',
                                        2 => 'Toyota Alphard',
                                        3 => 'Toyota Inova',
                                        4 => 'Honda PCX',
                                    ];

                                    $BusinessPos = [$facilityCount['0Facility1'], $facilityCount['0Facility2'], $facilityCount['0Facility3'], $facilityCount['0Facility4'], $facilityCount['0Facility5']];

                                    # Sorting BusinessPos
                                    arsort($BusinessPos);

                                    # Buatkan sort Position berdasarkan Sort dari $BusinessPos
                                    $sortedListFacBusiness = [];

                                    foreach ($BusinessPos as $facId => $count) {
                                        $sortedListFacBusiness[] = $facilityID[$facId];
                                    }

                                    $sortedBusinessPos = array_values($BusinessPos);

                                    $AnalystPos = [$facilityCount['1Facility1'], $facilityCount['1Facility2'], $facilityCount['1Facility3'], $facilityCount['1Facility4'], $facilityCount['1Facility5']];

                                    # Sorting AnalystPos
                                    arsort($AnalystPos);

                                    # Buatkan sort Position berdasarkan Sort dari $AnalystPos
                                    $sortedListFacAnalyst = [];

                                    foreach ($AnalystPos as $facId => $count) {
                                        $sortedListFacAnalyst[] = $facilityID[$facId];
                                    }

                                    $sortedAnalystPos = array_values($AnalystPos);

                                    $DataPos = [$facilityCount['2Facility1'], $facilityCount['2Facility2'], $facilityCount['2Facility3'], $facilityCount['2Facility4'], $facilityCount['2Facility5']];

                                    # Sorting DataPos
                                    arsort($DataPos);

                                    # Buatkan sort Position berdasarkan Sort dari $DataPos
                                    $sortedListFacData = [];

                                    foreach ($DataPos as $facId => $count) {
                                        $sortedListFacData[] = $facilityID[$facId];
                                    }

                                    $sortedDataPos = array_values($DataPos);

                                    $TellerPos = [$facilityCount['3Facility1'], $facilityCount['3Facility2'], $facilityCount['3Facility3'], $facilityCount['3Facility4'], $facilityCount['3Facility5']];

                                    # Sorting TellerPos
                                    arsort($TellerPos);

                                    # Buatkan sort Position berdasarkan Sort dari $TellerPos
                                    $sortedListFacTeller = [];

                                    foreach ($TellerPos as $facId => $count) {
                                        $sortedListFacTeller[] = $facilityID[$facId];
                                    }

                                    $sortedTellerPos = array_values($TellerPos);

                                    $AuditorPos = [$facilityCount['4Facility1'], $facilityCount['4Facility2'], $facilityCount['4Facility3'], $facilityCount['4Facility4'], $facilityCount['4Facility5']];

                                    # Sorting AuditorPos
                                    arsort($AuditorPos);

                                    # Buatkan sort Position berdasarkan Sort dari $AuditorPos
                                    $sortedListFacAuditor = [];

                                    foreach ($AuditorPos as $facId => $count) {
                                        $sortedListFacAuditor[] = $facilityID[$facId];
                                    }

                                    $sortedAuditorPos = array_values($AuditorPos);

                                    $StaffPos = [$facilityCount['5Facility1'], $facilityCount['5Facility2'], $facilityCount['5Facility3'], $facilityCount['5Facility4'], $facilityCount['5Facility5']];

                                    # Sorting StaffPos
                                    arsort($StaffPos);

                                    # Buatkan sort Position berdasarkan Sort dari $StaffPos
                                    $sortedListFacStaff = [];

                                    foreach ($StaffPos as $facId => $count) {
                                        $sortedListFacStaff[] = $facilityID[$facId];
                                    }

                                    $sortedStaffPos = array_values($StaffPos);

                                    $SalesPos = [$facilityCount['6Facility1'], $facilityCount['6Facility2'], $facilityCount['6Facility3'], $facilityCount['6Facility4'], $facilityCount['6Facility5']];

                                    # Sorting SalesPos
                                    arsort($SalesPos);

                                    # Buatkan sort Position berdasarkan Sort dari $SalesPos
                                    $sortedListFacSales = [];

                                    foreach ($SalesPos as $facId => $count) {
                                        $sortedListFacSales[] = $facilityID[$facId];
                                    }

                                    $sortedSalesPos = array_values($SalesPos);

                                    $AkuntanPos = [$facilityCount['7Facility1'], $facilityCount['7Facility2'], $facilityCount['7Facility3'], $facilityCount['7Facility4'], $facilityCount['7Facility5']];

                                    # Sorting AkuntanPos
                                    arsort($AkuntanPos);

                                    # Buatkan sort Position berdasarkan Sort dari $AkuntanPos
                                    $sortedListFacAkuntan = [];

                                    foreach ($AkuntanPos as $facId => $count) {
                                        $sortedListFacAkuntan[] = $facilityID[$facId];
                                    }

                                    $sortedAkuntanPos = array_values($AkuntanPos);

                                @endphp

                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <script>
                                    const ctx2 = document.getElementById('myChart2');

                                    new Chart(ctx2, {
                                        @if ($categoryFilter == '' || $categoryFilter == 'all_remains' || $categoryFilter == 'position')
                                            type: 'bar',
                                        @else
                                            type: 'pie',
                                        @endif
                                        data: {
                                            @if ($categoryFilter == '' || $categoryFilter == 'all_remains' || $categoryFilter == 'position')
                                                labels: ['Honda Brio', 'Honda Vario', 'Toyota Alphard', 'Toyota Inova', 'Honda PCX'],
                                            @elseif ($categoryFilter == 'brio')
                                                labels: {!! json_encode($sortedListPositionBrio) !!},
                                            @elseif ($categoryFilter == 'alphard')
                                                labels: {!! json_encode($sortedListPositionAlphard) !!},
                                            @elseif ($categoryFilter == 'inova')
                                                labels: {!! json_encode($sortedListPositionInova) !!},
                                            @elseif ($categoryFilter == 'pcx')
                                                labels: {!! json_encode($sortedListPositionPCX) !!},
                                            @elseif ($categoryFilter == 'vario')
                                                labels: {!! json_encode($sortedListPositionVario) !!},
                                            @elseif ($categoryFilter == 'business_analyst')
                                                labels: {!! json_encode($sortedListFacBusiness) !!},
                                            @elseif ($categoryFilter == 'data_scientist')
                                                labels: {!! json_encode($sortedListFacData) !!},
                                            @elseif ($categoryFilter == 'data_analyst')
                                                labels: {!! json_encode($sortedListFacAnalyst) !!},
                                            @elseif ($categoryFilter == 'teller')
                                                labels: {!! json_encode($sortedListFacTeller) !!},
                                            @elseif ($categoryFilter == 'auditor')
                                                labels: {!! json_encode($sortedListFacAuditor) !!},
                                            @elseif ($categoryFilter == 'sales')
                                                labels: {!! json_encode($sortedListFacSales) !!},
                                            @elseif ($categoryFilter == 'staff')
                                                labels: {!! json_encode($sortedListFacStaff) !!},
                                            @elseif ($categoryFilter == 'akuntan')
                                                labels: {!! json_encode($sortedListFacAkuntan) !!},
                                            @endif
                                            datasets: [{
                                                @if ($categoryFilter == '' || $categoryFilter == 'all_remains' || $categoryFilter == 'position')
                                                    label: 'Remaining',
                                                @else
                                                    label: 'Occupied',
                                                @endif
                                                @if ($categoryFilter == '' || $categoryFilter == 'all_remains' || $categoryFilter == 'position')
                                                    data: [{{ $brio }}, {{ $vario }}, {{ $alphard }},
                                                        {{ $inova }}, {{ $pcx }}
                                                    ],
                                                @elseif ($categoryFilter == 'brio')
                                                    data: {!! json_encode($sortedBrioPos) !!},
                                                @elseif ($categoryFilter == 'alphard')
                                                    data: {!! json_encode($sortedAlphardPos) !!},
                                                @elseif ($categoryFilter == 'inova')
                                                    data: {!! json_encode($sortedInovaPos) !!},
                                                @elseif ($categoryFilter == 'pcx')
                                                    data: {!! json_encode($sortedPCXPos) !!},
                                                @elseif ($categoryFilter == 'vario')
                                                    data: {!! json_encode($sortedVarioPos) !!},
                                                @elseif ($categoryFilter == 'business_analyst')
                                                    data: {!! json_encode($sortedBusinessPos) !!},
                                                @elseif ($categoryFilter == 'data_scientist')
                                                    data: {!! json_encode($sortedDataPos) !!},
                                                @elseif ($categoryFilter == 'data_analyst')
                                                    data: {!! json_encode($sortedAnalystPos) !!},
                                                @elseif ($categoryFilter == 'teller')
                                                    data: {!! json_encode($sortedTellerPos) !!},
                                                @elseif ($categoryFilter == 'auditor')
                                                    data: {!! json_encode($sortedAuditorPos) !!},
                                                @elseif ($categoryFilter == 'sales')
                                                    data: {!! json_encode($sortedSalesPos) !!},
                                                @elseif ($categoryFilter == 'staff')
                                                    data: {!! json_encode($sortedStaffPos) !!},
                                                @elseif ($categoryFilter == 'akuntan')
                                                    data: {!! json_encode($sortedAkuntanPos) !!},
                                                @endif
                                                @if (
                                                    $categoryFilter == 'brio' ||
                                                        $categoryFilter == 'alphard' ||
                                                        $categoryFilter == 'inova' ||
                                                        $categoryFilter == 'pcx' ||
                                                        $categoryFilter == 'vario')
                                                    backgroundColor: [
                                                        '#67B7DC',
                                                        '#6794DC',
                                                        '#6771DC',
                                                        '#8067DC',
                                                        '#A367DC',
                                                        '#C767DC',
                                                        '#DC67CE',
                                                        '#DC67AB',

                                                    ],
                                                @else
                                                    backgroundColor: [
                                                        '#6794DC ',
                                                        '#6771DC ',
                                                        '#8067DC ',
                                                        '#A367DC',
                                                        '#C767DC'
                                                    ],
                                                @endif
                                                borderColor: '#00000',
                                                borderWidth: 1,
                                                @if ($categoryFilter == '' || $categoryFilter == 'all_remains' || $categoryFilter == 'position')
                                                    borderRadius: {
                                                        topLeft: 10,
                                                        topRight: 10,
                                                    }
                                                @endif

                                            }]
                                        },
                                        options: {
                                            @if ($categoryFilter == '' || $categoryFilter == 'all_remains' || $categoryFilter == 'position')
                                                scales: {
                                                    x: {
                                                        border: {
                                                            display: true,
                                                            color: '#FFFFFF',
                                                        },
                                                        grid: {
                                                            display: false,
                                                        },
                                                        ticks: {
                                                            font: 'normal',
                                                            size: 5,
                                                            color: '#FFFFFF',
                                                        }
                                                    },
                                                    y: {
                                                        border: {
                                                            display: true,
                                                            color: '#FFFFFF',
                                                        },
                                                        grid: {
                                                            display: true,
                                                        },
                                                        ticks: {
                                                            font: 'normal',
                                                            size: 5,
                                                            color: '#FFFFFF',
                                                        }
                                                    }
                                                },
                                            @endif
                                            layout: {
                                                autoPadding: false,
                                            },
                                            legend: {
                                                @if ($categoryFilter == '' || $categoryFilter == 'all_remains' || $categoryFilter == 'position')
                                                    display: false,
                                                @else
                                                    display: true,
                                                @endif
                                            },
                                            plugins: {
                                                legend: {
                                                    @if ($categoryFilter == '' || $categoryFilter == 'all_remains' || $categoryFilter == 'position')
                                                        display: false,
                                                    @else
                                                        labels: {
                                                            boxWidth: 15,
                                                            boxHeight: 15,
                                                            color: '#FFFFFF',
                                                            useBorderRadius: true,
                                                            borderRadius: 10,
                                                            borderWidth: 0,
                                                            position: 'bottom'
                                                        }
                                                    @endif
                                                }
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                @endif
                {{-- End of Third Column --}}

            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </section>
