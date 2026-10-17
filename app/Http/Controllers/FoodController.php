<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\RecetaIngrediente;
use App\Models\RecetaPaso;
use App\Models\RecetaNutricion;
use App\Models\Categoria; // <-- Importamos el modelo Categoria
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FoodController extends Controller
{
    // ============ HOME ============
    public function index()
    {
        return view('dashboard');
    }

    // ============ SCAN ============
    public function scan()
    {
        return view('dashboard.scan');
    }

    // ============ ANALYZE (guarda en BD) ============
    public function analyze(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $imageBase64 = $request->input('image');
        $apiKey = config('services.groq.key');

        if (empty($apiKey)) {
            return back()->with('error', 'GROQ_API_KEY no configurada');
        }

        $prompt = $this->buildPrompt();

        try {
            $response = Http::withOptions(['verify' => false])
                ->timeout(90)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ])->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'qwen/qwen3.8-27b',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => [
                                ['type' => 'text', 'text' => $prompt],
                                ['type' => 'image_url', 'image_url' => ['url' => $imageBase64]]
                            ]
                        ]
                    ],
                    'max_tokens' => 4000,
                    'temperature' => 0.7,
                ]);

            if ($response->failed()) {
                Log::error('Groq error: ' . $response->body());
                return back()->with('error', 'Error al comunicarse con la IA.');
            }

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? '';

            // Limpiar markdown ```json ... ```
            $content = preg_replace('/```json\s*|\s*```/', '', $content);
            $result = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON inválido: ' . $content);
                return back()->with('error', 'La IA devolvió un formato inválido.');
            }

            // ============ GUARDAR EN BD ============
            $receta = DB::transaction(function () use ($result, $imageBase64) {
                $usuarioId = Auth::id();

                // 1. Receta principal
                $receta = Receta::create([
                    'usuario_id'       => $usuarioId,
                    'nombre'           => $result['nombre'] ?? 'Plato analizado',
                    'descripcion'      => $result['descripcion'] ?? null,
                    'imagen_base64'    => $imageBase64,
                    'tip_nutricional'  => $result['tip_nutricional'] ?? null,
                    'recomendacion'    => $result['recomendacion'] ?? null,
                    'origen'           => 'scan',
                    'es_publica'       => false,
                ]);

                // 2. Ingredientes reales
                foreach (($result['ingredientes'] ?? []) as $i => $ing) {
                    RecetaIngrediente::create([
                        'receta_id'   => $receta->id,
                        'nombre'      => is_array($ing) ? json_encode($ing) : $ing,
                        'es_faltante' => false,
                        'orden'       => $i,
                    ]);
                }

                // 3. Ingredientes faltantes
                foreach (($result['faltantes'] ?? []) as $i => $fal) {
                    RecetaIngrediente::create([
                        'receta_id'   => $receta->id,
                        'nombre'      => is_array($fal) ? json_encode($fal) : $fal,
                        'es_faltante' => true,
                        'orden'       => 100 + $i,
                    ]);
                }

                // 4. Pasos
                foreach (($result['preparacion'] ?? []) as $i => $paso) {
                    RecetaPaso::create([
                        'receta_id'    => $receta->id,
                        'numero_paso'  => $i + 1,
                        'descripcion'  => $paso,
                    ]);
                }

                // 5. Nutrición
                $n = $result['nutricion'] ?? [];
                RecetaNutricion::create([
                    'receta_id'         => $receta->id,
                    'calorias'          => $n['calorias'] ?? null,
                    'proteinas'         => $n['proteinas'] ?? null,
                    'grasas_totales'    => $n['grasas_totales'] ?? null,
                    'grasas_saturadas'  => $n['grasas_saturadas'] ?? null,
                    'carbohidratos'     => $n['carbohidratos'] ?? null,
                    'azucares'          => $n['azucares'] ?? null,
                    'fibra'             => $n['fibra'] ?? null,
                    'sodio'             => $n['sodio'] ?? null,
                    'colesterol'        => $n['colesterol'] ?? null,
                    'calcio'            => $n['calcio'] ?? null,
                ]);

                // 6. Asignar Categoría automáticamente basada en el texto
                $categoriaNombre = 'comidas-simples'; // Por defecto
                $textoReceta = strtolower(($result['nombre'] ?? '') . ' ' . ($result['descripcion'] ?? ''));

                if (str_contains($textoReceta, 'proteína') || str_contains($textoReceta, 'proteina') || str_contains($textoReceta, 'pollo') || str_contains($textoReceta, 'carne') || str_contains($textoReceta, 'pescado') || str_contains($textoReceta, 'gamba')) {
                    $categoriaNombre = 'altas-proteina';
                } elseif (str_contains($textoReceta, 'ensalada') || str_contains($textoReceta, 'ligero') || str_contains($textoReceta, 'bajo en')) {
                    $categoriaNombre = 'bajas-calorias';
                } elseif (str_contains($textoReceta, 'postre') || str_contains($textoReceta, 'dulce') || str_contains($textoReceta, 'fruta')) {
                    $categoriaNombre = 'postres-saludables';
                } elseif (str_contains($textoReceta, 'desayuno') || str_contains($textoReceta, 'avena') || str_contains($textoReceta, 'huevo')) {
                    $categoriaNombre = 'desayunos';
                } elseif (str_contains($textoReceta, 'elaborad') || str_contains($textoReceta, 'horno')) {
                    $categoriaNombre = 'comidas-elaboradas';
                }

                // Buscamos la categoría en la BD y la asignamos
                $categoria = Categoria::where('slug', $categoriaNombre)->first();
                if ($categoria) {
                    $receta->categorias()->attach($categoria->id);
                }

                return $receta;
            });

            return redirect()
                ->route('recipe.show', $receta)
                ->with('success', '¡Análisis completado!');

        } catch (\Exception $e) {
            Log::error('Excepción en analyze: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error interno.');
        }
    }

    // ============ PROMPT ============
    private function buildPrompt(): string
    {
        return <<<PROMPT
Eres un asistente nutricional y culinario experto. Analiza la imagen de los ingredientes.

Reglas:
1. Identifica todos los ingredientes visibles.
2. Si faltan ingredientes para una receta completa, sugiérelos.
3. Devuelve ÚNICAMENTE un JSON válido con esta estructura EXACTA:

{
  "nombre": "Nombre del plato",
  "descripcion": "Breve descripción (2 líneas máx)",
  "ingredientes": ["Ingrediente 1: cantidad", "..."],
  "faltantes": ["...", "..."],
  "preparacion": ["Paso 1: ...", "Paso 2: ...", "... (mínimo 5 pasos detallados)"],
  "nutricion": {
    "calorias": "580 kcal",
    "proteinas": "42 g",
    "grasas_totales": "28 g",
    "grasas_saturadas": "6 g",
    "carbohidratos": "65 g",
    "azucares": "8 g",
    "fibra": "12 g",
    "sodio": "320 mg",
    "colesterol": "85 mg",
    "calcio": "180 mg"
  },
  "tip_nutricional": "Consejo (1 línea)",
  "recomendacion": "Versión mejorada (1 línea)"
}

No incluyas texto fuera del JSON. Los pasos deben incluir tiempos y temperaturas.
PROMPT;
    }
}