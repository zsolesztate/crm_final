<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PartnerController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->can('view partners')) {
            $partners = Partner::with('users')->get();
            $users = User::all();
        } else {
            $partners = $user->partners()->with('users')->get();
            $users = null;
        }

        return Inertia::render('Partners',[
            'partners' => $partners,
            'users' => $users
        ]);

    }

    public function create(): Response
    {
        return Inertia::render('CreatePartner',[
            'users' => User::all('id','name')
        ]);
    }

    public function store(StorePartnerRequest $request): RedirectResponse
    {
        Gate::authorize('create partner');

        $validatedData = $request->validated();

        $partner = Partner::create([
            'name' => $validatedData['name'],
            'company_name' => $validatedData['company_name'],
            'email' => $validatedData['email'],
        ]);

        foreach ($validatedData['users'] as $user) {
            $user = User::find($user['id']);
            if ($user) {
                $partner->users()->attach($user['id']);
            }
        }

        return redirect('/partners');
    }


    public function edit(Partner $partner): Response
    {
        $partner->load('users');

        return Inertia::render('EditPartner', [
            'partner' => $partner,
            'users' => User::all('id','name'),
        ]);
    }


    public function update(UpdatePartnerRequest $request,Partner $partner): RedirectResponse
    {
        Gate::authorize('edit partner');

        $validatedData = $request->validated();

        $partner->update([
            'name' => $validatedData['name'],
            'company_name' => $validatedData['company_name'],
            'email' => $validatedData['email'],
        ]);

        $partner->users()->sync([]);

        foreach ($validatedData['users'] as $user) {
            $user = User::find($user['id']);
            if ($user) {
                $partner->users()->attach($user['id']);
            }
        }

        return redirect('/partners');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        Gate::authorize('delete partner');

        $partner->delete();

        return redirect('/partners');
    }
}
