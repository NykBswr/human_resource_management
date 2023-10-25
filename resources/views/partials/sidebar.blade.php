<div class="hidden h-screen w-[27rem] bg-secondary py-20" style="border-top-right-radius: 30px;" id="sidebar">
    <div class="flex flex-col justify-center items-center">
        <img class="w-24 h-14 mb-10 cursor-pointer" src="{{ URL::asset('img/logo-white.svg') }}" id="logo">
        <div class="">
            {{-- <a href="/dashboard" class="{{ Request::is('dashboard') ? 'text-primary' : 'text-slate-500' }}">
                <h1 class="py-5 px-12 mb-5 text-xl rounded-md bg-tertiary hover:text-white hover:bg-opacity-50">Dashboard</h1>
            </a> --}}
            <a href="/task" class="{{ Request::is('task') ? 'text-primary' : 'text-slate-500' }}">
                <h1 class="py-5 px-12 mb-5 text-xl rounded-md bg-tertiary hover:text-white hover:bg-opacity-50">Task</h1>
            </a>
            <a href="" class="{{ Request::is('') ? 'text-primary' : 'text-slate-500' }}">
                <h1 class="py-5 px-12 mb-5 text-xl rounded-md bg-tertiary hover:text-white hover:bg-opacity-50">Payroll and Benefits</h1>
            </a>
            <a href="" class="{{ Request::is('') ? 'text-primary' : 'text-slate-500' }}">
                <h1 class="py-5 px-12 mb-5 text-xl rounded-md bg-tertiary hover:text-white hover:bg-opacity-50">Reports and Analysis</h1>
            </a>
            <a href="/facility" class="{{ Request::is('facility') ? 'text-primary' : 'text-slate-500' }}">
                <h1 class="py-5 px-12 mb-5 text-xl rounded-md bg-tertiary hover:text-white hover:bg-opacity-50">Facility</h1>
            </a>
            @can('atasan')
            <a href="/userlist" class="{{ Request::is('userlist') ? 'text-primary' : 'text-slate-500' }}">
                <h1 class="py-5 px-12 mb-5 text-xl rounded-md bg-tertiary hover:text-white hover:bg-opacity-50">Employee List</h1>
            </a>
            @endcan
            <a href="/attendance" class="{{ Request::is('attendance') ? 'text-primary' : 'text-slate-500' }}">
                <h1 class="py-5 px-12 mb-5 text-xl rounded-md bg-tertiary hover:text-white hover:bg-opacity-50">Atendance</h1>
            </a>
        </div>
    </div>
</div>