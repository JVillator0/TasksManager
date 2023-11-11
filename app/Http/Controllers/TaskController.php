<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::query()
            ->when($request->has('project_id'), fn ($query) => $query->where('project_id', $request->project_id))
            ->get();

        info($tasks);

        return inertia('Tasks', [
            'tasks' => $tasks,
        ]);
    }
}
