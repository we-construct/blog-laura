<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
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

        Relation::morphMap([
            'Post' => Post::class,
            'User'  => User::class,
            'Image' => PostImage::class,
        ]);
    }
}
