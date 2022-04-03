<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceClassProvider extends ServiceProvider
{
    private const SERVICE_NAME = [
        'UserIssue',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (self::SERVICE_NAME as $service) {
            $this->app->bind(
                "App\Services\Interfaces\\{$service}ServiceInterface",
                "App\Services\{$service}Service"
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
