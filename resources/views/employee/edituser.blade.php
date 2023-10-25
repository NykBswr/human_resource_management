@extends('layout.main')

@section('container')

<section class="w-full h-screen py-8 px-8 flex items-center">
    <div class="w-full h-full bg-tertiary py-8 px-8 rounded-2xl flex flex-col items-center">
        <div class="w-full flex items-center justify-center mb-5">
            <div class="gradcolor p-3 rounded-xl flex justify-start">
                <a href="/userlist">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                        <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" fill="white"/>
                    </svg>
                </a>
            </div>
            <h1 class="w-full text-2xl text-center text-primary flex justify-center uppercase">
                Edit User
            </h1>
            <div class="bg-transparant p-3 rounded-xl flex justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                    <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" />
                </svg>
            </div>
        </div>
        <div class="w-full h-[90%] bg-dark rounded-2xl flex flex-col items-center justify-center py-16 px-20">
            <div class="w-full h-auto overflow-auto">
                <div class="w-full h-full px-2">
                    <div class="flex w-full">
                        <div class="w-1/2 pr-5">
                            <label class="text-primary" for="firstname">First Name</label>
                            <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4 mr-5" name="firstname"
                                value="{{ old('firstname', $list->firstname) }}" readonly disabled/>
                        </div>
                        <div class="w-1/2">
                            <label class="text-primary" for="lastname">Last Name</label>
                            <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4 mr-5" name="lastname"
                                value="{{ old('lastname', $list->lastname) }}" readonly disabled/>
                        </div>
                    </div>
                    <form action="/userlist/updateuser/{{ $list->id }}" method="post">
                        @csrf
                        <div class="w-full flex">
                            <div class="w-1/2 pr-5">
                                <label class="text-primary" for="username">Username</label>
                                <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4 placeholder:text-primary" name="username" placeholder="{{ $list->username }}" value="{{ old('username')  }}"/>
                                @error('username')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-1/2">
                                <label class="text-primary" for="email">Email</label>
                                <input type="email" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4 placeholder:text-primary" name="email" placeholder="{{ $list->email }}" value="{{ old('email')  }}"/>
                                @error('email')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full mt-4">
                            <label class="text-primary" for="role">Role</label>
                            <select class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3" name="role">
                                <option value="0" {{ $list->role == '0' ? 'selected' : '' }}>Employee</option>
                                <option value="1" {{ $list->role == '1' ? 'selected' : '' }}>Manager</option>
                            </select>
                            @error('role')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @php
                            $positions = [
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
                        <div class="w-full mt-4">
                            <label class="text-primary" for="position">Position</label>
                            <select class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3" name="position">
                                @foreach($positions as $key => $value)
                                    <option value="{{ $key }}" {{ $list->position == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('position')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full pr-5 mt-4">
                            <label class="text-primary" for="password">Password</label>
                            <input type="password" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4 placeholder:text-primary" name="password" placeholder="**********"/>
                            @error('password')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="w-full pr-5">
                            <label class="text-primary" for="password_confirmation">Confirm Password</label>
                            <input type="password" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4 placeholder:text-primary" name="password_confirmation" placeholder="**********"/>
                            @error('password_confirmation')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="gradcolor w-full text-white rounded-lg py-2 px-4 mt-4">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection