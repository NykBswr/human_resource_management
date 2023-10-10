<nav class="w-full fixed py-8 px-14 flex justify-between items-center bg-secondary bg-opacity-50">
    {{-- Left Nav --}}
    <div class="">
        <a href="#first">
            <img src="{{ URL::asset('img/logo-white.svg') }}">
        </a>
    </div>
    <div class="">
        {{-- <a href="" class="text-slate-300 hover:text-primary mr-3">Home</a> --}}
        <a href="/login">
            <button class="btn py-3 px-6 gradcolor text-white rounded-md">
                Employee login
            </button>
        </a>
    </div>
</nav>
