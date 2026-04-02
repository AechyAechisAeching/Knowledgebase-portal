<?php

namespace App\Policies;
use App\Models\Category;
use App\Models\User;
use App\Models\Workspace;

class CategoryPolicy
{

public function before(User $user): ?bool {
    if ($user->role === 'admin') return true;
    return null;
}

public function view(User $user, Category $category) {
    return $category->projects()
    ->whereHas('workspace.members', fn($q) => $q->where('user_id', $user->id))
    ->exists();
    
}


public function create(User $user)
{
    return $user->workspaces()
    ->wherePivotIn('role', ['owner', 'admin'])
    ->exists();
}

public function update(User $user) {
    return $this->update($user);    
}

public function delete(User $user)
{
    return $this->delete($user);    
}

}
