<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors(['error' => $validator->errors()])
                ->withInput();
        }

        $admin = $request->has('admin');
        $auth = Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($auth) {
            $user = auth()->user();
            if ($user->role == 'admin' && !$admin) {
                auth()->logout();
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'Invalid credentials']);
            }

            return redirect()->route('dashboard');
        }

        return redirect()
            ->back()
            ->withErrors(['error' => 'Invalid credentials'])
            ->withInput();
    }

    public function logout() {
        auth()->logout();
        return redirect()->route('login');
    }
}
