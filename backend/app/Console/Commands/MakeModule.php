<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Create a new module with the basic structure';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $moduleName = $this->argument('name');
        $moduleSlug = str_replace('Module', '', $moduleName);
        $moduleSlug = Str::kebab($moduleSlug); 
        $modulePath = base_path("Modules/$moduleName");

        if (File::exists($modulePath)) {
            $this->error("The module '$moduleName' already exists.");
            return 1;
        }
        File::makeDirectory($modulePath, 0755, true);
        File::makeDirectory("$modulePath/Routes", 0755, true);
        File::makeDirectory("$modulePath/Controllers", 0755, true);
        File::makeDirectory("$modulePath/Services", 0755, true);
        File::makeDirectory("$modulePath/Models", 0755, true);
        File::makeDirectory("$modulePath/Config", 0755, true);

        File::put("$modulePath/Routes/web.php", $this->getWebRoutesTemplate($moduleSlug));
        File::put("$modulePath/Routes/api.php", $this->getApiRoutesTemplate($moduleSlug));
        File::put("$modulePath/Controllers/ExampleController.php", $this->getControllerTemplate($moduleName));
        File::put("$modulePath/Services/ExampleService.php", $this->getServiceTemplate($moduleName));
        File::put("$modulePath/Config/config.php", $this->getConfigTemplate($moduleName));
        File::put("$modulePath/dependencies.txt", $this->getDependenciesTemplate($moduleName));

        exec('composer dump-autoload');

        // Inform the user that the module was created successfully
        $this->info("Module '$moduleName' created successfully with slug '$moduleSlug'.");

        return 0;
    }

    /**
     * Template for the web.php file.
     */
    private function getWebRoutesTemplate($moduleSlug)
    {
        return "<?php\n\nuse Illuminate\Support\Facades\Route;\n\n// Web routes for the $moduleSlug module\nRoute::group(['prefix' => '$moduleSlug'], function() {\n    // Define your web routes here\n});\n";
    }

    /**
     * Template for the api.php file.
     */
    private function getApiRoutesTemplate($moduleSlug)
    {
        return "<?php\n\nuse Illuminate\Support\Facades\Route;\n\n// API routes for the $moduleSlug module\nRoute::group(['prefix' => '$moduleSlug'], function() {\n    // Define your API routes here\n});\n";
    }

    /**
     * Template for the controller file.
     */
    private function getControllerTemplate($moduleName)
    {
        return "<?php\n\nnamespace Modules\\$moduleName\\Controllers;\n\nuse App\Http\Controllers\Controller;\n\nclass ExampleController extends Controller\n{\n    public function index()\n    {\n        return response()->json(['message' => 'Hello from $moduleName module']);\n    }\n}\n";
    }

    /**
     * Template for the service file.
     */
    private function getServiceTemplate($moduleName)
    {
        return "<?php\n\nnamespace Modules\\$moduleName\\Services;\n\nclass ExampleService\n{\n    public function performAction(\$params = null)\n    {\n        return 'Action performed by $moduleName service';\n    }\n}\n";
    }

    /**
     * Template for the model file.
     */
    private function getDependenciesTemplate($moduleName)
    {
        return "// Add dependencies required and install on root project\n\n";
    }

    /**
     * Template for the config file.
     */
    private function getConfigTemplate($moduleName)
    {
        return <<<PHP
<?php

return [
    // General configurations for the module
    'name' => '$moduleName',
    'version' => '1.0.0',

    // Register services
    'services' => [
        'example_service' => \Modules\\$moduleName\Services\ExampleService::class,
    ],
];
PHP;
    }

}