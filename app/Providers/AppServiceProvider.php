<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind("APP_CONFIG", function () {
            return config('app'); //file name then key name // if just app we return all keys
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
