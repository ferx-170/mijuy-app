<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Favorito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FavoriteController extends Controller
{
    // ============ LISTADO DE FAVORITOS ============
    public function index()
    {
        $favoritos = Receta::query()
            ->join('favoritos', 'recetas.id', '=', 'favoritos.receta_id')
            ->where('favoritos.usuario_id', Auth::id())
            ->with(['nutricion', 'usuario'])
            ->select('recetas.*')
            ->orderByDesc('favoritos.creado_en')
            ->paginate(12);

        return view('dashboard.favorites', compact('favoritos'));
    }

    // ============ TOGGLE (agregar/quitar) ============
    public function toggle(Receta $receta)
    {
        
        $usuarioId = Auth::id();
        $existente = Favorito::where('usuario_id', $usuarioId)
                             ->where('receta_id', $receta->id)
                             ->first();

        if ($existente) {
            $existente->delete();
            $receta->decrement('total_favoritos');
            $mensaje = 'Eliminada de favoritos.';
        } else {
            Favorito::create([
                'usuario_id' => $usuarioId,
                'receta_id'  => $receta->id,
            ]);
            $receta->increment('total_favoritos');
            $mensaje = 'Añadida a favoritos.';
        }

        return back()->with('success', $mensaje);
    }
}