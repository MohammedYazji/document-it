<?php

namespace App\Providers;

use App\Listeners\IncrementPostViews;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\PostObserver;
use App\Policies\UserPolicy;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('APP_CONFIG', function () {
            return config('app'); // file name then key name // if just app we return all keys
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Paginator::useTailwind();

        Event::listen(
            'posts.view',
            IncrementPostViews::class
        );

        Post::observe(PostObserver::class);
        Category::observe(CategoryObserver::class);

        JsonResource::withoutWrapping();

        Gate::policy(User::class, UserPolicy::class);

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

        // to make the super-admin jump over the permissions check so will jump over it and has all abilities no worry
        Gate::before(function ($user, $ability) {
            if ($user->type === 'super-admin') {
                return true;
            }
        });

        foreach (config('abilities') as $ability => $label) {
            Gate::define("users.{$ability}", function ($user) use ($ability) {
                return $user->roles()
                    ->whereJsonContains('abilities', $ability)
                    ->exists();
            });
        }
    }
}
