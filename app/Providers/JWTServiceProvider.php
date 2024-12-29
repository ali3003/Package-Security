<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\JWTService;
class JWTServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(JWTService::class, function ($app) {
            $key = env("JWT_SECRET_KEY");
            return new JWTService($key);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
