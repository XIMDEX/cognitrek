<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VariantService;

class VariantController extends Controller
{
    protected $variantService;

    public function __construct(VariantService $variantService)
    {
        $this->variantService = $variantService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|string',
            'condition_id' => 'required|string',
            'content' => 'required|string',
        ]);

        $variant = $this->variantService->create($validated);
        return response()->json($variant, 201);
    }

    public function getByResourceAndCondition(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|string',
            'condition_id' => 'required|string',
        ]);

        $variant = $this->variantService->getByResourceAndCondition($validated['resource_id'], $validated['condition_id']);
        if (!$variant) {
            return response()->json(['error' => 'Variant not found'], 404);
        }
        return response()->json($variant);
    }

    public function destroy($id)
    {
        if ($this->variantService->delete($id)) {
            return response()->json(['message' => 'Variant deleted successfully']);
        }
        return response()->json(['error' => 'Variant not found'], 404);
    }
}