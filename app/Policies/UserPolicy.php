<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function view(User $user): bool
    {
        return $user->hasAbility('view');
    }

    public function create(User $user): bool
    {
        return $user->hasAbility('create');
    }

    public function update(User $user): bool
    {
        return $user->hasAbility('update');
    }

    public function delete(User $user): bool
    {
        return $user->hasAbility('delete');
    }
}
