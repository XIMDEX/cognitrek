<?php

namespace App\Services;

use App\Models\UserVariant;

class UserVariantService {

    public function create(array $data): UserVariant
    {
        $userVariant = new UserVariant();
        $userVariant->variant_id = $data['variant_id'];
        $userVariant->user_id = $data['user_id'];
        $userVariant->created_at = now();
        $userVariant->updated_at = now();
        $userVariant->save();

        return $userVariant;
    }

    public function getUserAdaptation($resourceID, $userHash)
    {
        $adaptation = UserVariant::where('user_id', $userHash)
            ->whereHas('variant', function ($query) use ($resourceID) { 
                $query->where('resource_id', $resourceID);
            })->first();
        
        if ($adaptation) {
            return $adaptation;
        }
        return null;
    }
}