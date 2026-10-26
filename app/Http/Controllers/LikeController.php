<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // ============ TOGGLE LIKE ============
    public function toggle(Receta $receta)
    {
        // Solo se puede dar like a recetas públicas y que no sean propias
        if (!$receta->es_publica) {
            return back()->with('error', 'Solo puedes dar like a recetas públicas.');
        }

        if ($receta->esDelUsuario(Auth::id())) {
            return back()->with('error', 'No puedes dar like a tu propia receta.');
        }

        $usuarioId = Auth::id();
        $existente = Like::where('usuario_id', $usuarioId)
                         ->where('receta_id', $receta->id)
                         ->first();

        if ($existente) {
            $existente->delete();
            $receta->decrement('total_likes');
            $mensaje = 'Like eliminado.';
        } else {
            Like::create([
                'usuario_id' => $usuarioId,
                'receta_id'  => $receta->id,
            ]);
            $receta->increment('total_likes');
            $mensaje = '¡Like añadido!';
        }

        return back()->with('success', $mensaje);
    }
}