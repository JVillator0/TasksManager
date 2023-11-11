<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::query()
            ->whereCompleted(false)
            ->byProject($request->input('project_id'))
            ->with('project')
            ->orderBy('priority')
            ->get();

        return TaskResource::collection($tasks);
    }

    public function store(TaskRequest $request)
    {
        $nextPriority = Task::query()
            ->byProject($request->project_id)
            ->max('priority') + 1;

        $task = Task::create(array_merge(
            $request->validated(),
            ['priority' => $nextPriority]
        ));

        return new TaskResource($task);
    }

    public function show(Task $task)
    {
        return  new TaskResource($task);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return new TaskResource($task);
    }

    public function completed(Task $task)
    {
        $task->update(['completed' => true]);

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return null;
    }
}
