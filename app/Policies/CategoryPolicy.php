<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Category;

class CategoryPolicy
{
public function viewAny($user)
{
    return true;
}

public function view($user, Category $category)
{
    return true;
}

public function create($user)
{
    return $user->admin;
}

public function update($user, Category $category)
{
    return $user->admin;
}

public function delete($user, Category $category)
{
    return $user->admin;
}

}
