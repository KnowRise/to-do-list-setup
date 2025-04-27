@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
    @if (Session::has('message') || $errors->any())
        @include('templates.modalMessage')
    @endif

    <div class="flex flex-col h-screen overflow-hidden bg-gray-900 text-gray-200">
        @include('templates.navbar.main')

        <div class="flex flex-col h-full overflow-hidden p-6 space-y-6">

            {{-- Tombol Tambah --}}
            <div class="flex justify-end">
                @if (isset($jobs))
                    <button
                        class="btnStoreJob flex items-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all btnNewJob">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="text-base font-semibold">Tambah Pekerjaan</span>
                    </button>
                @else
                    <button
                        class="flex items-center gap-2 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all btnStoreUser">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="text-base font-semibold">Tambah User</span>
                    </button>
                @endif
            </div>

            {{-- List Job --}}
            @if (isset($jobs))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 overflow-auto">
                    @foreach ($jobs as $job)
                        <a href="{{ route('jobs.detail', ['id' => $job->id]) }}"
                            class="bg-gray-800 p-6 rounded-xl shadow-md hover:bg-blue-500 hover:text-white transition-all block">
                            <h2 class="text-xl font-bold">{{ $job->title }}</h2>
                            <p class="mt-3 text-sm">{{ $job->description }}</p>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- List User --}}
            @if (isset($users))
                <div class="w-full">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4 mb-6">
                        @csrf
                        <input type="text" name="search" id="search"
                            class="border border-gray-700 rounded-lg px-4 py-2 w-full text-base bg-gray-800 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Cari User">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-semibold">
                            Cari
                        </button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden shadow-md">
                            <thead class="bg-gray-700 text-gray-300">
                                <tr>
                                    <th class="text-left px-6 py-4 text-base font-semibold">Username</th>
                                    <th class="text-left px-6 py-4 text-base font-semibold">Role</th>
                                    <th class="text-center px-6 py-4 text-base font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="border-b border-gray-700">
                                        <td class="px-6 py-4">{{ $user->username }}</td>
                                        <td class="px-6 py-4 capitalize">{{ $user->role }}</td>
                                        <td class="px-6 py-4 flex justify-center gap-4">
                                            <button class="btnStoreUser" data-user-id="{{ $user->id }}"
                                                data-username="{{ $user->username }}" data-role="{{ $user->role }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    class="w-6 h-6 text-blue-400 hover:scale-110 transition-transform">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3zm-2 8h12a1 1 0 001-1v-8.586a1 1 0 00-.293-.707l-5.414-5.414a1 1 0 00-.707-.293H5a1 1 0 00-1 1v12a1 1 0 001 1h2z" />
                                                </svg>
                                            </button>

                                            <form action="{{ route('backend.users.delete', ['id' => $user->id]) }}" method="POST"
                                                onsubmit="return confirm('Yakin mau hapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-6 h-6 text-red-500 hover:scale-110 transition-transform"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            @if ($users->hasPages())
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center">
                                            {{ $users->links() }}
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('pages.dashboard.modalStoreUser')
    @include('pages.dashboard.modalStoreJob')
@endsection
