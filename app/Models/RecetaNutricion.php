<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetaNutricion extends Model
{
    protected $table = 'receta_nutricion';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'receta_id',
        'calorias',
        'proteinas',
        'grasas_totales',
        'grasas_saturadas',
        'carbohidratos',
        'azucares',
        'fibra',
        'sodio',
        'colesterol',
        'calcio',
        'calorias_valor',
        'proteinas_valor',
        'carbos_valor',
        'grasas_valor',
    ];

    protected $casts = [
        'calorias_valor'  => 'decimal:2',
        'proteinas_valor' => 'decimal:2',
        'carbos_valor'    => 'decimal:2',
        'grasas_valor'    => 'decimal:2',
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'receta_id');
    }
}