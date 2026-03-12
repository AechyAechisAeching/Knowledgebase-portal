<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Article;
use App\Models\Workspace;
class ArticlePolicy
{

//     public function create(User $user)
// {
//     $workspaceId = request()->input('workspace_id');
    
//     \Log::info('ArticlePolicy@create', [
//         'user_id' => $user->id,
//         'workspace_id' => $workspaceId,
//         'workspace_exists' => Workspace::find($workspaceId)?->id,
//         'is_member' => Workspace::find($workspaceId)?->members()
//             ->where('user_id', $user->id)->exists(),
//     ]);

//     if (!$workspaceId) return false;
//     $workspace = Workspace::find($workspaceId);
//     if (!$workspace) return false;
//     return $workspace->members()->where('user_id', $user->id)->exists();
// }

public function before($user, $ability) {
    if ($user->role === 'admin') {
        return true;
    }
}
public function create(User $user)
{
    $workspaceId = request()->input('workspace_id');
    if (!$workspaceId) return false;

    $workspace = Workspace::find($workspaceId);
    if (!$workspace) return false;

    return $workspace->members()->where('user_id', $user->id)->exists();
}
public function update(User $user, Article $article)
{
    $workspace = $article->workspace;
    if (!$workspace) return false;

    return $workspace->members()->where('user_id', $user->id)->exists();
}
public function delete(User $user, Article $article)
{
    $workspace = $article->workspace;
    if (!$workspace) return false;
    return
    $workspace->members()->where('user_id', $user->id)->exists();
}
public function view(User $user, Article $article) {
    $workspace = $article->workspace;
    if (!$workspace) return false;

    return $user->role === 'admin' || $workspace->members()->where('user_id', $user->id)->exists();
}

}
