<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'resource_id', 'condition_id', 'content', 'type', 'label'];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
}