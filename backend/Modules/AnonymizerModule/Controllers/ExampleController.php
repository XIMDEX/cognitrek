<?php

namespace Modules\AnonymizerModule\Controllers;

use App\Http\Controllers\Controller;

class ExampleController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Hello from AnonymizerModule module']);
    }
}
