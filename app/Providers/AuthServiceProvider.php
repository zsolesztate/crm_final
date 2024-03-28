<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\UserProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserProfilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('can_view_users', function (User $user) {
            return $user->hasPermissionTo('can_view_users');
        });

        Gate::define('can_create_user', function (User $user) {
            return $user->hasPermissionTo('can_create_user');
        });

        Gate::define('can_edit_user', function (User $user) {
            return $user->hasPermissionTo('can_edit_user');
        });

        Gate::define('can_delete_user', function (User $user) {
            return $user->hasPermissionTo('can_delete_user');
        });

        Gate::define('can_view_roles', function (User $user) {
            return $user->hasPermissionTo('can_view_roles');
        });

        Gate::define('can_create_role', function (User $user) {
            return $user->hasPermissionTo('can_create_role');
        });

        Gate::define('can_edit_role', function (User $user) {
            return $user->hasPermissionTo('can_edit_role');
        });

        Gate::define('can_delete_role', function (User $user) {
            return $user->hasPermissionTo('can_delete_role');
        });


        Gate::define('can_view_partners', function (User $user) {
            return $user->hasPermissionTo('can_view_partners');
        });

        Gate::define('can_create_partner', function (User $user) {
            return $user->hasPermissionTo('can_create_partner');
        });

        Gate::define('can_edit_partner', function (User $user) {
            return $user->hasPermissionTo('can_edit_partner');
        });

        Gate::define('can_delete_partner', function (User $user) {
            return $user->hasPermissionTo('can_delete_partner');
        });
    }
}
