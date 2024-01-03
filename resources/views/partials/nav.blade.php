<nav class="fixed z-[1] h-auto w-full" id="navbar">
    <div class="gradcolor3 flex h-auto w-full items-center px-10 py-5">
        <div class="mr-10 flex cursor-pointer flex-col" id="burger">
            <div class="humber mb-2 h-1.5 w-10 rounded-xl bg-primary"></div>
            <div class="humber mb-2 h-1.5 w-10 rounded-xl bg-primary"></div>
            <div class="humber h-1.5 w-10 rounded-xl bg-primary"></div>
        </div>
        @if (request()->is('dashboard') ||
                (request()->is('PayrollandBenefit') &&
                    (auth()->user()->role == 0 || auth()->user()->role == 1 || auth()->user()->role == 2)))
        @else
            <form class="flex flex-row rounded-xl">
                <div class="flex">
                    </button>
                    <div class="relative w-full">
                        <input type="search" id="search-dropdown"
                            class="z-20 block w-[20vw] rounded-xl rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-tertiary focus:ring-tertiary"
                            placeholder="Search" required>
                        <button type="submit"
                            class="absolute end-0 top-0 h-full rounded-e-lg border border-dark bg-dark p-2.5 text-sm font-medium text-white hover:bg-tertiary focus:outline-none focus:ring-4 focus:ring-tertiary">
                            <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
            </form>
        @endif
        <div class="ml-auto flex items-center">
            @php
                $positionMapping = [
                    null => '',
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
            <h1 class="mr-5 text-xl text-primary">Welcome,
                {{ $employee->firstname . ' ' . $employee->lastname . ' - ' . $positionMapping[$employee['position']] . ' ' . $employee->role }}
            </h1>
            @if ($employee->image == 'logo-white.svg')
                <img src="{{ asset('img/' . $employee->image) }}" class="h-14 w-14 rounded-full border border-primary"
                    id="logoprofile">
            @else
                <img src="{{ asset('storage/images/' . $employee->image) }}"
                    class="h-14 w-14 rounded-full border border-primary" id="logoprofile">
            @endif
        </div>
    </div>
    <div class="hidden flex-col items-end" id="profile">
        <div class="ml-10 mr-10 mt-5 flex flex-col justify-center rounded-2xl bg-secondary px-5 py-5">
            @if (auth()->user()->role == 3)
                <a href="/createuser">
                    <h1 class="mb-5 w-full rounded-md bg-tertiary px-12 py-5 text-xl text-primary hover:bg-opacity-50">
                        Add Employee</h1>
                </a>
            @endif
            <a href="/dashboard/profile/{{ auth()->user()->id }}/edit">
                <h1 class="mb-5 w-full rounded-md bg-tertiary px-12 py-5 text-xl text-primary hover:bg-opacity-50">
                    Profile</h1>
            </a>
            <a href="/">
                <h1 class="mb-5 w-full rounded-md bg-tertiary px-12 py-5 text-xl text-primary hover:bg-opacity-50">
                    Company Profile</h1>
            </a>
            <a href="/dashboard/changepassword/{{ auth()->user()->id }}">
                <h1 class="mb-5 w-full rounded-md bg-tertiary px-12 py-5 text-xl text-primary hover:bg-opacity-50">
                    Change Password</h1>
            </a>
            <form class="w-full rounded-md bg-tertiary px-12 py-5 hover:bg-opacity-50" action="/logout" method="post">
                @csrf
                <button type="submit" class="text-start text-xl text-primary">
                    <h1>Sign Out</h1>
                </button>
            </form>
        </div>
    </div>
</nav>
