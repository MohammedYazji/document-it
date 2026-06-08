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
        \Illuminate\Pagination\Paginator::useTailwind();

        \Illuminate\Support\Facades\Event::listen(
            'posts.view',
            \App\Listeners\IncrementPostViews::class
        );
    }
}
