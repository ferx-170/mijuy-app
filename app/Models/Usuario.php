<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;


class Usuario extends Authenticatable
{
    use Notifiable, SoftDeletes, Billable;

    protected $table = 'usuarios';

    // Laravel usa 'created_at'/'updated_at' por defecto; nosotros usamos otros nombres
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    const DELETED_AT = 'eliminado_en';

    protected $fillable = [
        'nombre', 'email', 'password', 'avatar', 'bio', 
        'objetivo', 'alergias', 'restricciones_dieta', 'meta', 'activo',
        'stripe_id', 'pm_type', 'pm_last_four', 'trial_ends_at', 
        'consultas_hoy', 'ultima_consulta_fecha','provider_name',
        'provider_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verificado_en' => 'datetime',
        'activo'              => 'boolean',
        'eliminado_en'        => 'datetime',
        'trial_ends_at' => 'datetime',
        'ultima_consulta_fecha' => 'date',
    ];

    // Relaciones
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
        /**
     * Define la relación con las suscripciones usando la columna correcta.
     */
    public function subscriptions()
    {
        return $this->hasMany(\Laravel\Cashier\Subscription::class, 'usuario_id', 'id');
    }

    
    
}