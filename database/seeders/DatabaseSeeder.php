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
        Permission::create(['name' => 'Munkatársak megtekintése']);
        Permission::create(['name' => 'Munkatárs létrehozása']);
        Permission::create(['name' => 'Munkatárs szerkesztése']);
        Permission::create(['name' => 'Munkatárs törlése']);
        Permission::create(['name' => 'Jogosultságok megtekintése']);
        Permission::create(['name' => 'Jogosultság létrehozása']);
        Permission::create(['name' => 'Jogosultság szerkesztése']);
        Permission::create(['name' => 'Jogosultság törlése']);
        Permission::create(['name' => 'Partnerek megtekintése']);
        Permission::create(['name' => 'Partner létrehozása']);
        Permission::create(['name' => 'Partner szerkesztése']);
        Permission::create(['name' => 'Partner törlése']);

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
