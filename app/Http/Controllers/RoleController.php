<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('Jogosultságok megtekintése')) {
            return Inertia::render('Error403');
        }

        return Inertia::render('Roles',[
            'roles' =>  Role::select('id','name')->orderBy('name')->get()
        ]);
    }

    public function create(): Response
    {
        if (!auth()->user()->can('Jogosultság létrehozása')) {
            return Inertia::render('Error403');
        }

        return Inertia::render('CreateRole',[
            'permissions' => Permission::all('id','name')
        ]);
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        Gate::authorize('Jogosultság létrehozása');

        $validatedData = $request->validated();

        $role = Role::query()->create([
            'name' => $validatedData['name'],
        ]);

        if (isset($validatedData['permissions'])){
            $role->syncPermissions($validatedData['permissions']);
        }

        return redirect()->route('roles.index');
    }

    public function edit(Role $role): Response
    {
        if (!auth()->user()->can('Jogosultság szerkesztése')) {
            return Inertia::render('Error403');
        }

        return Inertia::render('EditRole', [
            'role' => $role->load('permissions'),
            'permissions' => Permission::all('id','name'),
        ]);
    }

    public function update(UpdateRoleRequest $request,Role $role): RedirectResponse
    {
        Gate::authorize('Jogosultság szerkesztése');

        $validatedData = $request->validated();

        $role->update($validatedData);

        $role->syncPermissions($validatedData['permissions']);

        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        Gate::authorize('Jogosultság törlése');

            if ($role->users()->exists()) {
                return redirect()->back()
                    ->withErrors('A szerepkör nem törölhető, mert hozzárendelt felhasználók vannak.');
            }

            $role->delete();

            return redirect()->route('roles.index')
                ->withSuccess('A szerepkör sikeresen törölve.');
    }

}
