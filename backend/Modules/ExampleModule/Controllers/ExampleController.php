<?php

namespace Modules\ExampleModule\Controllers;

use App\Http\Controllers\Controller;

class ExampleController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Hello from ExampleModule module']);
    }
}
