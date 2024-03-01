<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowUsersRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class UserController extends Controller
{

    public function index(ShowUsersRequest $request, $type = null)
    {
        Gate::authorize('view users');

        $validatedData = $request->validated();
        $searchText = $validatedData['search'] ?? null;
        $error = [];

        $query = User::query();

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

    public function store(StoreUserRequest $request): RedirectResponse
    {
        Gate::authorize('create user');

        User::query()->create($request->validated());

        return redirect('/users');
    }

    public function update(UpdateUserRequest $request,User $user): RedirectResponse
    {
        Gate::authorize('edit user');

        $user->update($request->validated());

        return redirect('/users');
    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete users');

        $user->delete();

        return redirect('/users');

    }

    public function profileupdate(UpdateProfileRequest $request,User $user)
    {
        $this->authorize('update', [$user, auth()->user()]);

        $user->update($request->validated());

        return redirect('/profile');
    }
}
