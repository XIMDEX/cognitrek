<?php

namespace Modules\AuthXdirModule\Controllers;

use App\Http\Controllers\Controller;

class ExampleController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Hello from AuthXdirModule module']);
    }
}
