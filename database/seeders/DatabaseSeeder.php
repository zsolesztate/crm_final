<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Permission::create(['name' => 'can_view_users']);
        Permission::create(['name' => 'can_create_user']);
        Permission::create(['name' => 'can_edit_user']);
        Permission::create(['name' => 'can_delete_user']);
        Permission::create(['name' => 'can_view_roles']);
        Permission::create(['name' => 'can_create_role']);
        Permission::create(['name' => 'can_edit_role']);
        Permission::create(['name' => 'can_delete_role']);
        Permission::create(['name' => 'can_view_partners']);
        Permission::create(['name' => 'can_create_partner']);
        Permission::create(['name' => 'can_edit_partner']);
        Permission::create(['name' => 'can_delete_partner']);

        $permissions = Permission::all();

        $adminRole = Role::create(['name' => 'admin']);

        $adminRole->syncPermissions($permissions);

        $adminUser = User::create([
            'name' => 'Teszt Elek',
            'email' => 'teszt@mail.com',
            'password' => Hash::make('secret'),
        ]);

        $adminUser->assignRole($adminRole);
        $adminUser->active_status = true;
        $adminUser->can_modify = true;
        $adminUser->save();
    }
}
