<?php

namespace App\Providers;

use App\Services\BuilderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BuilderService::class, function ($app) {
            return new BuilderService();
        });
    }

    public function boot(): void
    {
        //
    }
}