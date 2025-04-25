@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
    @if (Session::has('message') || $errors->any())
        @include('templates.modalMessage')
    @endif
    <div class="flex flex-col h-screen overflow-hidden">
        @include('templates.navbar.main')
        <div class="flex flex-col border max-h-full h-full overflow-hidden">
            <div class="flex justify-end min-w-fit p-[32px]">
                @if (isset($jobs))
                    <button class="flex items-center">
                        <img src="{{ asset('icons/add.svg') }}" alt="New Job" class="btnNewJob">
                    </button>
                @else
                    <button>
                        <img src="{{ asset('icons/add.svg') }}" alt="New User" class="btnStoreUser">
                    </button>
                @endif
            </div>
            @if (isset($jobs))
                <div class="grid grid-cols-3 gap-[32px] w-full p-[32px] max-h-full overflow-auto">
                    @foreach ($jobs as $job)
                        <a href="{{ route('jobs.detail', ['id' => $job->id]) }}">
                            <div
                                class="flex flex-col p-[16px] border items-center rounded-[16px] h-fit min-h-[10vh] max-h-[30vh] overflow-auto hover:bg-[#3D90D7] hover:text-[#eeeeee] shadow-[5px_10px_10px_0px_rgba(0,0,0,0.25)]">
                                <h1 class="text-[32px] font-bold">{{ $job->title }}</h1>
                                <p class="text-[20px]">{{ $job->description }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
            @if (isset($users))
                <div class="flex flex-col w-full justify-center items-center p-[32px]">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex w-full py-[16px] gap-[16px]">
                        @csrf
                        <input type="text" name="search" id="search"
                            class="border rounded-[8px] py-[4px] px-[16px] text-[20px] w-full" placeholder="Search User">
                        <button type="submit" class="w-fit py-[4px] px-[16px] border rounded-[8px]">
                            Search
                        </button>
                    </form>
                    <table class="border w-full">
                        <thead>
                            <tr class="bg-gray-300">
                                <th class="py-[4px] px-[8px] text-center text-[24px]">Username</th>
                                <th class="py-[4px] px-[8px] text-center text-[24px]">Role</th>
                                <th class="py-[4px] px-[8px] text-center text-[24px]">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border">
                                    <td class="py-[4px] px-[8px] text-center text-[20px]">{{ $user->username }}</td>
                                    <td class="py-[4px] px-[8px] text-center text-[20px]">{{ $user->role }}</td>
                                    <td class="flex justify-center items-center gap-[16px] py-[4px]">
                                        <button class="btnStoreUser" data-user-id="{{ $user->id }}"
                                            data-username="{{ $user->username }}" data-role="{{ $user->role }}">
                                            <img src="{{ asset('icons/edit.svg') }}" alt="Edit" width="30px"
                                                height="30px">
                                        </button>
                                        <form action="{{ route('backend.users.delete', ['id' => $user->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure want to delete this user?')">
                                                <img src="{{ asset('icons/delete_red.svg') }}" alt="Delete"
                                                    width="30px" height="30px">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if ($users->hasPages())
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="py-[4px] px-[8px] text-center">
                                        {{ $users->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            @endif
        </div>
    </div>
    @include('pages.dashboard.modalStoreUser')
    @include('pages.dashboard.modalStoreJob')
@endsection
