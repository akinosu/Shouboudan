<?php

namespace App\Providers;

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
        $this->app->bind('App\Services\TwitterService');
        $this->app->bind('App\Services\PostService');
        $this->app->bind('App\Services\NiceService');
        $this->app->bind('App\Services\CityService');
        $this->app->bind('App\Services\UserService');
        $this->app->bind('App\Services\CommentService');
        $this->app->bind('App\Repositories\PostRepositoryInterface', 'App\Repositories\PostRepository');
        $this->app->bind('App\Repositories\NiceRepositoryInterface', 'App\Repositories\NiceRepository');
        $this->app->bind('App\Repositories\CityRepositoryInterface', 'App\Repositories\CityRepository');
        $this->app->bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\UserRepository');
        $this->app->bind('App\Repositories\CommentRepositoryInterface', 'App\Repositories\CommentRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
