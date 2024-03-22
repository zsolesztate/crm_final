<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfilePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ProfileController extends Controller
{

    public function edit()
    {
        return Inertia::render('EditProfile',[
            'user' => Auth::user(),
        ]);
    }

    public function profileUpdate(UpdateProfileRequest $request,User $user)
    {
        $this->authorize('update', [$user, auth()->user()]);

        $user->update($request->validated());

        return redirect()->route('profile.edit');
    }

    public function passwordUpdate(UpdateProfilePasswordRequest $request)
    {
        $user = auth()->user();

        $validatedData = $request->validated();

        $user->password = Hash::make($validatedData['newPassword']);
        $user->save();

        return redirect()->route('profile.edit');
    }
}
