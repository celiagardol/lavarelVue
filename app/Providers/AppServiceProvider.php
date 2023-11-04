<?php

namespace App\Providers;

use App\Services\CategoriaService;
use App\Services\DashboardService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoriaService::class, function ($app) {
            return new CategoriaService();
        });
        $this->app->bind(DashboardService::class, function($app){
            return new DashboardService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
