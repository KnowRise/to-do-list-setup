<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function storeJob(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors(['error' => $validator->errors()])
                ->withInput();
        }

        $user = $request->user();
        $data = $request->only(['title', 'description']);
        $data['user_id'] = $user->id;
        Job::updateOrCreate(['id' => $id], $data);

        $message = $id ? 'Update Job Successfully' : 'Created Job Successfully';

        if ($id) {
            return redirect()
                ->route('jobs.detail', ['id' => $id])
                ->with(['message' => $message]);
        } else {
            return redirect()
                ->route('dashboard')
                ->with(['message' => $message]);
        }
    }

    public function deleteJob($id) {
        $job = Job::find($id);
        $job->delete();

        return redirect()->route('dashboard')->with(['message' => 'Job Deleted Successfully']);
    }
}
