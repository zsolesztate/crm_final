<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AddPermissionsSeeder::class);

        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'add roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);

        $permissions = Permission::all();

        $notConfirmedRole = Role::create(['name' => 'notconfirmed']);

        $adminRole = Role::create(['name' => 'admin']);

        $adminRole->syncPermissions($permissions);

    }
}
