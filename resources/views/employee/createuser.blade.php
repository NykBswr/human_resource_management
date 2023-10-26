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
                Create User
            </h1>
            <div class="bg-transparant p-3 rounded-xl flex justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                    <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" />
                </svg>
            </div>
        </div>
        <div class="w-full h-[90%] bg-dark rounded-2xl flex flex-col items-center justify-center py-16 px-20 ">
            <div class="w-full h-auto overflow-auto">
                <div class="w-full h-full px-2">
                    <form action="/adduser" method="post">
                        @csrf
                        <div class="w-full flex">
                            <div class="w-1/2 pr-5">
                                <label class="text-primary" for="firstname">First Name</label>
                                <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4 mr-5" name="firstname"
                                    value="{{ old('firstname') }}" required/>
                            </div>
                            <div class="w-1/2">
                                <label class="text-primary" for="lastname">Last Name</label>
                                <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4 mr-5" name="lastname"
                                    value="{{ old('lastname') }}" required/>
                            </div>
                        </div>
                        <div class="w-full pr-5">
                            <label class="text-primary" for="username">Username</label>
                            <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="username"
                                value="{{ old('username') }}" required/>
                        </div>
                        <div class="w-full">
                            <label class="text-primary" for="email">Email</label>
                            <input type="Email" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" id="email"
                                name="email" value="{{ old('email') }}" required/>
                        </div>
                        <div class="w-full flex">
                            <div class="w-1/2 pr-5">
                                <label class="text-primary" for="role">Role</label>
                                <select class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3" name="role" required>
                                    <option selected disabled>Select Role</option>
                                    <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Employee</option>
                                    <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Manager</option>
                                </select>
                                @error('role')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-1/2">
                                <label class="text-primary" for="position">Position</label>
                                <select class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3" name="position" required>
                                    <option selected disabled>Select Position</option>
                                    <option value="0" {{ old('position') == '0' ? 'selected' : '' }}>Business Analysis</option>
                                    <option value="1" {{ old('position') == '1' ? 'selected' : '' }}>Data Analyst</option>
                                    <option value="2" {{ old('position') == '2' ? 'selected' : '' }}>Data Scientist</option>
                                    <option value="3" {{ old('position') == '3' ? 'selected' : '' }}>Teller</option>
                                    <option value="4" {{ old('position') == '4' ? 'selected' : '' }}>Auditor</option>
                                    <option value="5" {{ old('position') == '5' ? 'selected' : '' }}>Staff</option>
                                    <option value="6" {{ old('position') == '6' ? 'selected' : '' }}>Sales</option>
                                    <option value="7" {{ old('position') == '7' ? 'selected' : '' }}>Akuntan</option>
                                    <option value="8" {{ old('position') == '8' ? 'selected' : '' }}>CS</option>
                                    
                                </select>
                                @error('position')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full pr-5 mt-4">
                            <label class="text-primary" for="password">Password</label>
                            <input type="password" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="password" required/>
                            @error('password')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="text-primary" for="password_confirmation">Confirm Password</label>
                        <input type="password" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="password_confirmation" required/>
                        @error('password_confirmation')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <button class="btn w-full py-3 px-6 gradcolor text-white rounded-md mt-5">
                            Add User
                        </button>
                    </form>
                    {{-- End form --}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection