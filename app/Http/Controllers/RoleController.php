<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $all_users_with_all_their_roles = User::with('roles:name')->get();

        return Inertia::render('Roles',[
            'users' => $all_users_with_all_their_roles,
            'roles' =>  Role::select('id','name')->get()
        ]);
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        if (Auth::user()->can('add roles')) {
            Role::query()->create($request->validated());

            return redirect('/roles');
        }else {
            return response()->json(['success' => false, 'message' => 'Felhasználó vagy szerepkör nem található']);
        }
    }

    public function update(StoreRoleRequest $request,Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return redirect('/roles');
    }

    public function destroy(Role $role)
    {
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

            } else {
                return response()->json(['success' => false, 'message' => 'Felhasználó vagy szerepkör nem található']);
            }
        }
    }
}
