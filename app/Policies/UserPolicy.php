<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function view(User $user, User $model) {
        return true;
    }

    public function update(User $user, User $model) {
        return true;
    }

    public function delete(User $user, User $model)
    {
        return true;
    }
}
