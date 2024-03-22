<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowUsersRequest;
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

    public function index(ShowUsersRequest $request, $type = null)
    {
        Gate::authorize('Munkatársak megtekintése');

        $validatedData = $request->validated();
        $searchText = $validatedData['search'] ?? null;

        $query = User::query()->with('roles');

        if($type === 'search'){
            $query->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', "%$searchText%")
                    ->orWhere('email', 'LIKE', "%$searchText%")
                    ->orWhere('phone', 'LIKE', "%$searchText%")
                    ->orWhere('position', 'LIKE', "%$searchText%");
            });
        }

        $users = $query->get();

        return Inertia::render('Users',[
            'users' => $users,
            'searchedText' => $searchText,
        ]);
    }

    public function create(): Response
    {
        Gate::authorize('Munkatárs létrehozása');

        return Inertia::render('CreateUser',[
            'roles' => Role::all()
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        Gate::authorize('Munkatárs létrehozása');

        $validatedData = $request->validated();

        $user = User::query()->create(Arr::except($validatedData, ['role']));

        $role = Role::find($validatedData['role']);

        $user->assignRole($role);

        return redirect()->route('users.index');
    }

    public function edit(User $user): Response
    {
        Gate::authorize('Munkatárs szerkesztése');

        return Inertia::render('EditUser', [
            'user' => $user->load('roles'),
            'roles' => Role::all()
        ]);
    }

    public function update(UpdateUserRequest $request,User $user): RedirectResponse
    {
        Gate::authorize('Munkatárs szerkesztése');

        $validatedData = $request->validated();

        $user->update(Arr::except($validatedData, ['role']));

        $user->roles()->sync($validatedData['role']['id']);

        return redirect()->route('users.index');
    }

    public function userPasswordUpdate(UpdateUserPasswordRequest $request,User $user): RedirectResponse
    {
        Gate::authorize('Munkatárs szerkesztése');

        $validatedData = $request->validated();

        $user->update([
            'password' => bcrypt($validatedData['password']),
        ]);

        return redirect()->route('users.index');

    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('Munkatárs törlése');

        $user->delete();

        return redirect()->route('users.index');

    }
}
