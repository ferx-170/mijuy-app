<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetaPaso extends Model
{
    protected $table = 'receta_pasos';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'receta_id',
        'numero_paso',
        'descripcion',
    ];

    protected $casts = [
        'numero_paso' => 'integer',
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'receta_id');
    }
}