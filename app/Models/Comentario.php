<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use SoftDeletes;

    protected $table = 'comentarios';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null; // No tenemos columna de actualización
    const DELETED_AT = 'eliminado_en';

    protected $fillable = [
        'receta_id',
        'usuario_id',
        'contenido',
    ];

    protected $casts = [
        'eliminado_en' => 'datetime',
    ];

    // Relaciones
    public function receta()
    {
        return $this->belongsTo(Receta::class, 'receta_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}