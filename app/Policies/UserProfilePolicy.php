<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserProfilePolicy
{
    use HandlesAuthorization;
    public function update(User $user, User $profileUser)
    {
        return $user->id === $profileUser->id;
    }
}
