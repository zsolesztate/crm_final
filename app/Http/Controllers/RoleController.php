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
        Gate::authorize('view roles');

        $all_users_with_all_their_roles = User::with('roles:name')->get();

        return Inertia::render('Roles',[
            'users' => $all_users_with_all_their_roles,
            'roles' =>  Role::select('id','name')->get()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('CreateRole',[
            'permissions' => Permission::all('id','name')
        ]);
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        Gate::authorize('add roles');

        $validatedData = $request->validated();

        $role = Role::query()->create([
            'name' => $validatedData['name'],
        ]);

        if (isset($validatedData['permissions'])){
            $role->syncPermissions($validatedData['permissions']);
        }

        return redirect('/roles');
    }

    public function edit(Role $role): Response
    {

        $roleWithPermissions = Role::with('permissions')->find($role->id);

        return Inertia::render('EditRole', [
            'role' => $roleWithPermissions,
            'permissions' => Permission::all('id','name'),
        ]);
    }

    public function update(UpdateRoleRequest $request,Role $role): RedirectResponse
    {
        $validatedData = $request->validated();

        Gate::authorize('edit roles');

        $role->update($validatedData);

        $role->syncPermissions($validatedData['permissions']);

        return redirect('/roles');
    }

    public function destroy(Role $role)
    {
        Gate::authorize('delete roles');

        try {
            if ($role->users()->exists()) {
                return redirect()->back()->withErrors('A szerepkör nem törölhető, mert hozzárendelt felhasználók vannak.');
            }

            $role->delete();

            return redirect('/roles')->withSuccess('A szerepkör sikeresen törölve.');

        } catch (ModelNotFoundException $e) {

            return back()->withError('A szerepkör nem található.');
        }
    }

    public function updateUserRole(Request $request)
    {
        if (Auth::user()->hasRole('admin')) {

            if (User::find($request->userId) && Role::find($request->roleId)) {
                User::find($request->userId)->roles()->sync([$request->roleId]);

                return redirect('/roles');
            }
        }
    }
}
