<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        // Konfigurasi rate limiting
        $this->configureRateLimiting();

        // Definisikan routes
        $this->routes(function () {
            // Routes untuk API
            Route::middleware('api')
                ->prefix('api') // Prefix URL: /api
                ->group(base_path('routes/api.php')); // Load file routes/api.php

            // Routes untuk Web
            Route::middleware('web')
                ->group(base_path('routes/web.php')); // Load file routes/web.php
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        // Rate limiting untuk API
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
