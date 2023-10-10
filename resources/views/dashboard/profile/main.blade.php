@extends('layout.main')

@section('container')

<section class="w-full h-full py-8 px-8 flex items-center">
    <div class="w-full h-full bg-tertiary py-8 px-8 rounded-2xl flex flex-col items-center">
        <div class="w-full flex items-center justify-center mb-5">
            <div class="bg-dark p-3 rounded-xl flex justify-start">
                <a href="/dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                        <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" fill="white"/>
                    </svg>
                </a>
            </div>
            <h1 class="w-full text-2xl text-center text-primary flex justify-center">
                PROFILE
            </h1>
            <div class="bg-transparant p-3 rounded-xl flex justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                    <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" />
                </svg>
            </div>
        </div>
        
        <div class="w-full h-full py-11 px-20 bg-dark rounded-2xl flex flex-col items-center justify-center">
            <img src="{{ URL::asset('img/logo-white.svg') }}" class="w-20 lg:w-40 h-20 lg:h-40 rounded-full border border-primary mb-8" id="logoprofile">
            <input class="bg-secondary rounded-md text-primary flex flex-start gap-3 w-full px-6 py-3 mb-4" type="text" id="nama" placeholder="Name" name="nama" value="" />
            <input class="bg-secondary rounded-md text-primary flex flex-start gap-3 w-full px-6 py-3 mb-4" type="text" id="email" placeholder="Email" name="email" value="" />
            <input class="bg-secondary rounded-md text-primary flex flex-start gap-3 w-full px-6 py-3 mb-4" type="text" id="role" placeholder="Role" name="role" value="" />
            <button class="btn w-full py-3 px-6 gradcolor text-white rounded-md">
                Update Profile
            </button> 
        </div>
    </div>
</section>