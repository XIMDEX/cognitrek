<?php

namespace Modules\Pdf2HtmlModule\Controllers;

use App\Http\Controllers\Controller;

class TransformController extends Controller
{
    public function transform()
    {
        return response()->json(['status' => 'ok']);
        try {
            $resourceId = request()->route('resource_id');
            // get resourcef from XDAM
            $resource = False;
            if ($resource) {

                $output = 'Resource transformed successfully';
            } else {
                throw new \Exception('Resource not found');
            }
            return response()->json(['message' => 'Resource transformed successfully', 'output' => $output]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource transformation failed', 'error' => $e->getMessage()], 500);
        }
    }
}
