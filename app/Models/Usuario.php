<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'usuarios';

    // Laravel usa 'created_at'/'updated_at' por defecto; nosotros usamos otros nombres
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    const DELETED_AT = 'eliminado_en';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'avatar',
        'bio',
        'objetivo',
        'alergias',
        'restricciones_dieta',
        'meta',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verificado_en' => 'datetime',
        'activo'              => 'boolean',
        'eliminado_en'        => 'datetime',
    ];

    // ============ RELACIONES ============

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'usuario_id');
    }

    public function recetasPublicas()
    {
        return $this->hasMany(Receta::class, 'usuario_id')
                    ->where('es_publica', true)
                    ->orderByDesc('creado_en')
                    ->limit(6); // Solo traemos 6 para el modal
    }

    public function favoritos()
    {
        return $this->belongsToMany(Receta::class, 'favoritos', 'usuario_id', 'receta_id')
                    ->withPivot('creado_en');
    }

    public function likes()
    {
        return $this->belongsToMany(Receta::class, 'likes', 'usuario_id', 'receta_id')
                    ->withPivot('creado_en');
    }

    public function compartidosEnviados()
    {
        return $this->hasMany(Compartido::class, 'origen_usuario_id');
    }

    public function compartidosRecibidos()
    {
        return $this->hasMany(Compartido::class, 'destino_usuario_id');
    }

    // ============ SCOPES ============

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}