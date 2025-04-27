@extends('layouts.main')
@section('title', 'Login')

@section('content')
    @if (Session::has('message') || $errors->any())
        @include('templates.modalMessage')
    @endif

    <div class="h-screen flex justify-center items-center">
        <div class="card w-full max-w-md bg-base-100 shadow-xl border-gray-300 border">
            <div class="card-body">
                <h1 class="text-center text-3xl font-bold">Login</h1>
                <form action="{{ route('backend.login') }}" method="POST" class="flex flex-col gap-4 mt-4">
                    @csrf
                    @if ($admin)
                        <input type="hidden" name="admin" value="{{ $admin }}">
                    @endif
                    <div class="form-control">
                        <label for="username" class="label">
                            <span class="label-text text-lg">Username</span>
                        </label>
                        <input type="text" name="username" id="username"
                            class="input input-bordered text-base w-full"
                            placeholder="Input Username" value="{{ old('username') }}" required>
                    </div>
                    <div class="form-control">
                        <label for="password" class="label">
                            <span class="label-text text-lg">Password</span>
                        </label>
                        <input type="password" name="password" id="password"
                            class="input input-bordered text-base w-full"
                            placeholder="Input Password" required>
                    </div>
                    <div class="form-control">
                        <label class="cursor-pointer flex items-center gap-2">
                            <input type="checkbox" name="showPassword" id="showPassword" class="checkbox">
                            <span class="label-text">Show Password</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let inputPassword = document.getElementById('password');
            let showPassword = document.getElementById('showPassword');
            showPassword.addEventListener('change', function() {
                inputPassword.type = this.checked ? 'text' : 'password';
            });
        });
    </script>
@endsection
