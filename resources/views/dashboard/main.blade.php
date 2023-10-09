@extends('layout.main')

@section('container')

@include('partials.nav')
@include('partials.sidebar')

<section class="w-full h-full pt-36 pb-12 px-20 flex items-center" id="main">
    <div class="w-full h-full bg-tertiary py-5 px-20 rounded-2xl flex flex-col items-center" id="main2">
        <h1 class="w-full text-2xl text-center text-primary mb-5">
            DASHBOARD
        </h1>
        <div class="w-full h-[0.0625rem] bg-slate-400 mb-5"></div>
        <div class="w-full h-full  bg-secondary rounded-2xl flex  items-center">

        </div>
    </div>
</section>