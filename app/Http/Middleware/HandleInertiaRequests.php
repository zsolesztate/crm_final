<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;


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
                    $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();

                    $permissions = [
                        'userCanModify' => $user->can_modify,
                    ];

                    foreach ($userPermissions as $permission) {
                        $permissions[$permission] = true;
                    }

                    return $permissions;
                }

                return null;
            },
        ]);
    }
}
