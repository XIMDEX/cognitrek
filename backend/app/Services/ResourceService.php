<?php

namespace App\Services;

use App\Models\Resource;
use Illuminate\Support\Str;

class ResourceService
{
    public function create(array $data): Resource
    {
        $resource = new Resource();
        $resource->xdam_id = $data['xdam_id'];
        $resource->content = $data['content'];
        $resource->resume = $data['resume'] ?? null;
        $resource->conceptual_map = $data['conceptual_map'] ?? null;
        $resource->save();

        return $resource;
    }

    public function getById(string $id): ?Resource
    {
        return Resource::find($id);
    }

    public function getByXdamId(string $xdamId): ?Resource
    {
        return Resource::where('xdam_id', $xdamId)->first();
    }

    public function update(Resource $resource, array $data): Resource
    {
        $resource->update($data);
        return $resource;
    }

    public function delete(string $id): bool
    {
        $resource = Resource::find($id);
        if ($resource) {
            return $resource->delete();
        }
        return false;
    }

    public function getContent($resource) 
    {
        try {
            $content = $this->getFileContent($resource->content);
            $json = json_decode($content, true);
            return $json;
        } catch (\Throwable $th) {
            throw new \Exception('file content not found');
        }
    }

    public function getResume($resource) 
    {
        try {
            $content = $this->getFileContent($resource->resume);
            return $content;
        } catch (\Throwable $th) {
            throw new \Exception('file content not found');
        }
    }

    public function getConceptualMap($resource) 
    {
        try {
            $content = $this->getFileContent($resource->conceptual_map);
            return $content;
        } catch (\Throwable $th) {
            throw new \Exception('file content not found');
        }
    }

    private function getFileContent($path)
    {
        try {
            $path = $path;
            $content = file_get_contents($path);
            return $content;
        } catch (\Throwable $th) {
            throw new \Exception('file content not found');
        }
    }
}