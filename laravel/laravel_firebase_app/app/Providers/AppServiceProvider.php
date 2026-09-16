<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Auth\FirebaseFarmerUserProvider;
use App\Auth\GuestUserProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('user', Auth::user());
        });

        Auth::provider('firebase', function ($app, array $config) {
            return new FirebaseFarmerUserProvider($app->make('App\Services\FarmerService'));
        });

        Auth::provider('guest', function ($app, array $config) {
            return new GuestUserProvider();
        });
    }
}
