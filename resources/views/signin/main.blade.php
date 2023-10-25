@extends('layout.main')

@section('container')

<section id="login">
    <div class="w-full h-screen flex justify-center lg:justify-between items-center">
        <div class="w-full lg:w-1/2 lg:pl-20 text-center lg:text-justify flex flex-col justify-center items-center lg:items-start">
            <img src="{{ URL::asset('img/logo-white.svg') }}" class="w-32 mb-5">
            <h1 class="font-bold text-primary text-6xl mb-10">Login</h1>
            <form action="{{ route('login') }}" method="post" class="flex flex-col">
                @csrf
                <input class="bg-secondary rounded-md text-primary gap-3 w-[20rem] lg:w-[25rem] px-6 py-3 mb-4 " type="text" id="identity" placeholder="Your username or email" name="identity" value="{{ old('identity') }}" required autofocus/>
                <input class="bg-secondary rounded-md text-primary gap-3 w-[20rem] lg:w-[25rem] px-6 py-3 mb-4" type="password" id="password" placeholder="Password" name="password" value="" />
                <button type="submit" class="w-[10rem] py-3 px-6 gradcolor text-white rounded-md mb-10 lg:mb-5">
                    Sign in Now
                </button>
            </form>
            <a class="text-primary text-md font-semibold flex underline underline-offset-8" href="/">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37 24" fill="none" class="w-10 h-5 mr-2">
                    <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" fill="white"/>
                </svg>
                Back to company pages
            </a>
        </div>
        <div class="w-1/2 h-full overflow-hidden hidden lg:block">
            <div class="flex flex-row w-full" id="image-container">
                <img src="{{ URL::asset('img/loginimg-1.svg') }}" class="image animate-updown w-1/3 pl-8" id="img1">
                <img src="{{ URL::asset('img/loginimg-2.svg') }}" class="image animate-updown w-1/3 pl-8" id="img2">
                <img src="{{ URL::asset('img/loginimg-3.svg') }}" class="image animate-updown w-1/3 pl-8" id="img3">
            </div>
        </div>
    </div>
</section>