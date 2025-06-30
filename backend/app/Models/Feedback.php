<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['variant_id', 'user_id', 'score', 'text'];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}