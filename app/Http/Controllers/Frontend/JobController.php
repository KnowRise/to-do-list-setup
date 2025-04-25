<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class JobController extends Controller
{
    public function detail(Request $request, $id)
    {
        $user = $request->user();
        $job = Job::find($id);
        if ($user->role == 'worker') {
            $tasks = Task::where('job_id', $job->id)->whereHas('userTasks', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $tasks = Task::where('job_id', $job->id)->get();
        }

        return view('pages.detail.jobs.main', compact('job', 'tasks'));
    }

    public function modalNewTask($id)
    {
        $job = Job::with('tasks')->find($id);

        return view('pages.detail.jobs.modalNewTask', compact('job'));
    }

    public function modalStoreJob(Request $request, $id)
    {
        $edit = $request->has('edit');
        $job = Job::with('tasks')->find($id);

        return view('pages.detail.jobs.modalStoreJob', compact('job', 'edit'));
    }
}
