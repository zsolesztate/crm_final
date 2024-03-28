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

        if ($user->partners->isEmpty() && !$user->can('can_view_partners')) {
            return Inertia::render('Error403');
        }

        $partners = Partner::query()
            ->when(!$user->can('can_view_partners'), function ($query) use ($user) {
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
        Gate::authorize('can_create_partner');

        return Inertia::render('CreatePartner',[
            'users' => User::all('id','name')
        ]);
    }

    public function store(StorePartnerRequest $request): RedirectResponse
    {
        Gate::authorize('can_create_partner');

        $validatedData = $request->validated();

        $partner = Partner::create([
            'name' => $validatedData['name'],
            'company_name' => $validatedData['company_name'],
            'email' => $validatedData['email'],
        ]);

        $userIds = collect($validatedData['users'])->pluck('id');

        $partner->users()->attach($userIds);

        return redirect()->route('partners.index');
    }

    public function edit(Partner $partner): Response
    {
        Gate::authorize('can_edit_partner');

        $partner->load('users');

        return Inertia::render('EditPartner', [
            'partner' => $partner,
            'users' => User::all('id','name'),
        ]);
    }

    public function update(UpdatePartnerRequest $request,Partner $partner): RedirectResponse
    {
        Gate::authorize('can_edit_partner');

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
        Gate::authorize('can_delete_partner');

        $partner->delete();

        return redirect()->route('partners.index');
    }
}
