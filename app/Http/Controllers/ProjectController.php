<?php

namespace App\Http\Controllers;

use App\Actions\ProjectsIndex;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Partner;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index (SearchRequest $request,ProjectsIndex $projectsIndex)
    {
        $projectsData = $projectsIndex($request->validated());

        return Inertia::render('Projects', $projectsData);
    }

    public function create(): Response
    {
        return Inertia::render('CreateProject',[
            'partners' => Partner::all('id','name')
        ]);
    }

    public function store(StoreProjectRequest $request)
    {
        Project::create($request->validated());

        return redirect()->route('projects.index');
    }

    public function edit(Project $project): Response
    {
        $project->load('partner');

        return Inertia::render('EditProject', [
            'project' => $project,
            'partners' => Partner::all('id','name'),
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        return redirect()->route('projects.index');
    }

    public function destroy(Project $project) :  RedirectResponse
    {
        $project->delete();

        return redirect()->route('projects.index');
    }
}
