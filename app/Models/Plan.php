<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'planes';
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'nombre', 'stripe_price_id', 'limite_consultas_diario', 'precio', 'descripcion', 'activo'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'stripe_price', 'stripe_price_id');
    }
}