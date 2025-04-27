<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVariant extends Model
{
    use HasFactory;

    protected $table = 'user_variants';

    protected $fillable = ['variant_id', 'user_id'];

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'adaptation_id');
    }
}
