<?php

namespace App\Providers;

use App\Listeners\IncrementPostViews;
use App\Models\Category;
use App\Models\Post;
use App\Observers\CategoryObserver;
use App\Observers\PostObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
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
        Paginator::useTailwind();

        Event::listen(
            'posts.view',
            IncrementPostViews::class
        );

        Post::observe(PostObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
