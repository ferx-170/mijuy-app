<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetaIngrediente extends Model
{
    protected $table = 'receta_ingredientes';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null; // no tenemos actualizado_en

    protected $fillable = [
        'receta_id',
        'nombre',
        'cantidad',
        'es_faltante',
        'orden',
    ];

    protected $casts = [
        'es_faltante' => 'boolean',
        'orden'       => 'integer',
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'receta_id');
    }
}