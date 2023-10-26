@extends('layout.main')

@section('container')


<section class="w-full h-screen py-10 px-10 flex items-center justify-center">
    <div class="w-[40%] h-[90%] bg-tertiary py-8 px-8 rounded-2xl flex flex-col items-center">
        <div class="w-full flex items-center justify-center mb-5">
            <div class="gradcolor p-3 rounded-xl flex justify-start">
                @if(auth()->user()->role == 3)
                <a href="/PayrollandBenefit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                        <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" fill="white"/>
                    </svg>
                </a>
                @else
                <a href="/PayrollandBenefit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                        <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" fill="white"/>
                    </svg>
                </a>
                @endif
            </div>
            <h1 class="w-full text-2xl text-center text-primary flex justify-center uppercase">
                Request Salary Increase
            </h1>
            <div class="bg-transparant p-3 rounded-xl flex justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                    <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" />
                </svg>
            </div>
        </div>
        <div class="bg-secondary w-full h-full flex flex-col items-center overflow-x-auto p-20 rounded-lg justify-center">
                <div class="w-full mt-4">
                    <label class="text-primary" for="employee_id">Employee</label>
                    <p class="bg-tertiary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4">
                        {{ $payrolluser->firstname }} {{ $payrolluser->lastname }}
                    </p>
                </div>
                <div class="w-full flex">
                    <div class="w-1/2 mt-4 pr-5">
                        <label class="text-primary" for="employee_id">Salary Amount</label>
                        <p class="bg-tertiary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4">
                            Rp. {{ number_format($payrolluser->salary_amount, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-1/2 mt-4">
                        <label class="text-primary" for="request_amount">Requested Amount</label>
                        <p class="bg-tertiary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4">
                            Rp. {{ number_format($payrolluser->request_amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            <form method="post" action="/PayrollandBenefit/accept/{{ $id }}" class="w-full">
                @csrf
                <div class="flex flex-row">
                    <button class="btn w-full py-3 px-6 gradcolor text-white rounded-md mt-8 mr-5">
                        Accept
                    </button>
                    <button name='deciline' class="btn w-full py-3 px-6 gradcolor text-white rounded-md mt-8">
                        Decline
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection