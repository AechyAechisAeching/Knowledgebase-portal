<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function before(User $authUser, string $ability): ?bool {
    if ($authUser->role === 'admin') {
    return true;
    }
    return null;
    }
    public function viewAny(User $authUser) {
    return $authUser->role === 'admin';
    }

    public function view(User $authUser, User $user) {
    return $authUser->role === 'admin' || $user->id === $user->id;
    }

    public function create(User $authUser) {
    return $authUser->role === 'admin';
    }
    public function update(User $authUser, User $user) {
    return $authUser->role === 'admin' || $authUser->id === $user->id;
    }

    public function delete(User $authUser, User $user) {
    return $authUser->role === 'admin' && $authUser->id !== $user->id;
    }
}