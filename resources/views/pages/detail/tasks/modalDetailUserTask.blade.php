@extends('layouts.main')
@section('title', 'Modal Detail User Task')

@section('content')
    <div class="absolute inset-0 z-1 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] flex justify-center items-center">
        <div
            class="flex flex-col justify-center items-center gap-[16px] max-w-[75vh] max-h-[60vh] min-w-[50vh] min-h-fit border p-[32px] rounded-[16px] bg-[#eeeeee]">
            <div class="flex justify-end w-full">
                @if (auth()->user()->role == 'worker')
                    <a href="{{ route('jobs.detail', ['id' => $task->job_id]) }}"
                        class="text-[32px] font-bold cursor-pointer hover:text-[#C5172E]">X</a>
                @else
                    <a href="{{ route('tasks.detail', ['id' => $task->id]) }}"
                        class="text-[32px] font-bold cursor-pointer hover:text-[#C5172E]">X</a>
                @endif
            </div>
            <h1 class="text-[32px] font-bold">{{ $userTask->user->username }}</h1>
            <p>Status: {{ $userTask->status }}</p>
            @if (auth()->user()->role == 'worker')
                @if ($userTask->status == 'completed' || $userTask->status == 'approved' || $userTask->status == 'rejected')
                    <p>Completed At: {{ $userTask->completed_at }}</p>
                    <a href="{{ asset('storage/' . $userTask->file_path) }}" target="_blank"> Click to see File Uploaded</a>
                    @if ($userTask->status != 'completed')
                        <p>{{ $userTask->feedback }}</p>
                    @endif
                @else
                    <form action="{{ route('backend.tasks.submit', ['id' => $userTask->id]) }}" method="POST"
                        enctype="multipart/form-data" class="flex gap-[16px]">
                        @csrf
                        <div class="flex">
                            <input type="file" id="file" name="file" accept=".jpg, .png, .svg, .jpeg"
                                class="border py-[4px] px-[16px] hidden">
                            <label for="file" class="flex items-center cursor-pointer">
                                <img src="{{ asset('icons/upload_file.svg') }}" alt="Upload File" width="30"
                                    height="30">
                                <p>Upload File Here</p>
                            </label>
                        </div>
                        <button class="border py-[4px] px-[16px] rounded-[8px]">Submit</button>
                    </form>
                @endif
            @endif
            @if (auth()->user()->role == 'tasker')
                @if ($userTask->status == 'completed' || $userTask->status == 'approved' || $userTask->status == 'rejected')
                    @if ($userTask->status != 'completed')
                        <p>Feedback: {{ $userTask->feedback }}</p>
                    @endif
                    <p>{{ $userTask->completed_at }}</p>
                    <a href="{{ asset('storage/' . $userTask->file_path) }}" target="_blank">File Uploaded</a>
                    <div class="flex gap-[16px] w-full border rounded-[8px] py-[8px] px-[16px]">
                        <form action="{{ route('backend.tasks.users.status', ['id' => $userTask->id]) }}" method="POST"
                            class="flex flex-col w-full gap-[16px]">
                            @csrf
                            <label for="feedback">Feedback</label>
                            <textarea name="feedback" id="feedback" rows="3" class="border rounded-[8px] py-[4px] px-[16px]"
                                placeholder="Type Feedbak Here"></textarea>
                            <select name="status" id="status" class="border rounded-[8px] py-[4px] px-[16px]">
                                <option value="rejected">Reject</option>
                                <option value="approved">Approve</option>
                            </select>
                            <button type="submit" onclick="return confirm('Are You Sure?')"
                                class="border py-[4px] px-[16px] rounded-[8px]">Submit</button>
                        </form>
                    </div>
                @endif
            @endif
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
                        <a href="{{ route('tasks.newUser', ['id' => $task->id]) }}"
                            class="border py-[4px] px-[16px] rounded-[8px]">New User</a>
                    </div>
                    @foreach ($task->userTasks as $userTask)
                        <div class="flex w-full border-b overflow-hidden min-h-fit">
                            <div class="flex px-[16px] items-center flex-grow border-r overflow-hidden">
                                <h1 class="truncate">{{ $userTask->user->username }}</h1>
                            </div>
                            <div class="flex gap-[8px] min-w-fit py-[4px] px-[16px]">
                                <a href="">
                                    <img src="{{ asset('icons/info.svg') }}" alt="Detail Task" width="30"
                                        height="30">
                                </a>
                                <form action="{{ route('backend.tasks.users.delete', ['id' => $userTask->id]) }}"
                                    method="POST" class="flex items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are You Sure want delete Assign User?')">
                                        <img src="{{ asset('icons/delete_red.svg') }}" alt="Delete Task" width="30"
                                            height="30">
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col w-2/3 p-[32px]">
                    <div class="flex w-full justify-between gap-[8px]">
                        <a href="{{ route('jobs.detail', ['id' => $task->job_id]) }}">
                            <img src="{{ asset('icons/arrow_back.svg') }}" alt="Back" width="35" height="35">
                        </a>
                        <div class="flex gap-[8px]">
                            <form action="{{ route('backend.tasks.delete', ['id' => $task->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are You Sure want delete this Task?')">
                                    <img src="{{ asset('icons/delete_red.svg') }}" alt="Delete Task" width="35"
                                        height="35">
                                </button>
                            </form>
                            <form action="{{ route('tasks.storeTask', ['id' => $task->id]) }}" method="GET">
                                @csrf
                                <input type="hidden" name="edit" value="true">
                                <button>
                                    <img src="{{ asset('icons/edit.svg') }}" alt="Edit Task" width="35" height="30">
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="flex flex-col gap-[16px]">
                        <h1 class="text-[32px] font-bold text-center w-full">{{ $task->title }}</h1>
                        <p class="text-justify">{{ $task->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
