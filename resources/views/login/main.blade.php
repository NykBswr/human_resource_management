@extends('layout.main')

@section('container')

<section id="login">
    <div class="w-full h-screen flex justify-between items-center px-5">
        <div class="lg:pl-20 text-center lg:text-justify">
            <img src="{{ URL::asset('img/logo-white.svg') }}" class="w-32 mb-5">
            <h1 class="font-bold text-primary text-6xl mb-10">Login</h1>
            <input class="bg-secondary rounded-md text-primary flex flex-start gap-3 w-[20rem] lg:w-[25rem] px-6 py-3 mb-4" type="text" id="email" placeholder="Your Email" name="email" value="" />
            <input class="bg-secondary rounded-md text-primary flex flex-start gap-3 w-[20rem] lg:w-[25rem] px-6 py-3 mb-4" type="text" id="password" placeholder="Password" name="password" value="" />
            <a href="#">
            <button class="btn py-3 px-6 gradcolor text-white rounded-md mb-10 lg:mb-5">
                Sign in Now
            </button>
        </a>
        </div>
        <img src="{{ URL::asset('img/loginimg-1.png') }}" class="hidden lg:block h-full w-auto">
    </div>
</section>