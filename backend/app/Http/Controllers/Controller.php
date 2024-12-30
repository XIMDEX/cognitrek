<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceNotFoundException;
use App\Helpers\ModuleServiceHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function useService($serviceName)
    {
        try {
            $exampleService = ModuleServiceHelper::getService($serviceName);
    
            if ($exampleService) {
                return $exampleService->performAction();
            }
        } catch (ServiceNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
