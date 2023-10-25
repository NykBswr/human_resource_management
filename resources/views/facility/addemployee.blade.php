@extends('layout.main')

@section('container')


<section class="w-full h-screen py-10 px-10 flex items-center justify-center">
    <div class="w-[30%] h-5/6 bg-tertiary py-8 px-8 rounded-2xl flex flex-col items-center">
        <div class="w-full flex items-center justify-center mb-5">
            <div class="gradcolor p-3 rounded-xl flex justify-start">
                <a href="/facility?type_filter=employee">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                        <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" fill="white"/>
                    </svg>
                </a>
            </div>
            <h1 class="w-full text-2xl text-center text-primary flex justify-center uppercase">
                Add or Delete <br>Employee Facility
            </h1>
            <div class="bg-transparant p-3 rounded-xl flex justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                    <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" />
                </svg>
            </div>
        </div>
        <div class="bg-secondary w-full h-full flex flex-col items-center overflow-x-auto p-20 rounded-lg justify-center">
            <form method="post" action="/facility/addemployee" class="w-full" enctype="multipart/form-data">
                @csrf
                <div class="w-full mt-4">
                    <label class="text-primary" for="facility_id">Facility</label>
                    <select class="bg-tertiary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3" name="facility_id">
                        <option selected disabled>Select Facility</option>
                        @foreach($facilityid as $facility)
                            <option value="{{ $facility->facility_id }}" {{ old('facility_id') == $facility->facility_id ? 'selected' : '' }}>{{ $facility->facility_name }}</option>
                        @endforeach
                    </select>
                    @error('employee')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full mt-4">
                    <label class="text-primary" for="employee_id">Employee</label>
                    <select class="bg-tertiary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3" name="employee_id">
                        <option selected disabled>Select Employee</option>
                        @foreach($employeeid as $employee)
                            <option value="{{ $employee->employee_id }}" {{ old('employee') == $employee->employee_id ? 'selected' : '' }}>{{ $employee->firstname }} {{ $employee->lastname }}</option>
                        @endforeach
                    </select>
                    @error('employee')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-row">
                    <button class="btn w-full py-3 px-6 gradcolor text-white rounded-md mt-8 mr-5">
                        Add
                    </button>
                    <button class="btn w-full py-3 px-6 gradcolor text-white rounded-md mt-8" name="delete">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection