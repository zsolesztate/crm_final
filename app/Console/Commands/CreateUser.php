<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    protected $signature = 'user:create';
    protected $description = 'Create a new user';

    public function handle()
    {
        $name = $this->ask('Add meg a felhasználónevet:');
        $email = $this->ask('Add meg az emailt:');
        $password = $this->secret('Add meg a jelszót:');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('User létrehozva!');
    }
}
