@extends('layout.main')

@section('container')

@include('profile-perusahaan.partials.nav')

<section id="first" class="p-20 pt-32">
    <div class="flex flex-col justify-center items-center h-auto w-full">
        <img src="{{ URL::asset('img/profileimg-1.png') }}" class="absolute -z-[1]">
        <h1 class="text-primary font-bold text-3xl lg:text-6xl text-center mb-4">
            National Youth Keepers <br/>Bank
        </h1>
        
        <p class="text-slate-300 text-center text-sm lg:text-xl max-w-[50rem] w-auto h-auto mb-8">Financial institution dedicated to the sustainability of the younger generation's future. As financial custodians, we safeguard the wealth and assets of our clients with services that foster growth, empower youth, and contribute to national unity. We are your financial partner for a better future</p>

        <button class="btn py-3 px-6 gradcolor text-white rounded-md">
            Explore Further.
        </button>
    </div>
</section>

<section id="second" class="w-full">
    <div class="flex flex-col items-center justify-center">
        <div class="flex items-center justify-center flex-shrink w-[34.125rem] h-[22.5625rem] lg:w-[54.125rem] lg:h-[34.5625rem] bg-secondary rounded-2xl">
            <div class="flex flex-col items-center justify-center flex-shrink w-[26.125rem] h-[19.75rem] lg:w-[46.125rem] lg:h-[28.75rem] bg-tertiary rounded-2xl">
                <img src="" ><img src="{{ URL::asset('img/logo-white.svg') }}" class="w-auto h-4 lg:h-10 m-2 lg:m-5">
                <img src="{{ URL::asset('img/profileimg-3.png') }}" class="flex-shrink-0 w-[22.1875rem] h-[14.8125rem] lg:w-[41.1875rem] lg:h-[20.8125rem] rounded-2xl">
            </div>
        </div>
        <img src="{{ URL::asset('img/profileimg-2.png') }}" class="absolute -z-[1] w-full h-auto max-h-96">
    </div>
</section>

<section id="third" class="p-20">
    <h1 class= "text-primary font-bold text-5xl text-start">
        The Founders
    </h1>
    <div class="w-full flex flex-col">
        <div class="w-full flex flex-row items-stretch justify-between">
            <div class="bg-tertiary rounded-2xl my-5 flex items-center justify-center flex-shrink mr-5 w-[18rem] lg:w-[22rem] lg:h-[22rem]">
                <img src="{{ URL::asset('img/profileimg-4.png') }}" class="w-[18rem] lg:w-[22rem] lg:h-[22rem] p-5">
            </div>
            <div class="bg-tertiary rounded-2xl my-5 flex items-center justify-center flex-shrink mr-5 w-[18rem] lg:w-[22rem] lg:h-[22rem]">
                <img src="{{ URL::asset('img/profileimg-5.png') }}" class="w-[18rem] lg:w-[22rem] lg:h-[22rem] p-5">
            </div>
            <div class="bg-tertiary rounded-2xl my-5 flex items-center justify-center flex-shrink w-[18rem] lg:w-[22rem] lg:h-[22rem]">
                <img src="{{ URL::asset('img/profileimg-6.png') }}" class="w-[18rem] lg:w-[22rem] lg:h-[22rem] p-5">
            </div>
        </div>
        <div class="w-full flex flex-row items-stretch justify-between">
            <div class="bg-tertiary rounded-2xl my-5 flex items-center justify-center flex-shrink mr-5 w-[18rem] lg:w-[22rem] lg:h-[22rem]">
                <img src="{{ URL::asset('img/profileimg-7.png') }}" class="w-[18rem] lg:w-[22rem] lg:h-[22rem] p-5">
            </div>
            <div class="bg-tertiary rounded-2xl my-5 flex items-center justify-center flex-shrink mr-5 w-[18rem] lg:w-[22rem] lg:h-[22rem]">
                <img src="{{ URL::asset('img/profileimg-8.png') }}" class="w-[18rem] lg:w-[22rem] lg:h-[22rem] p-5">
            </div>
            <div class="hidden lg:flex bg-tertiary rounded-2xl my-5 flex-col content-start flex-shrink w-[18rem] lg:w-[22rem] lg:h-[22rem]">
                <h1 class= "text-primary font-bold text-4xl text-start p-5">
                    Here's about <br/>the founders
                </h1>
                <p class= "text-slate-300 text-sm text-start px-5 pb-5">
                    Financial institution dedicated to the sustainability of the younger generation's future. As financial custodians, we safeguard the wealth and assets of our clients with services that foster growth, empower youth, and contribute to national unity. We are your financial partner for a better future
                </p>
            </div>
        </div>
        <div class="flex lg:hidden bg-tertiary rounded-2xl my-5 flex-col content-start flex-shrink w-full h-auto">
            <h1 class= "text-primary font-bold text-4xl text-start p-5">
                Here's about the founders
            </h1>
            <p class= "text-slate-300 text-sm text-start px-5 pb-5">
                Financial institution dedicated to the sustainability of the younger generation's future. As financial custodians, we safeguard the wealth and assets of our clients with services that foster growth, empower youth, and contribute to national unity. We are your financial partner for a better future
            </p>
        </div>
    </div>
</section>

<section id="fourth" class="p-20">
    <div class="flex flex-row items-center justify-center">
        <img src="{{ URL::asset('img/profileimg-9.png') }}" class="hidden lg:block w-[31rem] h-[31rem] p-5">
        <div class="p-5">
            <h1 class= "text-primary font-bold text-5xl text-start my-5">
                Here's about the company
            </h1>
            <p class= "text-slate-300 text-md text-start">Financial institution dedicated to the sustainability of the younger generation's future. As financial custodians, we safeguard the wealth and assets of our clients with services that foster growth, empower youth, and contribute to national unity. We are your financial partner for a better future</p>
            <a href="#sixth">
                <button class="btn py-3 px-7 gradcolor text-white rounded-md my-5">
                    Contact us.
                </button>
            </a>
        </div>
    </div>
</section>

<section id="fifth" class="py-20">
    <div class="flex flex-col items-center justify-center">
        <div class="w-full h-[30rem] bg-tertiary">
            <h1 class= "text-primary font-bold text-5xl text-center my-10">Companies we Worked <br/>With in Since 2222</h1>
            <div class="w-full flex flex-row items-stretch justify-center">
                <div class="bg-secondary rounded-xl my-5 flex items-center justify-center flex-shrink mr-5 w-40 lg:w-48 h-28">
                    {{-- Company 1 --}}
                </div>
                <div class="bg-secondary rounded-xl my-5 flex items-center justify-center flex-shrink mr-5 w-40 lg:w-48 h-28">
                    {{-- Company 2 --}}
                </div>
                <div class="bg-secondary rounded-xl my-5 flex items-center justify-center flex-shrink mr-5 w-40 lg:w-48 h-28">
                    {{-- Company 3 --}}
                </div>
            </div>
        </div>
        <div class="flex gradcolor2 rounded-2xl mt-[-5rem] w-11/12 h-1/5  lg:w-[69rem] lg:h-[26rem]">
            <div class="w-1/2 flex flex-row items-center justify-center">
                <div class="hidden lg:flex bg-secondary rounded-2xl my-5 items-center justify-center flex-shrink mr-5 w-[29rem] h-[22rem]">
                    <img src="{{ URL::asset('img/profileimg-10.png') }}">
                </div>
            </div>
            <img src="{{ URL::asset('img/profileimg-11.png') }}" class="w-[34rem] h-full">
        </div>
    </div>
</section>

<section id="sixth" class="p-20  pb-20">
    <div class="w-full flex flex-row items-center justify-center">
        <img src="{{ URL::asset('img/profileimg-12.png') }}" class="hidden lg:block w-[30rem] h-auto">
        <div class="">
            <h1 class= "text-primary font-bold text-5xl text-start mb-5">
                Get In Touch
            </h1>
            <input class="bg-secondary rounded-md text-primary flex flex-start gap-3 w-[25rem] px-6 py-3 mb-4" type="text" id="nama" placeholder="Name" name="nama" value="" />
            <input class="bg-secondary rounded-md text-primary flex flex-start gap-3 w-[25rem] px-6 py-3 mb-4" type="text" id="email" placeholder="Email" name="email" value="" />
            <input class="bg-secondary rounded-md text-primary flex flex-start gap-3 w-[25rem] px-6 pt-3 pb-28" type="text" id="text" placeholder="Text" name="text" value="" />
        </div>
    </div>
</section>


