<?php

namespace Modules\ViewerModule\Services;

class ViewerService
{
    public function performAction($params = null)
    {
    }

    public function view($resource, $modified)
    {
        try {
            // get resource from XDAM
            // $resource = [
            //     'id' => $resource->id,
            //     'lang' => 'Resource Name',
            //     'blocks' => [],
            //     'lang' => 'es',
            //     'title' => 'demo',
            //     'sections' => [

            //     ]
            // ];
            
            $data = [
                'resource' => $resource,
                'dyslexic_level' => false,
                'tda_level' => false,
                'lang' => $resource['lang'],
                'modified' => [],
                'modified_ids' => [],
                'deleted_ids' => [],
                'added_ids' => []
            ];

            return response()->view('resource_viewer', $data);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource view failed', 'error' => $e->getMessage()], 500);
        }
    }
}
