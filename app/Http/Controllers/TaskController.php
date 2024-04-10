<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        return Inertia::render('Tasks',[
            'tasks' => Task::with('users','contact')->where('project_id', $project->id)->get(),
            'project' => $project
        ]);
    }

    public function create(Project $project): Response
    {
        return Inertia::render('CreateTask',[
            'project' => $project,
            'users' => User::all()
        ]);
    }

    public function store(StoreTaskRequest $request,Project $project): RedirectResponse
    {
        $validatedData = $request->validated();

        $taskData = [...$validatedData, 'project_id' => $project->id];
        unset($taskData['users']);

        $task = Task::create($taskData);

        $task->users()->attach($validatedData['users']);

        return redirect('tasks/' . $project->id);
    }

    public function edit(Task $task): Response
    {
        $task->load('contact','project','users');

        return Inertia::render('EditTask', [
            'task' => $task,
            'users' => User::all('id','name'),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task ): RedirectResponse
    {
        $validatedData = $request->validated();

        $task->update(Arr::except($validatedData, ['users']));

        $task->users()->sync($validatedData['users']);

        return redirect('tasks/' . $task->project_id);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('tasks/' . $task->project_id);
    }
}
