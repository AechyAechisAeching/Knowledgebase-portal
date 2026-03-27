<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Article;

class ArticlePolicy
{


 public function viewAny(User $user) {
     return true;

 }
 public function view(User $user, Article $article) {
    return $article->status === 'published' || $user->id === $article->user_id;    
}
    
 public function before($user) {
    if ($user->role === 'admin') {
    return true;
    }
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

