<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{


    //public function viewAny(User $user, Project $project) {
  //      return $user->$user->role === 'admin' || $project->user_id === $user->id;
//    }

    // public function viewAny(User $user, Project $project)
    // {
    //       return in_array($user->role, ['admin']) || $project->user_id === $user->id;
    // }

public function view($user)
{
    return true;
}
public function create($user)
{
    return true;
}

public function update($user)
{
    return true;
}

public function delete($user)
{
    return true;
}
}
