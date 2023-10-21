@extends('layout.main')

@section('container')

<section class="w-full h-screen py-8 px-8 flex items-center">
    <div class="w-full h-full bg-tertiary py-8 px-8 rounded-2xl flex flex-col items-center">
        <div class="w-full flex items-center justify-center mb-5">
            <div class="gradcolor p-3 rounded-xl flex justify-start">
                <a href="/task">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                        <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" fill="white"/>
                    </svg>
                </a>
            </div>
            <h1 class="w-full text-2xl text-center text-primary flex justify-center uppercase">
                Contents of TASK
            </h1>
            <div class="bg-transparant p-3 rounded-xl flex justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 37 24" fill="none">
                    <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.807612 11.0711 0.807612 10.4853 1.3934L0.93934 10.9393ZM2 13.5H37V10.5H2V13.5Z" />
                </svg>
            </div>
        </div>
        <div class="w-full h-[90%] bg-dark rounded-2xl flex flex-col items-center justify-center py-8 px-20">
            <div class="w-full flex">
                <div class="w-1/2 pr-2">
                    <label class="text-primary" for="firstname">First Name</label>
                    <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="firstname"
                        value="{{ $task->firstname }}" readonly="readonly" disabled="disabled" />
                </div>
                <div class="w-1/2">
                    <label class="text-primary" for="lastname">Last Name</label>
                    <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="lastname"
                        value="{{ $task->lastname }}" readonly="readonly" disabled="disabled" />
                </div>
            </div>
            <div class="w-full">
                <label class="text-primary" for="task">Task</label>
                <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="taskname"
                    value="{{ $task->taskname }}" readonly="readonly" disabled="disabled" />
            </div>
            <div class="w-full ">
                <label class="text-primary" for="task">Task Description</label>
                <div class="flex">
                    <input type="text" class="bg-secondary rounded-md text-primary flex flex-start gap-3 mt-4 w-full px-6 py-3 mb-4" name="taskdescriptions"
                    value="{{ $task->taskdescriptions }}" readonly="readonly" disabled="disabled" />
                    <a class="gradcolor rounded-md text-primary flex justify-center gap-3 mt-4 w-1/4 px-6 py-3 mb-4" href="{{'/storage/filetask/' . $task->file }}">Download Task</a>
                </div>
                @error('task')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</section>