@extends('layouts.main')
@section('title', 'Login')

@section('content')
    @if (Session::has('message') || $errors->any())
        @include('templates.modalMessage')
    @endif
    <div class="h-screen flex justify-center items-center">
        <div
            class="flex flex-col gap-[32px] p-[32px] min-w-[50vh] border rounded-[16px] justify-center items-center bg-slate-100 shadow-[10px_10px_10px_0px_rgba(0,0,0,0.25)]">
            <h1 class="text-center text-[32px] font-bold">Login</h1>
            <form action="{{ route('backend.login') }}" method="POST" class="flex flex-col gap-[16px] w-full">
                @csrf
                @if ($admin)
                    <input type="hidden" name="admin" value="{{ $admin }}">
                @endif
                <div class="flex flex-col gap-[8px]">
                    <label for="username" class="text-[20px]">Username:</label>
                    <input type="text" name="username" id="username" placeholder="Input Username"
                        class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full" value="{{ old('username') }}"
                        required>
                </div>
                <div class="flex flex-col gap-[8px]">
                    <label for="password" class="text-[20px]">Password:</label>
                    <input type="password" name="password" id="password" placeholder="Input Password"
                        class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full" required>
                </div>
                <div class="flex gap-[8px]">
                    <input type="checkbox" name="showPassword" id="showPassword">
                    <label for="showPassword">Show Password</label>
                </div>
                <button
                    class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full bg-[#3D90D7] text-[#eeeeee] font-bold hover:bg-[#3A59D1] cursor-pointer">Submit</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let inputPassword = document.getElementById('password');
            let showPassword = document.getElementById('showPassword');
            showPassword.addEventListener('change', function() {
                if (showPassword.checked) {
                    inputPassword.setAttribute('type', 'text');
                } else {
                    inputPassword.setAttribute('type', 'password');
                }
            });
        });
    </script>
@endsection
