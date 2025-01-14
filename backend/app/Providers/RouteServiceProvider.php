<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        parent::boot();

        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapWebRoutes();
            $this->mapApiRoutes();
            $this->loadModuleRoutes();
        });
    }

    /**
     * Define the "web" routes for the application.
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Dynamically load module routes (web and api).
     */
    protected function loadModuleRoutes()
    {
        $modulesPath = base_path('Modules');

        if (!File::exists($modulesPath)) {
            return;
        }

        $modules = File::directories($modulesPath);

        if (empty($modules)) {
            return;
        }

        foreach ($modules as $modulePath) {
            $moduleName = basename($modulePath);

            $webRoutes = "$modulePath/Routes/web.php";
            if (file_exists($webRoutes)) {
                Route::middleware('web')
                    ->namespace("Modules\\$moduleName\\Controllers")
                    ->group($webRoutes);
            }

            $apiRoutes = "$modulePath/Routes/api.php";
            if (file_exists($apiRoutes)) {
                Route::prefix('api/v1')
                    ->middleware('api')
                    ->namespace("Modules\\$moduleName\\Controllers")
                    ->group($apiRoutes);
            }
        }
    }

    /**
     * Configure the rate limiting for the application.
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('health-check', function () {
            return Limit::none();
        });
    }
}