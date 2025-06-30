<?php

namespace App\Http\Controllers;

use App\Http\Services\Ximdex\XDamService;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Services\ResourceService;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    protected $resourceService;
    protected $xDamService;

    public function __construct(ResourceService $resourceService, XDamService $xDamService)
    {
        $this->resourceService = $resourceService;
        $this->xDamService = $xDamService;
    }

    public function index()
    {
        return response()->json(Resource::all());
    }

    public function store(Request $request, $resourceID)
    {
        $validated = [
            'xdam_id' => $resourceID,
        ];

        $this->xDamService->setToken($request->bearerToken());

        Storage::makeDirectory("public/".$resourceID);
        $params = $this->xDamService->getResource($resourceID);
        try {
            $validated['resume'] = storage_path("app/public/$resourceID/resume.txt");
            $validated['conceptual_map'] = storage_path("app/public/$resourceID/conceptual_map.md");
            $validated['content'] = storage_path("app/public/$resourceID/raw.json");

            $resource = $this->resourceService->create($validated);
            $output = $this->useService('conversion_service', $params);

            if (!$output['success']) {
                throw new \Error(json_encode($output));
            }

            $json = file_get_contents($validated['content']);
            $json = json_decode($json, true);
            $json['language'] = $params['lang'];
            file_put_contents($validated['content'], json_encode($json));

            $data = [
                'data' => storage_path("app/public/$resourceID/raw.md"),
                'id' => $resourceID,
                'lang' => $params['lang'],
                'action' => 'all'
            ];

            $this->useService('llm_service', $data);


            return response()->json($resource, 201);

        } catch (\Exception $exc) {
            throw $exc;
        }
    }

    public function show($id)
    {
        $resource = $this->resourceService->getByXdamId($id);
        if (!$resource) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        $content = $this->resourceService->getContent($resource);
        $resume = $this->resourceService->getResume($resource);
        $conceptual_map = $this->resourceService->getConceptualMap($resource);
        $resource->content= $content;
        $resource->resume= $resume;
        $resource->conceptual_map= $conceptual_map;
        return response()->json($resource);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'resume' => 'nullable|string',
            'conceptual_map' => 'nullable|string',
        ]);

        $resource = $this->resourceService->getById($id);
        if (!$resource) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        $updatedResource = $this->resourceService->update($resource, $validated);
        return response()->json($updatedResource);
    }

    public function destroy($id)
    {
        if ($this->resourceService->delete($id)) {
            return response()->json(['message' => 'Resource deleted successfully']);
        }
        return response()->json(['error' => 'Resource not found'], 404);
    }

    public function resume($id) {

        $resource = $this->resourceService->getByXdamId($id);
        if (!$resource) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        $resume = $this->resourceService->getResume($resource);
        return response()->json(['summary' => $resume]);
    }

    public function conceptualmap($id) {

        $resource = $this->resourceService->getByXdamId($id);
        if (!$resource) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        $conceptual_map = $this->resourceService->getConceptualMap($resource);
        return response()->json(['conceptual_map' => $conceptual_map]);
    }

    public function regenerate_resume(Request $request, $id) {
        $resource = $this->resourceService->getByXdamId($id);
        if (!$resource) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        $modified_patn = $this->get_modified_content($id);

        $data = [
            'md' => $modified_patn,
            'id' => $id,
            'lang' => $resource->language,
            'action' => 'resume'
        ];
        $this->useService('llm_service', $data);
        $resume = $this->resourceService->getResume($resource);
        return response()->json(['summary' => $resume]);
    }

    public function regenerate_conceptualmap(Request $request, $id) {
        $resource = $this->resourceService->getByXdamId($id);
        if (!$resource) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        $modified_patn = $this->get_modified_content($id);

        $data = [
            'md' => $modified_patn,
            'id' => $id,
            'lang' => $resource->language,
            'action' => 'conceptual_map'
        ];
        $this->useService('llm_service', $data);
        $conceptual_map = $this->resourceService->getConceptualMap($resource);
        return response()->json(['conceptual_map' => $conceptual_map]);
    }

    public function get_modified_content($id) {

        // TODO - get the modified content with adaptations

        return storage_path("app/public/$id/raw.md");
    }
}
