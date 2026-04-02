<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{

       
    // public function viewAny(User $user, Project $project) {
    // return $project->users()->where('user_id', $user->id)->exists() ||
    // $user->role === 'admin';
    // }
public function before(User $user): ?bool {
    if ($user->role === 'admin') return true;

    return null;
}

private function inSameWorkspace(User $user, Project $project) {
    $workspace = $project->workspace;
    if (!$workspace) return false;
    
    $member = $workspace->members()->where('user_id', $user->id)
    ->first();
    
    if (!$member) return false;

    if ($member->pivot->role === 'member') {
    }
    return true;
}

public function view(User $user, Project $project) {
    if (!$this->inSameWorkspace($user, $project)) return false;
    
    return $project->workspace->members()
    ->where('user_id', $user->id)
    ->exists();
}


public function create(User $user, Project $project)
{
    return $project->workspace->members()
    ->where('user_id', $user->id)
    ->wherePivotIn('role', ['owner', 'admin'])
    ->exists();
}

public function update(User $user, Project $project)
{
    return $project->workspace->members()
    ->where('user_id', $user->id)
    ->wherePivotIn('role', ['owner', 'admin'])
    ->exists();
}

public function delete(User $user, Project $project)
{
    return $project->workspace->members()
    ->where('user_id', $user->id)
    //owner only?
    ->wherePivotIn('role', ['owner', 'admin'])
    ->exists();
}
}