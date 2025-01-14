<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ConditionService;

class ConditionController extends Controller
{
    protected $conditionService;

    public function __construct(ConditionService $conditionService)
    {
        $this->conditionService = $conditionService;
    }

    public function index()
    {
        return response()->json($this->conditionService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
        ]);

        $condition = $this->conditionService->create($validated['type']);
        return response()->json($condition, 201);
    }
}