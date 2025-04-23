<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function storeUser(Request $request, $id = null)
    {;
        $requirements = [
            'username' => ['required', 'string', 'max:255', $id ? 'unique:users,username,' . $id : 'unique:users'],
            'password' => [$id ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,tasker,worker'],
            'profile' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];

        $validator = Validator::make($request->all(), $requirements);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['error' => $validator->errors()])->withInput();
        }

        $data = $request->only(['username', 'password', 'role']);
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        $user = User::updateOrCreate(
            ['id' => $id],
            $data
        );

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $path = $file->store('profiles/ ' . $user->username, 'public');
            $user->profile = $path;
            $user->save();
        }

        $message = $id ? 'User updated successfully!' : 'User created successfully!';
        return redirect()->back()->with(['message' => $message]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with(['message' => 'User deleted successfully!']);
    }
}
