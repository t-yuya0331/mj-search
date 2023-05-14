<?php

namespace App\Providers;

use Facade\Ignition\Solutions\UseDefaultValetDbCredentialsSolution;
use Illuminate\Pagination\Paginator;
use Predis\Predis;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

    }
}
