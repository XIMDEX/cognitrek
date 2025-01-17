<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ConditionType;
use InvalidArgumentException;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'type', 'label'];

    public function setTypeAttribute($value)
    {
        if (!in_array($value, ConditionType::getValues())) {
            throw new InvalidArgumentException("Invalid type: $value");
        }
        $this->attributes['type'] = $value;
    }

    public function getTypeAttribute($value)
    {
        return $this->attributes['type'];
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
