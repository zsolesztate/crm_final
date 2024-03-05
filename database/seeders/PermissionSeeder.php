<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'add roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);

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
