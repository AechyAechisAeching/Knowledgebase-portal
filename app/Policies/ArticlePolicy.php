<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Article;
use App\Models\Project;

class ArticlePolicy
{

    //public function viewAny(User $user, Project $project)
    //{
    //  dd([
    //     'user_id' => $user->id,
    //     'user_admin' => $user->user_admin,
    //     'project_user_id' => $project->user_id,
    //     'match' => $project->user_id === $user->id,
    // ]);
    //  return in_array($user->role, ['admin']) || $project->user_id === $user->id;
    //}

public function view($user)
{
    
return true;

}

public function create($user)
{
    return true;
}

public function update($user, Article $article)
{
    return true;
}

public function delete($user, Article $article)
{
    return true;
}
}
