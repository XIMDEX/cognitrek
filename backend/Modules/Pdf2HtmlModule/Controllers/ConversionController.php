<?php

namespace Modules\Pdf2HtmlModule\Controllers;

use App\Http\Controllers\Controller;

class ConversionController extends Controller
{
    public function conversion()
    {
        return response()->json(['status' => 'ok']);
        try {
            $resourceId = request()->route('resource_id');
            // get resourcef from XDAM
            $resource = False;
            if ($resource) {

                $output = 'Resource converted successfully';
            } else {
                throw new \Exception('Resource not found');
            }
            return response()->json(['message' => 'Resource converted successfully', 'output' => $output]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource conversion failed', 'error' => $e->getMessage()], 500);
        }
    }
}
