<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function detail($id)
    {
        $task = Task::with('userTasks')->find($id);

        return view('pages.detail.tasks.main', compact('task'));
    }
    public function modalDetailUserTask(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return redirect()->back()->withErrors(['error' => 'Task Not Found']);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors(['error' => $validator->errors()]);
        }

        $userTask = UserTask::where('user_id', $request->user_id)->where( 'task_id', $id)->first();
        return view('pages.detail.tasks.modalDetailUserTask', compact('userTask', 'task'));
    }

    public function modalNewUser(Request $request, $id)
    {
        $task = Task::with('userTasks')->find($id);
        // $search = $request->search;
        $query = User::query();
        $query->where('role', 'worker');
        // $query->when($search, function ($q) use ($search) {
        //     $q->where('username', 'LIKE', "%{$search}%");
        // });

        $users = $query->get();

        return view('pages.detail.tasks.modalNewUser', compact('task', 'users'));
    }

    public function modalAnotherTask(Request $request, $id) {
        $user = $request->user();
        $task = Task::find($id);
        $tasks = Task::whereHas('job', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        return view('pages.detail.tasks.modalAnotherTask', compact('tasks', 'task'));
    }

    public function modalStoreTask(Request $request, $id)
    {
        $edit = $request->has('edit');
        $task = Task::with('userTasks')->find($id);

        return view('pages.detail.tasks.modalStoreTask', compact('task', 'edit'));
    }
}
