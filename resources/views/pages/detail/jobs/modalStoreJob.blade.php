@extends('layouts.main')
@section('title', 'Detail Job')

@section('content')
    <div class="absolute inset-0 z-1 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] flex justify-center items-center">
        <div
            class="flex flex-col justify-center items-center gap-[16px] max-w-[75vh] max-h-[60vh] min-w-[50vh] min-h-fit border p-[32px] rounded-[16px] bg-[#eeeeee]">
            <div class="flex justify-end w-full">
                <a href="{{ route('jobs.detail', ['id' => $job->id]) }}" class="text-[32px] font-bold cursor-pointer hover:text-[#C5172E]">X</a>
            </div>
            <h1 class="text-[32px] font-bold">Store Job</h1>
            <form id="formNewJob" action="{{ $edit ? route('backend.jobs.store', ['id' => $job->id]) : route('backend.jobs.store') }}" method="POST"
                class="flex flex-col gap-[16px] w-full">
                @csrf
                <div class="flex flex-col gap-[8px]">
                    <label for="title" class="text-[20px]">Title:</label>
                    <input type="text" name="title" id="title" placeholder="Input Title"
                        class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full" value="{{ $edit ? $job->title : '' }}"
                        required>
                </div>
                <div class="flex flex-col gap-[8px]">
                    <label for="description" class="text-[20px]">Description:</label>
                    <textarea type="text" name="description" id="description" placeholder="Input Description"
                        class="inputPassword text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full">{{ $edit ? $job->description : '' }}</textarea>
                </div>
                <button
                    class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full bg-[#3D90D7] text-[#eeeeee] font-bold hover:bg-[#3A59D1] cursor-pointer">Submit</button>
            </form>
        </div>
    </div>




    @if (Session::has('message') || $errors->any())
        @include('templates.modalMessage')
    @endif
    <div class="flex flex-col h-screen overflow-hidden">
        @include('templates.navbar.main')
        <div class="flex justify-center items-center h-full p-[32px]">
            <div class="flex border w-full max-h-[80vh] min-h-full rounded-[16px] overflow-hidden">
                <div class="flex flex-col w-1/3 border-r px-[16px] pb-[16px] overflow-auto">
                    <div class="flex justify-between w-full border-b overflow-hidden min-h-fit py-[4px] px-[16px]">
                        <a href="{{ route('jobs.newTask', ['id' => $job->id]) }}"
                            class="border py-[4px] px-[16px] rounded-[8px]">New Task</a>
                    </div>
                    @foreach ($job->tasks as $task)
                        <div class="flex w-full border-b overflow-hidden min-h-fit">
                            <div class="flex px-[16px] items-center flex-grow border-r overflow-hidden">
                                <h1 class="truncate">{{ $task->title }}</h1>
                            </div>
                            <div class="flex gap-[8px] min-w-fit py-[4px] px-[16px]">
                                <button>
                                    <img src="{{ asset('icons/info.svg') }}" alt="Detail Task" width="30"
                                        height="30">
                                </button>
                                <button>
                                    <img src="{{ asset('icons/delete_red.svg') }}" alt="Delete Task" width="30"
                                        height="30">
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col w-2/3 p-[32px]">
                    <div class="flex w-full justify-between gap-[8px]">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('icons/arrow_back.svg') }}" alt="Back" width="35" height="35">
                        </a>
                        <div class="flex gap-[8px]">
                            <button>
                                <img src="{{ asset('icons/delete_red.svg') }}" alt="Delete Task" width="35"
                                    height="35">
                            </button>
                            <button>
                                <img src="{{ asset('icons/edit.svg') }}" alt="Delete Task" width="35" height="30">
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col gap-[16px]">
                        <h1 class="text-[32px] font-bold text-center w-full">{{ $job->title }}</h1>
                        <p class="text-justify">{{ $job->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
