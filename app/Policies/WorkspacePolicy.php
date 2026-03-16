<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;

class WorkspacePolicy
{
    /**
     * Create a new policy instance.
     */
    // public function __construct()
    // {
        
    // }

   public function create(User $user ) {
        return true;
    }
    // public function show($user, Workspace $workspace) {
    //     return true;
    // }
    // return $this->manage($user, $workspace);
    public function view(User $user, Workspace $workspace) {
        if ($workspace->owner_id === $user->id);
    }

    public function update($user, Workspace $workspace) {
        return
         $workspace->owner_id === $user->id;
    }

    public function delete($user, Workspace $workspace) {
        if ($workspace->owner_id === $user->id)
             return true;
    }

    public function invite($user, Workspace $workspace) {
        return $this->manage($user, $workspace);
    }

    public function manage(User $user, Workspace $workspace): bool
{
    
    if ($workspace->owner_id === $user->id) return true;

    return $workspace->members()
        ->where('user_id', $user->id)
        ->wherePivotIn('role', ['owner', 'admin'])
        ->exists();
}
}
