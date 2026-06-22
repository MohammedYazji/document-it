<?php

namespace App\Providers;

use App\Listeners\IncrementPostViews;
use App\Models\Category;
use App\Models\Post;
use App\Observers\CategoryObserver;
use App\Observers\PostObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
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

        JsonResource::withoutWrapping();


        // so instead of write multiple lines of permissions so will use ...
        // Gate::define('users.index', function ($user) : bool
        // {
        //     return True;
        // });
        // Gate::define('users.create', function ($user) : bool
        // {
        //     return True;
        // });
        // Gate::define('users.update', function ($user) : bool
        // {
        //     return false;
        // });
        // Gate::define('users.delete', function ($user) : bool
        // {
        //     return false;
        // });

        foreach (config('abilities') as $ability => $label) {
            Gate::define("users.{$ability}", function ($user) use ($ability) {
                return $user->roles()
                    ->whereJsonContains('abilities', $ability)
                    ->exists();
            });
        }
    }
}
