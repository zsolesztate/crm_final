<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPermissionsSeeder extends Seeder
{

    public function run(): void
    {
        Permission::create(['name' => 'view partners']);
        Permission::create(['name' => 'create partner']);
        Permission::create(['name' => 'edit partner']);
        Permission::create(['name' => 'delete partner']);

        $permissions = Permission::all();

        $adminRole = Role::where('name', 'admin')->first();

        $adminRole->syncPermissions($permissions);
    }
}
