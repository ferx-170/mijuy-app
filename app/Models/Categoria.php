<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'icono',
        'color',
        'orden',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
        'orden'  => 'integer',
    ];

    // ============ RELACIONES ============

    // ✅ CORREGIDO
    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'receta_categoria', 'categoria_id', 'receta_id')
                    ->withPivot('creado_en');
    }

    public function recetasPublicas()
    {
        return $this->belongsToMany(Receta::class, 'receta_categoria', 'categoria_id', 'receta_id')
                    ->where('recetas.es_publica', true)
                    ->withPivot('creado_en');
    }

    // ============ SCOPES ============

    public function scopeActivas($query)
    {
        return $query->where('activa', true)->orderBy('orden');
    }

    // ============ ROUTE MODEL BINDING ============

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}