@extends('layout.main')

@section('container')

<section class="w-full h-screen py-8 px-8 flex items-center justify-center">
    <div class="w-5/6 h-full bg-tertiary py-8 px-8 rounded-2xl flex flex-col items-center">
        <div class="w-full flex items-center justify-center mb-5">
            <div class="gradcolor p-3 rounded-xl flex justify-start">
                <a href="/offdays">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                        <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" fill="white"/>
                    </svg>
                </a>
            </div>
            <h1 class="w-full text-2xl text-center text-primary flex justify-center uppercase">
                Submit Application for Off Days
            </h1>
            <div class="bg-transparant p-3 rounded-xl flex justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                    <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" />
                </svg>
            </div>
        </div>
        <div class="w-full h-full bg-dark rounded-2xl flex flex-col items-center justify-center py-16 px-20 overflow-auto">
            <div class="w-full h-full">
                <div class="w-full h-full px-2">
                    <form action="/addoffdays" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="w-full mt-4">
                            <label class="text-primary" for="employee_id">Employee</label>
                            @if (auth()->user()->role != 3)
                                <p class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4">
                                    {{ $employeeid->firstname }} {{ $employeeid->lastname }}
                                </p>
                                <input type="hidden" name="employee_id" value="{{ $employeeid->employee_id }}">
                            @else
                                <select class="bg-tertiary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3" name="employee_id">
                                    <option value="" selected disabled>Select Employee</option>
                                    @foreach($employeeid as $employee)
                                        <option value="{{ $employee->employee_id }}" {{ old('employee') == $employee->employee_id ? 'selected' : '' }}>
                                            {{ $employee->firstname }} {{ $employee->lastname }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            @error('employee')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full mt-4">
                            <label class="text-primary" for="reason">Reason</label>
                            <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="reason" required>
                            @error('reason')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="w-full flex flex-row">
                            <div class="w-full mt-4 pr-5">
                                <label class="text-primary" for="start">From</label>
                                <input type="date" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="start" required>
                                @error('start')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-full mt-4">
                                <label class="text-primary" for="end">To</label>
                                <input type="date" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="end" required>
                                @error('end')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full flex justify-center mt-4">
                            <div class="m-2 w-full">
                                <label class="inline-block mb-2 text-primary">Upload Additional Information (pdf, doc, docx, png, jpg)</label>
                                <div class="flex items-center justify-center w-full">
                                    <label class="bg-secondary flex flex-col w-full h-32 border-4 border-dashed hover:bg-dark hover:border-gray-300">
                                        <div class="flex flex-col items-center justify-center pt-7">
                                            <img id="file-icon" class="w-12 h-12 text-gray-400 group-hover:text-dark" src="{{ URL::asset('img/default-icon.svg') }}" alt="File Icon">
                                            <p id="file-label" class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-dark">
                                                Select a file
                                            </p>
                                        </div>
                                        <input type="file" name="info" class="opacity-0" id="file-input" onchange="displayFileNameAndIcon()">
                                    </label>
                                </div>
                                @error('info')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                                <script>
                                    function displayFileNameAndIcon() {
                                        const fileInput = document.getElementById("file-input");
                                        const fileLabel = document.getElementById("file-label");
                                        const fileIcon = document.getElementById("file-icon");

                                        if (fileInput.files.length > 0) {
                                            const fileName = fileInput.files[0].name;
                                            const fileExtension = fileName.split('.').pop().toLowerCase();

                                            fileLabel.textContent = fileName;

                                            // Replace the icon based on the file extension
                                            if (fileExtension === "pdf") {
                                                fileIcon.src = "{{ URL::asset('img/pdflogo.png') }}";
                                            } else if (fileExtension === "doc" || fileExtension === "docx") {
                                                fileIcon.src = "{{ URL::asset('img/docslogo.png') }}";
                                            } else if (fileExtension === "png" || fileExtension === "jpg") {
                                                fileIcon.src = "{{ URL::asset('img/docslogo.png') }}";
                                            } else {
                                                // Use a default icon if the format is not recognized
                                                fileIcon.src = "{{ URL::asset('img/default-icon.svg') }}";
                                            }
                                        } else {
                                            fileLabel.textContent = "Select a file";
                                            fileIcon.src = "{{ URL::asset('img/default-icon.svg') }}";
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <button class="mb-10 btn w-full py-3 px-6 gradcolor text-white rounded-md mt-4">
                            Submit Application
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection