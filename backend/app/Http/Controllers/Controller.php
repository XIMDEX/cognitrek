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

    public function useService($serviceName, $params)
    {
        try {
            $moduleService = ModuleServiceHelper::getService($serviceName);
    
            if ($moduleService) {
                return $moduleService->performAction($params);
            }
        } catch (ServiceNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function getService($serviceName)
    {

        try {
            $moduleService = ModuleServiceHelper::getService($serviceName);
            return $moduleService;
        } catch (ServiceNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
