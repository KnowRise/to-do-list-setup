<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $admin = $request->has('admin');
        return view('pages.auth.login', compact('admin'));
    }
}
