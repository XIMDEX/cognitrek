<?php

namespace App\Http\Controllers;

use App\Http\Services\Ximdex\XDamService;
use App\Models\Condition;
use App\Services\ConditionService;
use App\Services\ResourceService;
use Illuminate\Http\Request;
use App\Services\VariantService;
use Symfony\Component\HttpFoundation\Response;

class VariantController extends Controller
{
    protected $variantService;
    protected $resourceService;
    protected $xDamService;
    protected $conditionService;

    public function __construct(VariantService $variantService, ResourceService $resourceService, XDamService $xDamService, ConditionService $conditionService)
    {
        $this->variantService = $variantService;
        $this->resourceService = $resourceService;
        $this->xDamService = $xDamService;
        $this->conditionService = $conditionService;
    }

    public function index()
    {
        $variants = $this->variantService->getAll();
        return response()->json($variants);
    }

    public function getResourceVariants($resourceID)
    {
        $resource = $this->resourceService->getByXdamId($resourceID);
        if (!$resource) {
            throw new \Exception('Resource not found');
        }
        $variants = $this->variantService->getAllByResourceOrdered($resource->id);

        if (!$variants) $variants = [];
        return response()->json($variants);
    }

    public function store(Request $request)
    // public function store(Request $request, $resourceID)
    {
        try {

            // $validated = $request->validate([
            //     'resource_id' => 'required|string',
            //     'conditions' => 'required|array',
            //     'content' => 'required|string',
            // ]);
            $resourceID = '9df6f257-4ad4-44a6-b3ca-6dc97216b8ca';
    
            // $params = $this->xDamService->getResource($resourceID);
            $resource = $this->resourceService->getByXdamId($resourceID);
            $json = $this->resourceService->getContent($resource);
            $language = 'es';// $json['language'];
    
            $json_pages = [];
    
            foreach ($json['sections'] as $section) {
                $page = ['page' => $section['page'], 'blocks' => []];
                foreach ($section['blocks'] as $block) {
                    if ($block['type'] === 'text') {
                        $page['blocks'][] = $block;
                    }
                }
                $json_pages[] = $page;
            }
    
            if (!$resource) {
                throw new \Exception('Resource not found');
            }
    
            $validated = [
                'resource_id' => $resourceID,
                'conditions' => [39, 57],
                'label' => 'Demo variant dyslexia low + user',
                'type' => 'content',
                'user_data' => ''
            ];
    
            if (count($validated['conditions']) === 0) {
                throw new \Exception('Conditions not found');
            }
    
            $conditions = $this->conditionService->getManyByIds($validated['conditions']);
            $variants = $this->variantService->getAllByResourceLabel($resourceID, $validated['label']);
    
            if (count($variants) > 0) {
                // Add adaptation to $json
    
            }
    
            if ($conditions->count() !== count($validated['conditions'])) {
                throw new \Exception('Condition not found');
            }
    
            $user_condition = $conditions->filter(function ($item) {
                return $item->type === 'user';
            })->first();
    
            $conditions = $conditions->reject(function ($item) {
                return $item->type === 'user';
            });
    
            if ($user_condition) {
                $validated['conditions'] = array_filter($validated['conditions'], function($item) use ($user_condition) {
                    return $item !== $user_condition->id;
                });
            }

            if ($user_condition && $validated['user_data']) {
                //* Process combination $content + user_data modification
                $new_content = [];
                
                //* Create new variant
                $this->variantService->create([
                    'resource_id' => $resource->id,
                    'condition_id' => $user_condition->id,
                    'content' => json_encode($new_content),
                    'type' => 'content',
                    'label' => $validated['label'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            foreach ($conditions as $condition) {
                if (!$condition) {
                    throw new \Exception('Condition not found');
                }
    
                $validated['conditions'] = array_filter($$validated['conditions'], function($item) use ($condition) {
                    return $item !== $condition->id;
                });
    
                $data = [
                    'data' => [
                        'prompt' => $condition->type,
                        'resource' => $json_pages,
                        'lang' => $language,
                    ],
                    'id' => $resourceID,
                    'lang' => $language,
                    'action' => 'adaptation'
                ];
    
                $adaptation = $this->useService('llm_service', $data);
    
                $this->variantService->create([
                    'resource_id' => $resource->id,
                    'condition_id' => $condition->id,
                    'content' => json_encode($adaptation['content']),
                    'type' => 'content',
                    'proccessing_id' => $adaptation['id'] ? $validated : $adaptation['content'],
                    'label' => $validated['label'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    
                if ($adaptation['id']) {
                    throw new \Exception('processing');
                }
            }
    
            $variant  = '';
            // $variant = $this->variantService->create($validated);
            return response()->json($variant, 201);
        } catch (\Exception $e) {
            if ($e->getMessage() == 'processing') {
                return response()->json(['status' => 'processing'], Response::HTTP_ACCEPTED);
            } else {
                return response()->json(['status' => 'failed'], Response::HTTP_BAD_REQUEST);
            }
        }
    }

    public function getByResourceAndCondition(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|string',
            'condition_id' => 'required|string',
        ]);

        $variant = $this->variantService->getByResourceAndCondition($validated['resource_id'], $validated['condition_id']);
        if (!$variant) {
            return response()->json(['error' => 'Variant not found'], 404);
        }
        return response()->json($variant);
    }

    public function getAllByResourceLabel(Request $request) 
    {

    }

    public function destroy($id)
    {
        if ($this->variantService->delete($id)) {
            return response()->json(['message' => 'Variant deleted successfully']);
        }
        return response()->json(['error' => 'Variant not found'], 404);
    }
}
