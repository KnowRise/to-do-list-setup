@extends('layouts.main')
@section('title', 'Detail Job')

@section('content')
    @if (Session::has('message') || $errors->any())
        @include('templates.modalMessage')
    @endif
    <div class="flex flex-col gap-[16px] h-screen overflow-hidden">
        @include('templates.navbar.main')
        <div class="flex flex-col gap-[16px] justify-center items-center h-full p-[32px]">
            <div class="flex w-full min-h-fit border px-[16px] rounded-[16px]">
                <h1 class="text-[32px] font-bold">INI DETAIL JOB</h1>
            </div>
            <div class="flex border w-full max-h-[70vh] min-h-full rounded-[16px] overflow-hidden">
                <div class="flex flex-col w-1/3 border-r px-[16px] pb-[16px] overflow-auto">
                    @if (auth()->user()->id == $job->user_id)
                        <div class="flex justify-between w-full border-b overflow-hidden min-h-fit py-[4px] px-[16px]">
                            <a href="{{ route('jobs.newTask', ['id' => $job->id]) }}"
                                class="border py-[4px] px-[16px] rounded-[8px]">New Task</a>
                        </div>
                    @endif
                    <div class="flex justify-between w-full border-b overflow-hidden min-h-fit py-[4px] px-[16px]">
                        <p class="text-[32px] font-bold">Task List</p>
                    </div>
                    @foreach ($tasks as $task)
                        <div class="flex w-full border-b overflow-hidden min-h-fit">
                            <div class="flex px-[16px] items-center flex-grow border-r overflow-hidden">
                                <h1 class="truncate">{{ $task->title }}</h1>
                            </div>
                            <div class="flex gap-[8px] min-w-fit py-[4px] px-[16px]">
                                @if (auth()->user()->role == 'worker')
                                    <form action="{{ route('tasks.detailUserTask', ['id' => $task->id]) }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <button type="submit">
                                            <img src="{{ asset('icons/info.svg') }}" alt="Detail Task" width="30"
                                                height="30">
                                        </button>
                                    </form>
                                @endif
                                @if (auth()->user()->role == 'tasker')
                                    <a href="{{ route('tasks.detail', ['id' => $task->id]) }}">
                                        <img src="{{ asset('icons/info.svg') }}" alt="Detail Task" width="30"
                                            height="30">
                                    </a>
                                @endif
                                @if (auth()->user()->id == $job->user_id)
                                    <form action="{{ route('backend.tasks.delete', ['id' => $task->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are You Sure want delete this Task?')">
                                            <img src="{{ asset('icons/delete_red.svg') }}" alt="Delete Task" width="30"
                                                height="30">
                                        </button>
                                    </form>
                                @endif
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
                            @if (auth()->user()->id == $job->user_id)
                                <form action="{{ route('backend.jobs.delete', ['id' => $job->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are You Sure want delete this Job?')">
                                        <img src="{{ asset('icons/delete_red.svg') }}" alt="Delete Job" width="35"
                                            height="35">
                                    </button>
                                </form>
                                <form action="{{ route('jobs.storeJob', ['id' => $job->id]) }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="edit" value="true">
                                    <button>
                                        <img src="{{ asset('icons/edit.svg') }}" alt="Edit Job" width="35"
                                            height="30">
                                    </button>
                                </form>
                            @endif
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
