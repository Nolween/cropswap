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
        	// Register the BlogArticleRepositoryInterface with the BlogArticleRepositoryEloquent
        $this->app->bind(
            'App\Repositories\Interfaces\BlogArticleRepositoryInterface',
            'App\Repositories\Eloquent\BlogArticleRepositoryEloquent'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
