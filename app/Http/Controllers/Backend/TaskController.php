<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function storeTask(Request $request, $id = null) {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['error' => $validator->errors()])->withInput();
        }
    }
}
