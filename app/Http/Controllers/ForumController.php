<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // ============ FORO PRINCIPAL ============
    public function index(Request $request)
    {
        $categorias = Categoria::activas()
            ->withCount(['recetasPublicas as total_recetas'])
            ->get();

        $query = Receta::with(['usuario', 'nutricion', 'categorias'])
            ->publicas()
            ->recientes();

        // Filtro por categoría (opcional vía query string)
        if ($request->filled('categoria')) {
            $query->whereHas('categorias', function ($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }

        // Búsqueda por nombre
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $recetas = $query->paginate(12)->withQueryString();

        return view('dashboard.forum', compact('categorias', 'recetas'));
    }

    // ============ RECETAS POR CATEGORÍA ============
    public function category(Categoria $categoria)
    {
        if (!$categoria->activa) {
            abort(404);
        }

        $recetas = Receta::with(['usuario', 'nutricion', 'categorias'])
            ->publicas()
            ->whereHas('categorias', fn($q) => $q->where('categorias.id', $categoria->id))
            ->recientes()
            ->paginate(12);

        $categorias = Categoria::activas()->get();

        return view('dashboard.forum-category', compact('categoria', 'categorias', 'recetas'));
    }
}