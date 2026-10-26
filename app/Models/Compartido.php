<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compartido extends Model
{
    protected $table = 'compartidos';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'receta_id',
        'origen_usuario_id',
        'destino_usuario_id',
        'token',
        'tipo',
        'mensaje',
        'expira_en',
    ];

    protected $casts = [
        'expira_en' => 'datetime',
    ];

    // ============ RELACIONES ============

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'receta_id');
    }

    public function origen()
    {
        return $this->belongsTo(Usuario::class, 'origen_usuario_id');
    }

    public function destino()
    {
        return $this->belongsTo(Usuario::class, 'destino_usuario_id');
    }

    // ============ SCOPES ============

    public function scopeInternos($query)
    {
        return $query->where('tipo', 'interno');
    }

    public function scopeLinks($query)
    {
        return $query->where('tipo', 'link');
    }

    public function scopeVigentes($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expira_en')
              ->orWhere('expira_en', '>', now());
        });
    }

    // ============ HELPERS ============

    public function estaExpirado(): bool
    {
        return $this->expira_en && $this->expira_en->isPast();
    }

    public static function generarToken(): string
    {
        return bin2hex(random_bytes(32)); // 64 chars
    }
}