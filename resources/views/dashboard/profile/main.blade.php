@extends('layout.main')

@section('container')

<section class="w-full h-screen py-8 px-8 flex items-center">
    <div class="w-full h-full bg-tertiary py-8 px-8 rounded-2xl flex flex-col items-center">
        <div class="w-full flex items-center justify-center mb-5">
            <div class="gradcolor p-3 rounded-xl flex justify-start">
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
        <div class="w-full h-[90%] bg-dark rounded-2xl flex flex-col items-center justify-center py-8 px-20">
            <div class="w-full h-full overflow-auto">
                <form method="post" action="/profile/{{ $employee->id }}" enctype="multipart/form-data" id="imageForm">
                    @method('put')
                    @csrf
                    <div class="flex flex-col items-center justify-center">
                        @if ($employee->image == 'logo-white.svg')
                            <img src="{{ URL::asset('img/logo-white.svg') }}" class="img-preview w-20 lg:w-40 h-20 lg:h-40 rounded-full border border-primary mb-8">
                            <input type="file" name="newImage" class="hidden" id="image" onchange="previewImage()" accept="image/jpeg, image/png, image/bmp, image/gif, image/svg+xml, image/webp">
                            <div class="z-1 ml-24 -mt-16">
                                <label for="image" class="cursor-pointer flex justify-center items-center">
                                    <span class="w-10 h-10 gradcolor p-2 rounded-full hover:bg-opacity-50">
                                        <img src="{{ URL::asset('img/edit-profile.svg') }}" class=" w-full h-full">
                                    </span>
                                </label>
                            </div>
                        @elseif ($employee->image != 'img/logo-white.svg')
                            <img src="{{ asset('storage/post-images/' . $employee->image) }}" class="img-preview w-20 lg:w-40 h-20 lg:h-40 rounded-full border border-primary mb-8">
                            <input type="file" name="newImage" class="hidden" id="image" onchange="previewImage()" accept="image/jpeg, image/png, image/bmp, image/gif, image/svg+xml, image/webp">
                            <div class="z-1 ml-24 -mt-16">
                                <label for="image" class="cursor-pointer flex justify-center items-center">
                                    <span class="w-10 h-10 gradcolor p-2 rounded-full hover:bg-opacity-50">
                                        <img src="{{ URL::asset('img/edit-profile.svg') }}" class=" w-full h-full">
                                    </span>
                                </label>
                            </div>
                        @endif
                    </div>
                    <input type="hidden" name="oldImage" value="{{ $employee->image }}">
                    <input type="text" class="text-primary bg-transparent" disabled name="image" value="{{ old('image') }}">
                </form>
                <!-- JavaScript to automatically submit the form when an image is selected -->
                <script>
                    document.getElementById('image').addEventListener('change', function () {
                        document.getElementById('imageForm').submit();
                    });
                </script>
                <div class="w-full flex">
                    <div class="w-1/2 pr-5">
                        <label class="text-primary" for="firstname">First Name</label>
                        <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4 mr-5" name="firstname"
                            value="{{ old('firstname', $employee->firstname) }}" readonly disabled/>
                    </div>
                    <div class="w-1/2">
                        <label class="text-primary" for="lastname">Last Name</label>
                        <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4 mr-5" name="lastname"
                            value="{{ old('lastname', $employee->lastname) }}" readonly disabled/>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="w-1/2 pr-5">
                        <label class="text-primary" for="username">Username</label>
                        <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="username"
                            value="{{ old('username', $employee->username) }}" readonly disabled/>
                    </div>
                    <div class="w-1/2">
                        <label class="text-primary" for="email">Email</label>
                        <input type="Email" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" id="email"
                            name="email" value="{{ old('email', $employee->email) }}" readonly disabled/>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="w-1/2 pr-5">
                        <label class="text-primary" for="role">Role</label>
                        <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" id="role"
                            name="role" value="{{ old('role', $employee->role) }}" readonly disabled/>
                    </div>
                    <div class="w-1/2">
                        <label class="text-primary" for="position">Position</label>
                        <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" id="position"
                            name="position" value="{{ old('position', $employee->position) }}" readonly disabled/>
                    </div>
                </div>
                {{-- <form action="">
                    <div class="w-full flex flex-col justify-center items-center mt-4">
                        <label class="text-primary rounded-md" for="password">Change Password</label>
                        <input type="password" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 px-6 py-3 mb-4" id="password"
                            name="password" value="{{ old('password', $employee->password) }}"/>
                        <button class="btn py-3 px-6 gradcolor text-white rounded-md">
                            Update Password
                        </button>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
</section>

<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const reader = new FileReader();
        reader.readAsDataURL(image.files[0]);

        reader.onload = function(event) {
            imgPreview.src = event.target.result;
        }
    }
</script>
@endsection