<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->loadModuleConfigurations();
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->registerModuleServices();
    }

    /**
     * Dynamically load configurations for each module.
     */
    protected function loadModuleConfigurations()
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
            $configFile = "$modulePath/Config/config.php";

            if (file_exists($configFile)) {
                $moduleName = basename($modulePath);
                $this->mergeConfigFrom($configFile, $moduleName);
            }
        }
    }

    /**
     * Dynamically register services from each module.
     */
    protected function registerModuleServices()
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
            $configFile = "$modulePath/Config/config.php";

            if (file_exists($configFile)) {
                $config = require $configFile;

                if (!empty($config['services'])) {
                    foreach ($config['services'] as $key => $service) {
                        $this->app->singleton($key, $service);
                    }
                }
            }
        }
    }
}