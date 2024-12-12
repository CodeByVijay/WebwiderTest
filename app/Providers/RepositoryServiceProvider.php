<?php

namespace App\Providers;

use App\Repositories\AdminRepository;
use App\Repositories\UserRepository;
use App\Services\AdminService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserService::class, UserRepository::class);
        $this->app->singleton(AdminService::class, AdminRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
