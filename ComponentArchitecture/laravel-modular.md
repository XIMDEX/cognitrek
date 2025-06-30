# Modular Implementation in Laravel

This guide explains how to implement a modular system in a Laravel application. Each module is independent, with its own routes, controllers, services, and configuration files.

## Steps to Implement

1. Directory Structure

    Create a Modules directory at the root of your Laravel project. Each module should follow this structure:

    ```
    Modules/
        ExampleModule/
            Config/
                config.php
            Controllers/
                ExampleController.php
            Routes/
                web.php
                api.php
            Services/
                ExampleService.php
            Models/
                ExampleModel.php
    ```

2. Modify RouteServiceProvider

    Add the following method to dynamically load module routes:

    ```PHP
    protected function loadModuleRoutes()
    {
        $modulesPath = base_path('Modules');
        if (!File::exists($modulesPath)) {
            return;
        }

        $modules = File::directories($modulesPath);

        foreach ($modules as $modulePath) {
            $moduleName = basename($modulePath);

            // Load web routes
            $webRoutes = "$modulePath/Routes/web.php";
            if (file_exists($webRoutes)) {
                Route::middleware('web')
                    ->namespace("Modules\\$moduleName\\Controllers")
                    ->group($webRoutes);
            }

            // Load API routes
            $apiRoutes = "$modulePath/Routes/api.php";
            if (file_exists($apiRoutes)) {
                Route::prefix('api/v1')
                    ->middleware('api')
                    ->namespace("Modules\\$moduleName\\Controllers")
                    ->group($apiRoutes);
            }
        }
    }
    ```

    Call this method in boot: `$this->loadModuleRoutes();`

3. Modify AppServiceProvider

    Add the following method to dynamically load module configurations:

    ```PHP
    protected function loadModuleConfigurations()
    {
        $modulesPath = base_path('Modules');

        if (!File::exists($modulesPath)) {
            return;
        }

        $modules = File::directories($modulesPath);

        foreach ($modules as $modulePath) {
            $configFile = "$modulePath/Config/config.php";

            if (file_exists($configFile)) {
                $moduleName = basename($modulePath);
                $this->mergeConfigFrom($configFile, $moduleName);
            }
        }
    }
    
    protected function loadViews()
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
            $viewsPath = "$modulePath/Views";

            if (file_exists($viewsPath)) {
                $moduleName = strtolower(basename($modulePath));
                $moduleName = str_replace('module', '', $moduleName);
                $this->loadViewsFrom($viewsPath, $moduleName);
            }
        }
    }

    ```

    Call this methods in boot: 
    
    ```PHP
        $this->loadModuleConfigurations();
        $this->loadViews();
    ```

4. Add Autoload for Module Classes

    In composer.json, add the following to the autoload section:

    ```JSON
    "psr-4": {
        "Modules\\": "Modules/"
    }
    ```

    Run:

    ```SHELL
    composer dump-autoload
    ```

5. Example Module

    5.1. Routes

    * Modules/ExampleModule/Routes/web.php

        ```PHP
        <?php

        use Illuminate\Support\Facades\Route;

        Route::group(['prefix' => 'example'], function () {
            Route::get('/', 'ExampleController@index');
        });
        ```

    * Modules/ExampleModule/Routes/api.php

        ```PHP
        <?php

        use Illuminate\Support\Facades\Route;

        Route::group(['prefix' => 'example'], function () {
            Route::get('/', 'ExampleController@apiIndex');
        });
        ```

    5.2. Configuration

    * Modules/ExampleModule/Config/config.php

        ```PHP
        <?php

        return [
            'name' => 'ExampleModule',
            'version' => '1.0.0',
        ];
        ```

        Access it using: `config('ExampleModule.name');`

    5.3. Controller

	* Modules/ExampleModule/Controllers/ExampleController.php

        ```PHP
        <?php

        namespace Modules\ExampleModule\Controllers;

        use App\Http\Controllers\Controller;

        class ExampleController extends Controller
        {
            public function index()
            {
                return view('welcome');
            }

            public function apiIndex()
            {
                return response()->json(['message' => 'Hello from ExampleModule API']);
            }
        }
        ```

        Usage:

        1.	Access Routes:
            * http://yourapp.com/example (web routes)
            * http://yourapp.com/api/example (API routes)
        2.	Access Configuration: `$moduleName = config('ExampleModule.name');`
        3.	Call Controllers: Define routes in web.php or api.php to call module controllers `Route::get('/example', [ExampleController::class, 'index']);`

## Create new Module: **MakeModule Command**

The make:module command automates the creation of a new module in your Laravel application. This command generates the required directory structure and files for a module, such as routes, controllers, services, models, and configuration files. It helps streamline the development process and ensures consistent module structure.


### Usage Example

* **Step 1:** Run the Command

    Create a new module named Blog: `php artisan make:module Blog`

* **Step 2**: Generated Files

    The command creates the following structure:

    ```
    Modules/
        Blog/
            Config/
                config.php
            Controllers/
                ExampleController.php
            Routes/
                web.php
                api.php
            Services/
                ExampleService.php
            Models/
                ExampleModel.php
    ```
* **Step 3**: Load mew module

    Run the following command after creating a module to update the autoloader: `composer dump-autoload`

* **Step 4**: Custom your Module

    Edit and modify your Module

### Key Benefits
1.	Consistency: Ensures all modules follow the same structure.
2.	Automation: Saves time by generating boilerplate files.
3.	Scalability: Simplifies the addition of new features through modular development.

