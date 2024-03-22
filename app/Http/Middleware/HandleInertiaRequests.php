<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Illuminate\Support\Facades\Gate;


class HandleInertiaRequests extends Middleware
{

    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request)
    {

        return array_merge(parent::share($request), [
            'userPermissions' => function () use ($request) {
                $user = $request->user();

                if ($user) {
                    return [
                        'userCanModify' => $user->can_modify,
                        'can_view_users' => Gate::allows('Munkatársak megtekintése', $user),
                        'can_create_users' => Gate::allows('Munkatárs létrehozása', $user),
                        'can_edit_users' => Gate::allows('Munkatárs szerkesztése', $user),
                        'can_delete_users' => Gate::allows('Munkatárs törlése', $user),
                        'can_view_roles' => Gate::allows('Jogosultságok megtekintése', $user),
                        'can_create_roles' => Gate::allows('Jogosultság létrehozása', $user),
                        'can_edit_roles' => Gate::allows('Jogosultság szerkesztése', $user),
                        'can_delete_roles' => Gate::allows('Jogosultság törlése', $user),
                        //'can_view_partners' => Gate::allows('Partnerek megtekintése', $user),
                        'can_view_partners' => Gate::allows('Partnerek megtekintése') || !$user->partners->isEmpty(),
                        'can_create_partners' => Gate::allows('Partner létrehozása', $user),
                        'can_edit_partners' => Gate::allows('Partner szerkesztése', $user),
                        'can_delete_partners' => Gate::allows('Partner törlése', $user),
                    ];
                }

                return null;
            },
        ]);
    }
}
