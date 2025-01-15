<?php

namespace App\Services;

use App\Models\Variant;

class VariantService
{
    public function create(array $data): Variant
    {
        $variant = new Variant();
        $variant->resource_id = $data['resource_id'];
        $variant->condition_id = $data['condition_id'];
        $variant->content = $data['content'];
        $variant->save();

        return $variant;
    }

    public function getByResourceAndCondition(string $resourceId, string $conditionId): ?Variant
    {
        return Variant::where('resource_id', $resourceId)
            ->where('condition_id', $conditionId)
            ->first();
    }

    public function getAllByResourceOrdered(string $resourceId): \Illuminate\Database\Eloquent\Collection
    {
        return Variant::where('resource_id', $resourceId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function delete(string $id): bool
    {
        $variant = Variant::find($id);
        if ($variant) {
            return $variant->delete();
        }
        return false;
    }
}