@extends('layouts.main')
@section('title', 'Detail Task')

@section('content')
    @if (Session::has('message') || $errors->any())
        @include('templates.modalMessage')
    @endif

    <div class="flex flex-col h-screen overflow-hidden">
        @include('templates.navbar.main')

        <div class="flex flex-col flex-1 p-8 gap-8 overflow-hidden">

            <!-- Header -->
            <div class="flex items-center justify-between w-full border rounded-2xl p-6 shadow-sm">
                <h1 class="text-3xl font-bold">Detail Task</h1>

                <div class="flex gap-4">
                    <form action="{{ route('backend.tasks.delete', ['id' => $task->id]) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this Task?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Hapus Task
                        </button>
                    </form>
                    <button type="button"
                        class="btnStoreTask px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                        Edit Task
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex flex-1 gap-8 overflow-hidden">
                <!-- Task Detail -->
                <div class="flex flex-col flex-1 border rounded-2xl overflow-auto p-8 shadow-sm gap-4">
                    <div class="flex justify-start">
                        <a href="{{ route('jobs.detail', ['id' => $task->job_id]) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Kembali
                        </a>
                    </div>

                    <div class="flex flex-col gap-4">
                        <h1 class="text-3xl font-bold text-center">{{ $task->title }}</h1>
                        <p class="text-justify">
                            {{ $task->description }}
                        </p>
                    </div>
                </div>

                <!-- User Task List -->
                <div class="flex flex-col w-2/3 border rounded-2xl overflow-hidden shadow-sm">
                    <div
                        class="bg-gray-700 p-4 text-xl font-semibold border-b text-white flex justify-between items-center">
                        <p>List User</p>
                        <button onclick="openModalStoreUser({{ $task->id }}, {{ $task->job_id }})"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-[16px] transition">
                            + Assign New User
                        </button>
                    </div>

                    <div class="flex flex-col overflow-auto">
                        @foreach ($task->userTasks as $userTask)
                            <div class="flex items-center justify-between p-4 border-b hover:bg-gray-400 transition">
                                <div class="flex-1 truncate">
                                    {{ $userTask->user->username }}
                                </div>

                                <div class="flex items-center gap-2 ml-4">
                                    <button type="button" data-user-task='@json($userTask)' class="btnModalDetailUserTask">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                        </svg>
                                    </button>

                                    <form action="{{ route('backend.tasks.users.delete', ['id' => $userTask->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete assigned user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>

        </div>
    </div>
    @include('pages.detail.tasks.modalStoreTask')
    @include('pages.detail.tasks.modalDetailUserTask')
    @include('pages.detail.tasks.modalNewUser')
    @include('pages.detail.tasks.modalAnotherTask')
@endsection
