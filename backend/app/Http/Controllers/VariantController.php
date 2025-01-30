<?php

namespace App\Http\Controllers;

use App\Http\Services\Ximdex\XDamService;
use App\Jobs\LLMBatchProcessor;
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

    public function store(Request $request, $resourceID)
    {
        try {

            $validated = $request->validate([
                'resource_id' => 'string',
                'conditions' => 'required|array',
                'content' => 'required|string',
                'user_data' => 'array'
            ]);

            $resourceID = $validated['resource_id'] ?? $resourceID;

            $resource = $this->resourceService->getByXdamId($resourceID);
            $json = $this->resourceService->getContent($resource);
            $language = $json['language'];

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
                'user_data' => []
            ];

            if (count($validated['conditions']) === 0) {
                throw new \Exception('Conditions not found');
            }

            $conditions = $this->conditionService->getManyByIds($validated['conditions']);
            $variants = $this->variantService->getAllByResourceLabel($resource->id, $validated['label']);

            $any_processing = $variants->reject(function($v) {
                return $v->proccessing_id;
            });


            if ($conditions->count() !== count($validated['conditions'])) {
                throw new \Exception('Condition not found');
            }

            $user_condition = $conditions->filter(function ($item) {
                return $item->type == 'User' || $item->type === 'user';
            })->first();


            if ($any_processing->count() == 0 && $user_condition && is_array($validated['user_data'])) {

                $uservariant =$variant_user = $this->variantService->create([
                    'resource_id' => $resource->id,
                    'condition_id' => $user_condition->id,
                    'content' => json_encode($validated['user_data']),
                    'type' => 'content',
                    'label' => $validated['label'],
                    'proccessing_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($uservariant) {
                    $conditions = $conditions->reject(function($c) use ($user_condition) {
                        return $c->id == $user_condition->id;
                    });
                }
            }

            $variants = collect(isset($variant_user) ? [$variant_user] : []);

            LLMBatchProcessor::dispatch('llm_service', [
                'data' => [
                    'lang' => $language,
                    'id' => $resource->id,
                    'dam_id' => $resourceID,
                    'action' => 'adaptation',
                    'data' => [
                        'prompt' => '',
                        'resource' => [],
                        'lang' => $language
                        ]
                    ],
                'action' => 'adaptation',
                'validated' => $validated,
                'done' => $variants->pluck('id')->toArray(),
                'todo' => $conditions->pluck('id')->toArray()
            ])->onConnection('database');

            return response(['status' => 'proccessing'], 201);
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
