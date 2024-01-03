<div class="z-[2] hidden h-screen w-[27rem] bg-secondary py-20" style="border-top-right-radius: 30px;" id="sidebar">
    <div class="flex flex-col items-center justify-center">
        <img class="mb-10 h-14 w-24 cursor-pointer" src="{{ URL::asset('img/logo-white.svg') }}" id="logo">
        <div class="w-full overflow-y-auto px-12 pb-10">
            <a href="/dashboard" class="{{ Request::is('dashboard') ? 'text-primary' : 'text-slate-500' }}">
                <h1
                    class="mb-5 flex w-[100%] justify-start rounded-md bg-tertiary px-16 py-5 text-xl hover:bg-opacity-50 hover:text-white">
                    Dashboard</h1>
            </a>
            {{-- <a href="" class="{{ Request::is('') ? 'text-primary' : 'text-slate-500' }}">
                <h1 class="w-[100%] py-5 px-16 flex justify-start mb-5 text-xl rounded-md bg-tertiary hover:text-white hover:bg-opacity-50">Reports and Analysis</h1>
            </a> --}}
            <a href="/attendance" class="{{ Request::is('attendance') ? 'text-primary' : 'text-slate-500' }}">
                <h1
                    class="mb-5 flex w-[100%] justify-start rounded-md bg-tertiary px-16 py-5 text-xl hover:bg-opacity-50 hover:text-white">
                    Atendance</h1>
            </a>
            <a href="/task" class="{{ Request::is('task') ? 'text-primary' : 'text-slate-500' }}">
                <h1
                    class="mb-5 flex w-[100%] justify-start rounded-md bg-tertiary px-16 py-5 text-xl hover:bg-opacity-50 hover:text-white">
                    Task</h1>
            </a>
            <a href="PayrollandBenefit"
                class="{{ Request::is('PayrollandBenefit') ? 'text-primary' : 'text-slate-500' }}">
                <h1
                    class="mb-5 flex w-[100%] justify-start rounded-md bg-tertiary px-16 py-5 text-xl hover:bg-opacity-50 hover:text-white">
                    Payroll and Benefits</h1>
            </a>
            <a href="/facility" class="{{ Request::is('facility') ? 'text-primary' : 'text-slate-500' }}">
                <h1
                    class="mb-5 flex w-[100%] justify-start rounded-md bg-tertiary px-16 py-5 text-xl hover:bg-opacity-50 hover:text-white">
                    Facility</h1>
            </a>
            <a href="/offdays" class="{{ Request::is('offdays') ? 'text-primary' : 'text-slate-500' }}">
                <h1
                    class="mb-5 flex w-[100%] justify-start rounded-md bg-tertiary px-16 py-5 text-xl hover:bg-opacity-50 hover:text-white">
                    Off Days</h1>
            </a>

            @can('atasan')
                <a href="/userlist" class="{{ Request::is('userlist') ? 'text-primary' : 'text-slate-500' }}">
                    <h1
                        class="mb-5 flex w-[100%] justify-start rounded-md bg-tertiary px-16 py-5 text-xl hover:bg-opacity-50 hover:text-white">
                        Employee List</h1>
                </a>
            @endcan
        </div>
    </div>
</div>
