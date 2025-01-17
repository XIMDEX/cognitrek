<?php

namespace App\Services;

use App\Models\Condition;

class ConditionService
{
    public function create(string $type): Condition
    {
        $condition = new Condition();
        $condition->type = $type;
        $condition->save();

        return $condition;
    }

    public function getAll()
    {
        return Condition::all();
    }

    public function getById(string $id): ?Condition
    {
        return Condition::find($id);
    }

    public function getManyByIds(array $ids)
    {
        return Condition::whereIn('id', $ids)->get();
    }
}