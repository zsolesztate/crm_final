<?php

namespace App\Actions;

use App\Models\Contact;
use App\Models\Project;
use App\Models\User;

class ProjectsIndex
{
    public function __invoke(array $request = null)
    {
        $query = Project::query();

        $searchText = $request['search'] ?? null;
        $UserSearchText = $request['user'] ?? null;
        $ContactSearchText = $request['contact'] ?? null;

        $user = null;
        $contact = null;

        if ($searchText) {
            $query->where('name', 'like', '%' . $searchText . '%');
        }

        if ($UserSearchText) {
            $query->whereHas('tasks.users', fn($userQuery) => $userQuery->where('users.id', $UserSearchText));
            $user = User::query()->find($UserSearchText);
        }

        if ($ContactSearchText) {
            $query->whereHas('tasks.contact',fn($contactQuery) => $contactQuery->where('contacts.id',$ContactSearchText));
            $contact = Contact::query()->find($ContactSearchText);
        }

        $projects = $query->with('partner')
            ->get()
            ->map(fn($project) => [
                'project' => $project,
                'is_in_progress' => $project->tasks()->where('status', 'in_progress')->exists(),
                'earliest_start_date' => $project->tasks()->min('start_date'),
                'latest_end_date' => $project->tasks()->max('finnish_date'),
                'users' => $project->tasks->flatMap(fn($task) => $task->users)->unique('id'),
                'task_count' => $project->tasks->count(),
                'completed_task_count' => $project->tasks()->where('status', true)->count(),
                'searchedText' => $searchText,
            ]);

        return [
            'projects' => $projects,
            'searchedText' => $searchText,
            'users' => User::all(),
            'contacts' => Contact::all(),
            'user' => $user,
            'contact' => $contact
        ];
    }
}
