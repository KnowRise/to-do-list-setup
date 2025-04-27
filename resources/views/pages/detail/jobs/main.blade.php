@extends('layouts.main')
@section('title', 'Detail Job')

@section('content')
    @if (Session::has('message') || $errors->any())
        @include('templates.modalMessage')
    @endif

    <div class="flex flex-col h-screen overflow-hidden">
        @include('templates.navbar.main')

        <div class="flex flex-col flex-1 p-8 gap-8 overflow-hidden">

            <!-- Header -->
            <div class="flex items-center justify-between w-full border rounded-2xl p-6 shadow-sm">
                <h1 class="text-3xl font-bold">Detail Job</h1>

                @if (auth()->user()->id == $job->user_id)
                    <div class="flex gap-4">
                        <button class="btnStoreTask px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">+
                            Task Baru</button>
                        <form action="{{ route('backend.jobs.delete', ['id' => $job->id]) }}" method="POST"
                            onsubmit="return confirm('Yakin mau hapus job ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Hapus Job
                            </button>
                        </form>
                        <button class="btnStoreJob px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"
                            data-title="{{ $job->title }}" data-description="{{ $job->description }}"
                            data-job-id="{{ $job->id }}">
                            Edit Job
                        </button>
                    </div>
                @endif
            </div>

            <!-- Content -->
            <div class="flex flex-1 gap-8 overflow-hidden">

                <!-- Task List -->
                <div class="flex flex-col w-1/3 border rounded-2xl overflow-hidden shadow-sm">
                    <div class="bg-gray-700 p-4 text-xl font-semibold border-b">
                        List Task
                    </div>

                    <div class="flex flex-col overflow-auto">
                        @foreach ($tasks as $task)
                            <div class="flex items-center justify-between p-4 border-b hover:bg-gray-400 transition">
                                <div class="flex-1 truncate">
                                    {{ $task->title }}
                                </div>
                                <div class="flex items-center gap-2 ml-4">
                                    @if (auth()->user()->role == 'worker')
                                        <button type="button" data-user-task='@json($task->userTaskFor(auth()->user()->id))' class="btnModalDetailUserTask">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                            </svg>
                                        </button>
                                    @endif

                                    @if (auth()->user()->role == 'tasker')
                                        <a href="{{ route('tasks.detail', ['id' => $task->id]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                            </svg>
                                        </a>
                                    @endif

                                    @if (auth()->user()->id == $job->user_id)
                                        <form action="{{ route('backend.tasks.delete', ['id' => $task->id]) }}" method="POST"
                                            onsubmit="return confirm('Yakin mau hapus task ini?')" class="flex items-center">
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
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Job Detail -->
                <div class="flex flex-col w-2/3 border rounded-2xl p-8 overflow-auto shadow-sm">

                    <!-- Back Button -->
                    <div class="flex justify-start mb-6">
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Kembali
                        </a>
                    </div>

                    <h2 class="text-4xl font-bold text-center mb-4">{{ $job->title }}</h2>
                    <p class="leading-relaxed text-justify">{{ $job->description }}</p>

                </div>
            </div>

        </div>
    </div>
    @include('pages.detail.jobs.modalNewTask')
    @include('pages.detail.jobs.modalStoreJob')
    @include('pages.detail.tasks.modalDetailUserTask')
@endsection
