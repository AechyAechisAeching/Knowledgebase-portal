<?php

namespace App\Providers;

use App\Models\Project;
use App\Policies\ProjectPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
    protected $policies = [
        Project::class => ProjectPolicy::class,
        User::class => UserPolicy::class,
    ];
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
