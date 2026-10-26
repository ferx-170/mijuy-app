<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\RecetaIngrediente;
use App\Models\RecetaPaso;
use App\Models\RecetaNutricion;
use App\Models\Categoria;
use App\Models\Plan; // <-- Importamos el modelo Plan
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

        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        $hoy = now()->toDateString();

        // 1. Determinar el límite del usuario (igual que antes)
        $limite = 2; // Límite del Plan Gratuito por defecto
        $nombrePlan = 'Plan Gratuito';

        if ($user->subscribed('default')) {
            // Si tiene suscripción activa, buscamos su plan en la BD
            $precioStripe = $user->subscription('default')->stripe_price;
            $plan = Plan::where('stripe_price_id', $precioStripe)->first();

            if ($plan) {
                $limite = $plan->limite_consultas_diario;
                $nombrePlan = $plan->nombre;
            }
        }

        // ============================================================
        // 2. ★ RESET DIARIO + RESERVA ATÓMICA DEL CUPO (en UNA transacción) ★
        //
        //    Antes: el chequeo estaba al inicio y el incremento al final,
        //    separados por la llamada a la IA (10-90 s). Cualquier petición
        //    concurrente leía el mismo contador viejo y pasaba el chequeo
        //    (condición de carrera TOCTOU) → por eso podías crear 3 recetas.
        //
        //    Ahora: bloqueamos la fila del usuario (lockForUpdate) y
        //    reservamos el cupo con un UPDATE condicional ANTES de llamar
        //    a la IA. MySQL garantiza que aunque lleguen 100 peticiones
        //    simultáneas, solo podrán reservar las que quepan en el límite.
        //    El bloqueo dura milisegundos (la IA se llama FUERA de la transacción).
        // ============================================================
        $reservado = DB::transaction(function () use ($user, $hoy, $limite) {
            // Bloquea la fila del usuario: serializa peticiones simultáneas del mismo usuario
            $fila = DB::table('usuarios')
                ->where('id', $user->id)
                ->lockForUpdate()
                ->first();

            if (! $fila) {
                return 0;
            }

            // Reset diario DENTRO del candado (sin comparaciones con casts de Eloquent:
            // DB::table devuelve la fecha como string 'Y-m-d', comparación 100% fiable)
            if ($fila->ultima_consulta_fecha === null || $fila->ultima_consulta_fecha !== $hoy) {
                DB::table('usuarios')
                    ->where('id', $user->id)
                    ->update([
                        'consultas_hoy'         => 0,
                        'ultima_consulta_fecha' => $hoy,
                    ]);
                $fila->consultas_hoy = 0;
            }

            // RESERVA: solo incrementa si aún hay cupo (UPDATE condicional atómico).
            // Devuelve el número de filas afectadas: 0 = sin cupo disponible.
            return DB::table('usuarios')
                ->where('id', $user->id)
                ->where('consultas_hoy', '<', $limite)
                ->increment('consultas_hoy');
        });

        if ($reservado === 0) {
            return back()->with('error', "Has alcanzado tu límite de {$limite} consultas diarias del {$nombrePlan}. ¡Actualiza tu plan para seguir escaneando!");
        }

        // ============================================================
        // 3. El cupo YA ESTÁ RESERVADO. Si algo falla a partir de aquí
        //    se DEVUELVE (compensación) para conservar el comportamiento
        //    original: solo se consume cuota cuando la receta se guarda.
        // ============================================================
        try {
            // 4. Procesar la imagen con la IA
            $imageBase64 = $request->input('image');
            $apiKey = config('services.groq.key');

            if (empty($apiKey)) {
                throw new \RuntimeException('GROQ_API_KEY no configurada');
            }

            $prompt = $this->buildPrompt();

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
                throw new \RuntimeException('Error al comunicarse con la IA. Intenta nuevamente.');
            }

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? '';

            // Limpiar markdown ```json ... ```
            $content = preg_replace('/```json\s*|\s*```/', '', $content);
            $result = json_decode($content, true);

            // 5. Validar JSON y que sea comida
            if (json_last_error() !== JSON_ERROR_NONE || !isset($result['es_comida'])) {
                Log::error('JSON inválido o estructura incorrecta: ' . $content);
                throw new \RuntimeException('La IA devolvió un formato inválido. Intenta nuevamente.');
            }

            if ($result['es_comida'] === false) {
                throw new \RuntimeException('La imagen no contiene alimentos. Por favor, sube una foto clara de un plato o ingredientes.');
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
                $categoriaNombre = 'comidas-simples';
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

                $categoria = Categoria::where('slug', $categoriaNombre)->first();
                if ($categoria) {
                    $receta->categorias()->attach($categoria->id);
                }

                return $receta;
            });

            // ============================================================
            // 7. ★ Ya NO hace falta $user->increment('consultas_hoy') aquí:
            //    el cupo se reservó de forma atómica en el paso 2.
            // ============================================================

            return redirect()
                ->route('recipe.show', $receta)
                ->with('success', '¡Análisis completado!');

        } catch (\Throwable $e) {
            // ★ COMPENSACIÓN: la reserva no se consumió (falló la IA, no era
            //   comida, JSON inválido, error de BD, etc.) → devolver el cupo.
            //   Así se mantiene el comportamiento original: solo cuenta la
            //   cuota cuando la receta se guardó con éxito.
            DB::table('usuarios')->where('id', $user->id)->decrement('consultas_hoy');

            // Los RuntimeException que lanza este método son mensajes controlados
            // para el usuario (misma respuesta que antes). QueryException hereda de
            // RuntimeException, por eso se excluye: un error de BD muestra el
            // mensaje genérico, igual que en tu versión original.
            if ($e instanceof \RuntimeException && ! $e instanceof \Illuminate\Database\QueryException) {
                return back()->with('error', $e->getMessage());
            }

            Log::error('Excepción en analyze: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error interno.');
        }
    }

    // ============ PROMPT ============
    private function buildPrompt(): string
    {
        return <<<PROMPT
Eres un estricto asistente nutricional y culinario experto. Analiza la imagen que te envío.

REGLA DE ORO: 
Primero, evalúa si la imagen contiene ingredientes o comida real (platos, frutas, verduras, carnes, etc.).
Si la imagen NO contiene comida (por ejemplo: personas, animales, hardware, ropa, paisajes, texto, objetos), DEBES devolver ÚNICAMENTE este JSON de error:
{
  "es_comida": false,
  "error": "La imagen no contiene alimentos válidos para analizar."
}

Si la imagen SÍ contiene comida, procede a generar la receta y devuelve ÚNICAMENTE un JSON válido con esta estructura EXACTA:
{
  "es_comida": true,
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