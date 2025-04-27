<?php

namespace App\Http\Controllers;

use App\Jobs\LLMBatchProcessor;
use App\Services\ConditionService;
use App\Services\ResourceService;
use App\Services\UserVariantService;
use Illuminate\Http\Request;
use App\Services\VariantService;
use Symfony\Component\HttpFoundation\Response;

class VariantController extends Controller
{
    protected $variantService;
    protected $userVariantService;
    protected $resourceService;
    protected $conditionService;

    public function __construct(
        VariantService $variantService,
        ResourceService $resourceService,
        ConditionService $conditionService,
        UserVariantService $userVariantService
    ) {
        $this->variantService = $variantService;
        $this->userVariantService = $userVariantService;
        $this->resourceService = $resourceService;
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
    {
        try {

            $validated = $request->validate([
                'resource_id' => 'string',
                'conditions' => 'required|array',
                'content' => 'required|string',
                'user_data' => 'array',
                'label' => 'required|string'
            ]);

            $resourceID = $validated['resource_id'];

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

    public function getResourceAdaptations(Request $request, $resourceID)
    {

        $resource = $this->resourceService->getByXdamId($resourceID);
        if (!$resource) {
            return response()->json([]);
        }

        $variants = $this->variantService->getAdaptations($resource->id);

        if (!$variants) $variants = [];
        return response()->json($variants);
    }

    public function getUserAdaptation(Request $request, $resourceID, $userID)
    {

        $resource = $this->resourceService->getByXdamId($resourceID);
        if (!$resource) {
            return response()->json([]);
        }
        $userHash = $this->useService('anonymizer_service', ['action' => 'encode', 'value' => $userID]);

        $user_adaptation = $this->userVariantService->getUserAdaptation($resource->id, $userHash);
        $available_adaptations = $this->variantService->getAdaptations($resource->id);

        foreach ($available_adaptations as $key => $available_adaptation) {
            $available_adaptations[$key]['selected'] = $user_adaptation && ($user_adaptation->variant_id === $available_adaptation->condition_id);
        }

        return response()->json($available_adaptations);
    }


    public function setUserAdaptation(Request $request, $resourceID, $userID)
    {
        $validated = $request->validate([
            'adaptation_id' => 'required|string',
        ]);
        if (!$validated) {
            return response()->json(['error' => 'Adaptation not found'], 404);
        }
        $resource = $this->resourceService->getByXdamId($resourceID);
        if (!$resource) {
            return response()->json([]);
        }

        $adaptationID = $validated['adaptation_id'];

        $userHash = $this->useService('anonymizer_service', ['action' => 'encode', 'value' => $userID]);
        $resource_adaptations = $this->variantService->search(['resource_id' => $resource->id, 'label' => $adaptationID])->first();


        $adaptation = $this->userVariantService->getUserAdaptation($resource->id, $userHash);

        if (!$resource_adaptations && $adaptation) {
            $adaptation->delete();
            return response()->json(['status' => 'unassigned'], 200);
        }

        if ($adaptation && $adaptation->variant_id !== $adaptationID) {
            $adaptation->variant_id = $adaptationID;
            $adaptation->save();
        } else {
            // $adaptation = $this->variantService->create([
            //     'resource_id' => $resource->id,
            //     'dam_id' => $resourceID,
            //     'label' => $resource_adaptations->label,
            //     'conditions' => $resource_adaptations->condition(),
            //     'user_id' => $userHash,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            //     'type' => 'content',
            //     'condition_id' => $resource_adaptations->condition_id
            // ]);
            $adaptation = $this->userVariantService->create([
                'variant_id' => $resource_adaptations->adaptation_id,
                'user_id' => $userHash
            ]);
            $adaptation->save();
        }

        if ($adaptation) {
            return response()->json([
                'data' => [
                    'resource_id' => $resource->id,
                    'label' => $adaptationID,
                    'user_id' => $userID,
                    'adaptation_id' => $adaptation->variant_id,
                    'created_at' => $adaptation['created_at']
                ]
            ], 201);
        }
        return response()->json(['error' => 'Error creating adaptation'], 500);

    }
}
