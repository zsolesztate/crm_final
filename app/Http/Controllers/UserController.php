<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{

    //TODO a jogokat be kell állítani majd
    public function index()
    {
        return Inertia::render('Users',[
            'users' => User::all()
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::query()->create($request->validated());

        return redirect('/users');
    }

    public function update(UpdateUserRequest $request,User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect('/users');
    }

    public function destroy(User $user): RedirectResponse
    {
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
