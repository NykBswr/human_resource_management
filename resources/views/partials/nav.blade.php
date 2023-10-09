<nav class="fixed w-full h-auto" id="navbar">
    <div class="flex w-full justify-between items-center h-auto gradcolor3 px-10 py-5">
        <div class="flex flex-col cursor-pointer" id="burger">
            <div class="bg-primary rounded-xl h-1.5 w-10 mb-2"></div>
            <div class="bg-primary rounded-xl h-1.5 w-10 mb-2"></div>
            <div class="bg-primary rounded-xl h-1.5 w-10"></div>
        </div>
        <div class="flex items-center">
            <h1 class="text-primary mr-5 text-xl">Welcome, Gede Nayaka Baswara</h1>
            <img src="{{ URL::asset('img/logo-white.svg') }}" class="w-14 h-14 rounded-full border border-primary" id="logoprofile">  
        </div>
    </div>
    <div class="hidden flex-col items-end" id="profile">
        <div class="flex flex-col justify-center px-5 py-5 mt-5 mr-10 bg-secondary rounded-2xl">
            <a href="#profile">
                <h1 class="text-primary py-5 px-12 mb-5 text-xl bg-tertiary rounded-md">Profile</h1>
            </a>
            <a href="/">
                <h1 class="text-primary py-5 px-12 mb-5 text-xl bg-tertiary rounded-md">Company Profile</h1>
            </a>
            <a href="#signout">
                <h1 class="text-primary py-5 px-12 mb-5 text-xl bg-tertiary rounded-md">Sign Out</h1>
            </a>
        </div>
    </div>
</nav>



