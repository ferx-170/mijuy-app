<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    // ============ HISTORIAL PERSONAL ============
    public function myHistory()
    {
        $recetas = Receta::with(['nutricion', 'categorias'])
            ->delUsuario(Auth::id())
            ->recientes()
            ->paginate(12);

        return view('dashboard.history', compact('recetas'));
    }

    // ============ VER RECETA ============
    public function show(Receta $receta)
    {
        // Si es privada, solo el dueño puede verla
        if (!$receta->es_publica && !$receta->esDelUsuario(Auth::id())) {
            abort(403, 'No tienes permiso para ver esta receta.');
        }

        // Incrementar vistas (solo si no es el dueño)
        if (!$receta->esDelUsuario(Auth::id())) {
            $receta->incrementarVistas();
        }

        $receta->load(['usuario', 'ingredientes', 'pasos', 'nutricion', 'categorias']);

        $esFavorita = $receta->favoritos()->where('usuario_id', Auth::id())->exists();
        $tieneLike  = $receta->likes()->where('usuario_id', Auth::id())->exists();

        return view('dashboard.receta', compact('receta', 'esFavorita', 'tieneLike'));
    }

    // ============ EDITAR ============
    public function edit(Receta $receta)
    {
        $this->authorizeOwner($receta);

        $categorias = Categoria::activas()->get();
        $receta->load(['ingredientes', 'pasos', 'nutricion', 'categorias']);

        return view('dashboard.receta-edit', compact('receta', 'categorias'));
    }

    public function update(Request $request, Receta $receta)
    {
        $this->authorizeOwner($receta);

        $data = $request->validate([
            'nombre'      => 'required|string|max:180',
            'descripcion' => 'nullable|string|max:500',
            'tip_nutricional' => 'nullable|string|max:500',
            'recomendacion'   => 'nullable|string|max:500',
        ]);

        $receta->update($data);

        return redirect()->route('recipe.show', $receta)
                         ->with('success', 'Receta actualizada.');
    }

    // ============ ELIMINAR ============
    public function destroy(Receta $receta)
    {
        $this->authorizeOwner($receta);
        $receta->delete(); // soft delete

        return redirect()->route('my.history')
                         ->with('success', 'Receta eliminada.');
    }

    // ============ PUBLICAR / DESPUBLICAR ============
    public function togglePublic(Receta $receta)
    {
        $this->authorizeOwner($receta);

        $receta->update(['es_publica' => !$receta->es_publica]);

        return back()->with('success',
            $receta->es_publica ? 'Receta publicada en el foro.' : 'Receta ocultada del foro.'
        );
    }

    // ============ MARCAR FAVORITA (del dueño) ============
    public function toggleFavorite(Receta $receta)
    {
        $this->authorizeOwner($receta);

        $receta->update(['es_favorita' => !$receta->es_favorita]);

        return back()->with('success', 'Estado de favorito actualizado.');
    }

    // ============ HELPER ============
    private function authorizeOwner(Receta $receta): void
    {
        if (!$receta->esDelUsuario(Auth::id())) {
            abort(403, 'No autorizado.');
        }
    }
}