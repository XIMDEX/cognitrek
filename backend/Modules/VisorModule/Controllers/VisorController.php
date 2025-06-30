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
            $json = $request->boolean('json', false);
            $edit_mode = $request->boolean('edit_mode', false);
            $variant_label = $request->input('variant', false);
            if ($variant_label) $variant_label = urldecode($variant_label);
            $service  = $this->getService('visor_service');
            $resource = $this->resourceService->getByXdamId($resourceId);

            if (!$resource) {
                throw new \Exception('Resource not found');
            }
            $is_proccessing = false;
            if ($variant_label) {
                $variants_label = $this->variantService->getAllByResourceLabel($resource->id, $variant_label);
                $is_proccessing = $variants_label->some(function($v) {return isset($v->proccessing_id);});
            }
        
            if ($is_proccessing && $edit_mode) $edit_mode = false;
            $variants = $this->variantService->getAllByResourceOrdered($resource->id);
            $conditions_collection = $this->conditionService->getAll();

            if (!$variants) $variants = [];

            $content = $this->resourceService->getContent($resource);

            $content['lang'] = $content['language'];
            $content['id'] = $resourceId;

            $conditions_variant = [];
            $processing = [];
       
            if ($variant_label && $variants_label) {
                $sections = $content['sections'];

                foreach ($variants_label as $vl) {
                    $content_variant = json_decode($vl->content, true);
                    if (!isset($content_variant['data'])) {
                        $sections = $this->variantService->adaptHTML($sections, $content_variant, $this->conditionService->getById($vl->condition_id)->label, $vl->condition_id);
                    } else {
                        $processing[] = $vl->condition_id;
                        $content['processing'] = true;
                    }
                    $conditions_variant[] = $vl->condition_id;
                }
                $content['sections'] = $sections;
            }
            $conditions = [];
           
            foreach ($conditions_collection as $cd) {
                $data_cond = [
                    'name' => $cd->label,
                    'id' => $cd->id,
                    'selected' => in_array($cd->id, $conditions_variant),
                    'type' => $cd->type
                ];
                if (in_array($cd->id, $processing)) {
                    $data_cond['processing'] = true;
                }
                $conditions[] = $data_cond;
            }
            $variants_grouped = $variants->groupBy('label')->map(function ($items, $label) use ($variant_label, $processing) {
                $is_selected = $variant_label == $label;
                return [
                    'label'      => $label . (count($processing) > 0 ? ' - Processing...' : ''),
                    'conditions' => $items->pluck('condition_id')->unique()->values()->all(),
                    'selected' => $is_selected,
                    'procesing' => count($processing) > 0
                ];
            })->values()->all();

            $variants_grouped = array_merge([['label' => 'Original', 'conditions' => [], 'selected' => !$variant_label]], $variants_grouped);
            return $service->visor($content, $variants_grouped, $conditions, $edit, $edit_mode, $json);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource view failed in file ' . $e->getFile() . ' at line ' . $e->getLine() . ': ' . $e->getMessage()], 500);
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


            if ($variant_label && $variants_label) {
                $sections = $content['sections'];
                foreach ($variants_label as $vl) {
                    $content = json_decode($vl->content);
                    $sections = $this->variantService->adaptHTML($sections, $content, $this->conditionService->getById($vl->condition_id)->label, $vl->condition_id);
                }
                $content['sections'] = $sections;
            }

            return $service->preview($content, $variants);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource preview failed', 'error' => $e->getMessage()], 500);
        }

    }
}
