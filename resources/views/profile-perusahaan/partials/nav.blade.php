<nav class="w-full fixed py-8 px-14 flex justify-between items-center">
    {{-- Left Nav --}}
    <div class="">
        <a href="#first"><img src="{{ URL::asset('img/logo-white.svg') }}"></a>
    </div>
    {{-- Hamburger Menu (untuk layar kecil) --}}
    <div class="md:hidden">
        <button id="menu-toggle" class="text-slate-300 hover:text-primary">
            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                <path
                    d="M4 6h16M4 12h16m-7 6h7"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </button>
    </div>
    {{-- Right Nav (untuk layar besar) --}}
    <div class="hidden md:block">
        {{-- <a href="" class="text-slate-300 hover:text-primary mr-3">Home</a> --}}
        <a href="/login">
            <button class="btn py-3 px-6 gradcolor text-white rounded-md">
                Employee login
            </button>
        </a>
    </div>
</nav>
