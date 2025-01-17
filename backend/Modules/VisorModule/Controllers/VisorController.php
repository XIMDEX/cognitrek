<?php

namespace Modules\VisorModule\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ResourceService;
use App\Services\VariantService;
use Illuminate\Support\Facades\Request;

class VisorController extends Controller
{
    private $resourceService;
    private $variantService;

    public function __construct(ResourceService $resourceService, VariantService $variantService)
    {
        $this->resourceService = $resourceService;
        $this->variantService = $variantService;
    }
    
    public function visor(Request $request, $resourceId)
    {
        try {
            $service  = $this->getService('visor_service');
            $resource = $this->resourceService->getByXdamId($resourceId);
            if (!$resource) {
                throw new \Exception('Resource not found');
            }

            $variants = $this->variantService->getAllByResourceOrdered($resource->id);

            if (!$variants) $variants = [];

            $content = $this->resourceService->getContent($resource);
            $content['lang'] = $content['language'];
            $content['id'] = $resourceId;
            

            return $service->visor($content, $variants);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource view failed', 'error' => $e->getMessage()], 500);
        }
    }


    public function preview(Request $request, $resourceId)
    {
        try {
            $service  = $this->getService('visor_service');
            $resource = $this->resourceService->getByXdamId($resourceId);
            if (!$resource) {
                throw new \Exception('Resource not found');
            }

            $variants = $this->variantService->getAllByResourceOrdered($resource->id);

            if (!$variants) $variants = [];

            $content = $this->resourceService->getContent($resource);
            $content['lang'] = $content['language'];
            $content['id'] = $resourceId;
            

            return $service->preview($content, $variants);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource preview failed', 'error' => $e->getMessage()], 500);
        }
    }
}
