<?php
namespace App\Providers;

use App\Models\Article;
use App\Models\Project;
use App\Models\User;
use App\Policies\ArticlePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkspacePolicy;
use App\Models\Workspace;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class,
        Article::class => ArticlePolicy::class,
        User::class => UserPolicy::class,
        Workspace::class => WorkspacePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}