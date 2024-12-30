<?php

namespace Modules\ViewerModule\Controllers;

use App\Http\Controllers\Controller;

class ViewerController extends Controller
{
    public function view()
    {
        
        return response()->json(['message' => 'Hello from ViewerModule module']);
    }
}
