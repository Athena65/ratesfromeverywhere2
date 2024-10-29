<?php

namespace App\Providers;

use App\Models\UserRating;
use App\Observers\UserRatingObserver;
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
        UserRating::observe(UserRatingObserver::class);
    }
}
