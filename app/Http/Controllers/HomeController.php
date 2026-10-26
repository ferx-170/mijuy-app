<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Las 4 recetas públicas más populares (likes → vistas → más nuevas)
        $recetas = Receta::where('es_publica', true)
            ->whereNull('eliminado_en')
            ->with(['nutricion', 'categorias'])
            ->orderByDesc('total_likes')
            ->orderByDesc('vistas')
            ->orderByDesc('creado_en')
            ->take(4)
            ->get();

        // 2. Convertimos cada receta a un formato único (el que usa la vista)
        $recetasPopulares = $recetas->map(fn ($receta) => [
            'nombre'      => Str::limit($receta->nombre, 38),
            'descripcion' => Str::limit($receta->descripcion ?? '', 45),
            'kcal'        => $receta->nutricion->calorias ?? null,
            'categoria'   => $receta->categorias->first()->nombre ?? 'Saludable',
            'imagen'      => $this->imagenDe($receta),
            'url'         => $this->urlDe($receta->id),
        ]);

        // 3. Si hay menos de 4, completamos con las de respaldo (mismo diseño)
        if ($recetasPopulares->count() < 4) {
            $faltan = 4 - $recetasPopulares->count();

            $recetasPopulares = $recetasPopulares
                ->concat($this->recetasRespaldo()->take($faltan))
                ->values();
        }

        return view('dashboard', compact('recetasPopulares'));
    }

    /**
     * Mejor imagen disponible: archivo guardado, base64 o imagen por defecto.
     */
    private function imagenDe($receta): string
    {
        if (! empty($receta->imagen_path)) {
            return Str::startsWith($receta->imagen_path, ['http://', 'https://'])
                ? $receta->imagen_path
                : asset('storage/' . ltrim($receta->imagen_path, '/'));
        }

        if (! empty($receta->imagen_base64)) {
            return $receta->imagen_base64; // ya incluye "data:image/jpeg;base64,..."
        }

        return 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=200&h=200&fit=crop';
    }

    /**
     * Enlace al detalle de la receta.
     * AJUSTA el nombre de la ruta si el tuyo es distinto.
     */
    private function urlDe(int $id): string
    {
        foreach (['recipes.show', 'recetas.show'] as $nombre) {
            if (Route::has($nombre)) {
                return route($nombre, $id);
            }
        }

        return route('forum.index');
    }

    /**
     * Tarjetas de respaldo (mismo formato que las recetas reales).
     */
    private function recetasRespaldo()
    {
        return collect([
            [
                'nombre'      => 'Ensalada de Berries',
                'descripcion' => 'Fresca y antioxidante',
                'kcal'        => '320 kcal',
                'categoria'   => 'Postre',
                'imagen'      => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=200&h=200&fit=crop',
            ],
            [
                'nombre'      => 'Bowl Saludable',
                'descripcion' => 'Almuerzo balanceado',
                'kcal'        => '480 kcal',
                'categoria'   => 'Almuerzo',
                'imagen'      => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=200&h=200&fit=crop',
            ],
            [
                'nombre'      => 'Ensalada Verde',
                'descripcion' => 'Detox y ligera',
                'kcal'        => '280 kcal',
                'categoria'   => 'Cena',
                'imagen'      => 'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=200&h=200&fit=crop',
            ],
            [
                'nombre'      => 'Bowl Proteico',
                'descripcion' => 'Alto en proteína',
                'kcal'        => '620 kcal',
                'categoria'   => 'Fitness',
                'imagen'      => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=200&h=200&fit=crop',
            ],
        ])->map(fn ($r) => $r + ['url' => route('scan')]);
    }
}