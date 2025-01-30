<?php

namespace Modules\VisorModule\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ConditionService;
use App\Services\ResourceService;
use App\Services\VariantService;
use Illuminate\Http\Request;

class VisorController extends Controller
{
    private $resourceService;
    private $variantService;
    private $conditionService;

    public function __construct(ResourceService $resourceService, VariantService $variantService, ConditionService $conditionService)
    {
        $this->resourceService = $resourceService;
        $this->variantService = $variantService;
        $this->conditionService = $conditionService;
    }
    
    public function visor(Request $request, $resourceId)
    {
        try {
            $edit = $request->boolean('edit', false);
            $variant_label = $request->input('variant', false);
            $service  = $this->getService('visor_service');
            $resource = $this->resourceService->getByXdamId($resourceId);
            if (!$resource) {
                throw new \Exception('Resource not found');
            }

            if ($variant_label) {
                $variants_label = $this->variantService->getAllByResourceLabel($resource->id, $variant_label);
            }

            $variants = $this->variantService->getAllByResourceOrdered($resource->id);
            $conditions_collection = $this->conditionService->getAll();


            if (!$variants) $variants = [];

            $content = $this->resourceService->getContent($resource);
            $content['lang'] = $content['language'];
            $content['id'] = $resourceId;

            $conditions_variant = [];

            if ($variant_label && $variants_label) {
                $sections = $content['sections'];
                
                foreach ($variants_label as $vl) {
                    $content = json_decode($vl->content);
                    $sections = $this->variantService->adaptHTML($sections, $content);
                    $conditions_variant[] = $vl->condition_id;
                }
            }
            $conditions = [];
            foreach ($conditions_collection as $cd) {
                $conditions[] = [
                    'name' => $cd->label,
                    'id' => $cd->id,
                    'selected' => in_array($cd->id, $conditions_variant)
                ];
            }
            $variants_grouped = $variants->groupBy('label')->map(function ($items, $label) {
                return [
                    'label'      => $label,
                    'conditions' => $items->pluck('condition_id')->unique()->values()->all(),
                ];
            })->values()->all();
            return $service->visor($content, $variants_grouped, $conditions, $edit);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource view failed', 'error' => $e->getMessage()], 500);
        }
    }


    public function preview(Request $request, $resourceId)
    {
        try {
            $variant_label = $request->input('variant', false);
            
            $service  = $this->getService('visor_service');
            $resource = $this->resourceService->getByXdamId($resourceId);
            if (!$resource) {
                throw new \Exception('Resource not found');
            }

            if ($variant_label) {
                $variants_label = $this->variantService->getAllByResourceLabel($resource->id, $variant_label);
            }

            $variants = $this->variantService->getAllByResourceOrdered($resource->id);

            if (!$variants) $variants = [];

            $content = $this->resourceService->getContent($resource);
            $content['lang'] = $content['language'];
            $content['id'] = $resourceId;
            

            $sections = $content['sections'];
            foreach ($variants_label as $vl) {
                $content = json_decode($vl->content);
                $sections = $this->variantService->adaptHTML($sections, $content);
            }
            
            return $service->preview($content, $variants);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource preview failed', 'error' => $e->getMessage()], 500);
        }

    }
}
