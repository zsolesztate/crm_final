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

        if ($user->partners->isEmpty() && !$user->can('Partnerek megtekintése')) {
            return Inertia::render('Error403');
        }

        $partners = Partner::query()
            ->when(!$user->can('Partnerek megtekintése'), function ($query) use ($user) {
                $query->whereHas('users', function ($subQuery) use ($user) {
                    $subQuery->where('user_id', $user->id);
                });
            })
            ->with('users')
            ->get();

        return Inertia::render('Partners',[
            'partners' => $partners
        ]);

    }

    public function create(): Response
    {
        Gate::authorize('Partner létrehozása');

        return Inertia::render('CreatePartner',[
            'users' => User::all('id','name')
        ]);
    }

    public function store(StorePartnerRequest $request): RedirectResponse
    {
        Gate::authorize('Partner létrehozása');

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

        return redirect()->route('partners.index');
    }

    public function edit(Partner $partner): Response
    {
        Gate::authorize('Partner szerkesztése');

        $partner->load('users');

        return Inertia::render('EditPartner', [
            'partner' => $partner,
            'users' => User::all('id','name'),
        ]);
    }

    public function update(UpdatePartnerRequest $request,Partner $partner): RedirectResponse
    {
        Gate::authorize('Partner szerkesztése');

        $validatedData = $request->validated();

        $partner->update([
            'name' => $validatedData['name'],
            'company_name' => $validatedData['company_name'],
            'email' => $validatedData['email'],
        ]);

        $partner->users()->sync(array_column($validatedData['users'], 'id'));

        return redirect()->route('partners.index');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        Gate::authorize('Partner törlése');

        $partner->delete();

        return redirect()->route('partners.index');
    }
}
