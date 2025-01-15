<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'resource_id', 'raw', 'resume', 'conceptual_map'];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}