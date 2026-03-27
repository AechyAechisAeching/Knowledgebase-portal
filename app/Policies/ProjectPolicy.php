<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{

public function view(User $user, Project $project)
{
    return $project->user_id === $user->id ||
    $user->role == 'admin';
}
public function create(User $user) {
    return in_array($user->role, ['admin', 'owner']);
}

public function update(User $user) {
    return in_array($user->role, ['admin', 'owner']);
}

public function delete(User $user) {
    return in_array($user->role, ['admin', 'owner']);
}
}
