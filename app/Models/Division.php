<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Modelo de División
class Division extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'name',
        'parent_id',
        'level',
        'collaborators_count',
        'ambassador_name',
        'superior_division'
    ];

    // Relaciones para la jerarquía de divisiones
    public function parent()
    {
        return $this->belongsTo(Division::class, 'parent_id');
    }

    // Relación para obtener las subdivisiones de una división
    public function children()
    {
        return $this->hasMany(Division::class, 'parent_id');
    }
}
