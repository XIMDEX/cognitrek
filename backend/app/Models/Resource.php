<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = [
        'content',
        'resume',
        'mental_map',
        'variant',
    ];

    /**
     * Accesor para el contenido.
     * Supongamos que queremos devolver el contenido siempre recortado (trim).
     */
    public function getContentAttribute($value)
    {
        return trim($value);
    }

    /**
     * Mutador para el contenido.
     * Al guardar el contenido, lo guardamos sin espacios al inicio o final.
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = trim($value);
    }

    /**
     * Accesor para el resumen.
     * Por ejemplo, siempre devolver el resumen con la primera letra en mayúscula.
     */
    public function getResumeAttribute($value)
    {
        if (empty($value)) {
            return $value;
        }

        return ucfirst($value);
    }

    /**
     * Mutador para el resumen.
     * Por ejemplo, guardar el resumen recortando espacios y pasando a minúsculas.
     */
    public function setResumeAttribute($value)
    {
        $this->attributes['resume'] = strtolower(trim($value));
    }
}