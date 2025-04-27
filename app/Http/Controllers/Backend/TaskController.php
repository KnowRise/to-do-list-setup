<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\returnArgument;

class TaskController extends Controller
{
    public function storeTask(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'job_id' => ['required', 'exists:jobs,id'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors(['error' => $validator->errors()])
                ->withInput();
        }

        $user = $request->user();
        $data = $request->only(['title', 'description', 'job_id']);
        $task = Task::updateOrCreate(['id' => $id], $data);

        if ($user->role == 'worker') {
            UserTask::create([
                'user_id' => $user->id,
                'task_id' => $task->id,
            ]);
        }

        $message = $id ? 'Task Updated Successfully' : 'Task Created Successfully';
        if ($id) {
            return redirect()
                ->route('tasks.detail', ['id' => $id])
                ->with(['message' => $message]);
        } else {
            return redirect()
                ->route('jobs.detail', ['id' => $request->job_id])
                ->with(['message' => $message]);
        }
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);
        $jobId = $task->job_id;
        $task->delete();

        return redirect()
            ->route('jobs.detail', ['id' => $jobId])
            ->with(['message' => 'Task Deleted Successfully']);
    }

    public function storeAssignTask(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'Task Not Found']);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'array'],
            'user_id.*' => ['exists:users,id'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors(['error' => $validator->errors()]);
        }

        $userIds = $request->user_id;
        $exitingUserTask = UserTask::where('task_id', $id)->pluck('user_id')->toArray();
        $newUserIds = array_diff($userIds, $exitingUserTask);

        if (count($newUserIds) <= 0) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'The user already assigned to this task']);
        }

        foreach ($newUserIds as $userId) {
            UserTask::create([
                'task_id' => $id,
                'user_id' => $userId,
            ]);
        }

        return redirect()
            ->route('tasks.detail', ['id' => $task->id])
            ->with(['message' => 'Assign User Successfully']);
    }

    public function deleteAssignUser($id)
    {
        $userTask = UserTask::find($id);
        $taskId = $userTask->task_id;
        $userTask->delete();

        return redirect()
            ->route('tasks.detail', ['id' => $taskId])
            ->with(['message' => 'User UnAssign is Successfully']);
    }

    public function submitTask(Request $request, $id)
    {
        $userTask = UserTask::find($id);
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'file' => ['required', 'mimes:png,jpg,svg,jpeg'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors(['error' => $validator->errors()]);
        }

        $file = $request->file('file');
        $path = $file->store('users/' . $user->username . '/tasks/' . $userTask->task->id, 'public');
        $userTask->file_path = $path;
        $userTask->status = 'completed';
        $userTask->completed_at = now();
        $userTask->save();

        return redirect()
            ->route('jobs.detail', ['id' => $userTask->task->job_id])
            ->with(['message' => 'File Upluaded Successfully']);
    }

    public function changeStatus(Request $request, $id)
    {
        $userTask = UserTask::find($id);

        $validator = Validator::make($request->all(), [
            'status' => ['required', 'in:rejected,approved'],
            'feedback' => ['nullable'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors(['error' => $validator->errors()]);
        }

        $userTask->feedback = $request->feedback;
        $userTask->status = $request->status;
        $userTask->save();

        return redirect()
            ->route('tasks.detail', ['id' => $userTask->task->id])
            ->with(['message' => 'Status Updated']);
    }

    public function copyAnotherTask(Request $request, $id)
    {
        $task = Task::find($id);

        $validator = Validator::make($request->all(), [
            'task_id' => ['required', 'exists:tasks,id'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors(['error' => $validator->errors()]);
        }

        $copyTask = Task::find($request->task_id);

        $taskUserIds = $task->userTasks()->pluck('user_id')->toArray();
        $copyTaskUserIds = $copyTask->userTasks()->pluck('user_id')->toArray();

        $toAdd = array_diff($copyTaskUserIds, $taskUserIds);
        $toDelete = array_diff($taskUserIds, $copyTaskUserIds);

        UserTask::where('task_id', $task->id)->whereIn('user_id', $toDelete)->delete();

        foreach ($toAdd as $userId) {
            UserTask::create([
                'task_id' => $task->id,
                'user_id' => $userId,
            ]);
        }

        return redirect()
            ->route('tasks.detail', ['id' => $task->id])
            ->with(['message' => 'Berhasil Assign User']);
    }

    public function getTask(Request $request) {
        $query = Task::query();
        $query->whereHas('job', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
        });
        $tasks = $query->with('job')->get();

        return response()->json($tasks);
    }
}
