<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private const REPOSITORY_NAME = [
        'UserIssue',
        'User',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (self::REPOSITORY_NAME as $repository) {
            $this->app->bind(
                "App\Repositories\Interfaces\\{$repository}RepositoryInterface",
                "App\Repositories\{$repository}Repository"
            );
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
