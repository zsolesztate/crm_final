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
        /*return array_merge(parent::share($request), [
            'userCanModify' => fn () => $request->user()
                ? $request->user()->only('can_modify')
                : null,
        ]);*/

        return array_merge(parent::share($request), [
            'userPermissions' => function () use ($request) {
                $user = $request->user();

                if ($user) {
                    return [
                        'userCanModify' => $user->can_modify,
                        'can_view_users' => Gate::allows('view users', $user),
                        'can_view_roles' => Gate::allows('view roles', $user),
                    ];
                }

                return null;
            },
        ]);
    }
}
