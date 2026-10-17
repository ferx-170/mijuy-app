<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{
    use SoftDeletes;

    protected $table = 'recetas';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    const DELETED_AT = 'eliminado_en';

    protected $fillable = [
        'usuario_id', 'nombre', 'descripcion', 'imagen_path', 'imagen_base64',
        'es_publica', 'es_favorita', 'origen', 'tip_nutricional', 'recomendacion',
        'vistas', 'total_favoritos', 'total_likes', 'total_compartidos',
    ];

    protected $casts = [
        'es_publica'   => 'boolean',
        'es_favorita'  => 'boolean',
        'vistas'       => 'integer',
        'total_favoritos'   => 'integer',
        'total_likes'       => 'integer',
        'total_compartidos' => 'integer',
        'eliminado_en' => 'datetime',
    ];

    // ============ RELACIONES ============

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function ingredientes()
    {
        return $this->hasMany(RecetaIngrediente::class, 'receta_id')->orderBy('orden');
    }

    public function ingredientesReales()
    {
        return $this->hasMany(RecetaIngrediente::class, 'receta_id')
                    ->where('es_faltante', false)->orderBy('orden');
    }

    public function ingredientesFaltantes()
    {
        return $this->hasMany(RecetaIngrediente::class, 'receta_id')
                    ->where('es_faltante', true)->orderBy('orden');
    }

    public function pasos()
    {
        return $this->hasMany(RecetaPaso::class, 'receta_id')->orderBy('numero_paso');
    }

    public function nutricion()
    {
        return $this->hasOne(RecetaNutricion::class, 'receta_id');
    }

    // ✅ CORREGIDO: solo withPivot, sin withTimestamps
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'receta_categoria', 'receta_id', 'categoria_id')
                    ->withPivot('creado_en');
    }

    // ✅ CORREGIDO
    public function favoritos()
    {
        return $this->belongsToMany(Usuario::class, 'favoritos', 'receta_id', 'usuario_id')
                    ->withPivot('creado_en');
    }

    // ✅ CORREGIDO
    public function likes()
    {
        return $this->belongsToMany(Usuario::class, 'likes', 'receta_id', 'usuario_id')
                    ->withPivot('creado_en');
    }

    public function compartidos()
    {
        return $this->hasMany(Compartido::class, 'receta_id');
    }

    // ============ SCOPES ============

    public function scopePublicas($query) { return $query->where('es_publica', true); }
    public function scopeDelUsuario($query, $usuarioId) { return $query->where('usuario_id', $usuarioId); }
    public function scopeFavoritas($query, $usuarioId) { return $query->where('usuario_id', $usuarioId)->where('es_favorita', true); }
    public function scopeRecientes($query) { return $query->orderByDesc('creado_en'); }
    public function scopePopulares($query) { return $query->orderByDesc('total_likes'); }

    public function esDelUsuario(int $usuarioId): bool
    {
        return $this->usuario_id === $usuarioId;
    }

    public function incrementarVistas(): void
    {
        $this->increment('vistas');
    }
}