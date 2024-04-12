<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(SearchRequest $request, $type = null)
    {
        Gate::authorize('can_view_users');

        $validatedData = $request->validated();
        $searchText = $validatedData['search'] ?? null;

        $users = User::query()
            ->when($type === 'search',fn($query) => $query
                ->where('name', 'LIKE', "%$searchText%")
                ->orWhere('email', 'LIKE', "%$searchText%")
                ->orWhere('phone', 'LIKE', "%$searchText%")
                ->orWhere('position', 'LIKE', "%$searchText%")
            )
            ->with('roles')
            ->get();
        
        return Inertia::render('Users',[
            'users' => $users,
            'searchedText' => $searchText,
        ]);
    }

    public function create(): Response
    {
        Gate::authorize('can_create_user');

        return Inertia::render('CreateUser',[
            'roles' => Role::all()
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        Gate::authorize('can_create_user');

        $validatedData = $request->validated();

        $user = User::query()->create(Arr::except($validatedData, ['role']));

        $role = Role::find($validatedData['role']);

        $user->assignRole($role);

        return redirect()->route('users.index');
    }

    public function edit(User $user): Response
    {
        Gate::authorize('can_edit_user');

        return Inertia::render('EditUser', [
            'user' => $user->load('roles'),
            'roles' => Role::all()
        ]);
    }

    public function update(UpdateUserRequest $request,User $user): RedirectResponse
    {
        Gate::authorize('can_edit_user');

        $validatedData = $request->validated();

        $user->update(Arr::except($validatedData, ['role']));

        $user->roles()->sync($validatedData['role']['id']);

        return redirect()->route('users.index');
    }

    public function userPasswordUpdate(UpdateUserPasswordRequest $request,User $user): RedirectResponse
    {
        Gate::authorize('can_edit_user');

        $validatedData = $request->validated();

        $user->update([
            'password' => bcrypt($validatedData['password']),
        ]);

        return redirect()->route('users.index');

    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('can_delete_user');

        $user->delete();

        return redirect()->route('users.index');

    }
}
