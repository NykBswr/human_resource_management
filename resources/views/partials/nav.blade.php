<nav class="fixed w-full h-auto" id="navbar">
    <div class="flex w-full justify-between items-center h-auto gradcolor3 px-10 py-5">
        <div class="flex flex-col cursor-pointer" id="burger">
            <div class="humber bg-primary rounded-xl h-1.5 w-10 mb-2"></div>
            <div class="humber bg-primary rounded-xl h-1.5 w-10 mb-2"></div>
            <div class="humber bg-primary rounded-xl h-1.5 w-10"></div>
        </div>
        <div class="flex items-center">
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
            <h1 class="text-primary mr-5 text-xl">Welcome, {{ $employee->firstname ." ".$employee->lastname ." - ". $positionMapping[$employee['position']] ." " . $employee->role}}</h1>
            <img src="{{ asset('storage/images/' . $employee->image) }}" class="w-14 h-14 rounded-full border border-primary" id="logoprofile">  
        </div>
    </div>
    <div class="hidden flex-col items-end" id="profile">
        <div class="flex flex-col justify-center px-5 py-5 mt-5 mr-10 ml-10 bg-secondary rounded-2xl">
            @if (auth()->user()->role == 3)
                <a href="/createuser">
                    <h1 class="w-full text-primary py-5 px-12 mb-5 text-xl bg-tertiary hover:bg-opacity-50 rounded-md">Add Employee</h1>
                </a>
            @endif
            <a href="/dashboard/profile/{{ auth()->user()->id }}/edit">
                <h1 class="w-full text-primary py-5 px-12 mb-5 text-xl bg-tertiary hover:bg-opacity-50 rounded-md">Profile</h1>
            </a>
            <a href="/">
                <h1 class="w-full text-primary py-5 px-12 mb-5 text-xl bg-tertiary hover:bg-opacity-50 rounded-md">Company Profile</h1>
            </a>
            <a href="/dashboard/changepassword/{{ auth()->user()->id }}">
                <h1 class="w-full text-primary py-5 px-12 mb-5 text-xl bg-tertiary hover:bg-opacity-50 rounded-md">Change Password</h1>
            </a>
            <form class="bg-tertiary hover:bg-opacity-50 w-full py-5 px-12 rounded-md" action="/logout" method="post">
                @csrf
                <button type="submit" class="text-primary text-xl text-start">
                    <h1>Sign Out</h1>
                </button>
            </form>
        </div>
    </div>
</nav>



