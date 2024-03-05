<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowUsersRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateProfilePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(ShowUsersRequest $request, $type = null)
    {
        Gate::authorize('view users');

        $validatedData = $request->validated();
        $searchText = $validatedData['search'] ?? null;
        $error = [];

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

        if($users->isEmpty()){
            $error = ['not_found' => 'Nincs találat'];
        }

        return Inertia::render('Users',[
            'users' => $users,
            'errors' => $error,
            'searchedText' => $searchText,
        ]);
    }

    public function create(): Response
    {
        Gate::authorize('create user');

        return Inertia::render('CreateUser',[
            'roles' => Role::all()
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        Gate::authorize('create user');

        $validatedData = $request->validated();

        $user = User::query()->create(Arr::except($validatedData, ['role']));

        $role = Role::find($validatedData['role']);

        $user->assignRole($role);

        return redirect('/users');
    }

    public function edit(User $user): Response
    {
        Gate::authorize('edit user');

        $userWithRoles = $user->load('roles');

        return Inertia::render('EditUser', [
            'user' => $userWithRoles,
            'roles' => Role::all()
        ]);
    }

    public function update(UpdateUserRequest $request,User $user): RedirectResponse
    {
        Gate::authorize('edit user');

        $validatedData = $request->validated();

        $userData = array_diff_key($validatedData, ['role' => true]);
        $user->update($userData);
        $user->roles()->sync($validatedData['role']['id']);

        return redirect('/users');
    }

    public function userPasswordUpdate(UpdateUserPasswordRequest $request,User $user): RedirectResponse
    {
        Gate::authorize('edit user');

        $validatedData = $request->validated();

        $user->update([
            'password' => bcrypt($validatedData['password']),
        ]);

        return redirect('/users');

    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete users');

        $user->delete();

        return redirect('/users');

    }

    public function profileUpdate(UpdateProfileRequest $request,User $user)
    {
        $this->authorize('update', [$user, auth()->user()]);

        $user->update($request->validated());

        return redirect('/profile');
    }

    public function passwordUpdate(UpdateProfilePasswordRequest $request)
    {
        $user = auth()->user();

        $validatedData = $request->validated();

        $user->password = Hash::make($validatedData['newPassword']);
        $user->save();

        return redirect('/profile');
    }

}
