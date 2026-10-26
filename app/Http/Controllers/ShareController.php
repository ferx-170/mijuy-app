<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Compartido;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    // ============ LISTADO DE COMPARTIDOS RECIBIDOS ============
    public function index()
    {
        $recibidos = Compartido::with(['receta.nutricion', 'origen'])
            ->where('destino_usuario_id', Auth::id())
            ->vigentes()
            ->orderByDesc('creado_en')
            ->paginate(15);

        return view('dashboard.shares', compact('recibidos'));
    }

    // ============ CREAR COMPARTIDO ============
    public function store(Request $request, Receta $receta)
    {
        // Solo el dueño puede compartir su receta
        if (!$receta->esDelUsuario(Auth::id())) {
            abort(403, 'Solo puedes compartir tus propias recetas.');
        }

        $data = $request->validate([
            'tipo'               => 'required|in:interno,link,social',
            'destino_usuario_id' => 'required_if:tipo,interno|nullable|exists:usuarios,id',
            'mensaje'            => 'nullable|string|max:500',
            'expira_en'          => 'nullable|date|after:now',
        ]);

        // No te compartas a ti mismo
        if ($data['tipo'] === 'interno' && (int)$data['destino_usuario_id'] === Auth::id()) {
            return back()->with('error', 'No puedes compartirte una receta a ti mismo.');
        }

        $compartido = Compartido::create([
            'receta_id'          => $receta->id,
            'origen_usuario_id'  => Auth::id(),
            'destino_usuario_id' => $data['tipo'] === 'interno' ? $data['destino_usuario_id'] : null,
            'token'              => $data['tipo'] === 'link' ? Compartido::generarToken() : null,
            'tipo'               => $data['tipo'],
            'mensaje'            => $data['mensaje'] ?? null,
            'expira_en'          => $data['expira_en'] ?? null,
        ]);

        $receta->increment('total_compartidos');

        if ($data['tipo'] === 'link') {
            $url = route('shares.show', $compartido->token);
            return back()->with('success', "Enlace generado: {$url}");
        }

        return back()->with('success', 'Receta compartida.');
    }

    // ============ VER POR TOKEN (público) ============
    public function showByToken(string $token)
    {
        $compartido = Compartido::with(['receta.usuario', 'receta.ingredientes', 'receta.pasos', 'receta.nutricion'])
            ->where('token', $token)
            ->firstOrFail();

        if ($compartido->estaExpirado()) {
            abort(410, 'Este enlace ha expirado.');
        }

        return view('dashboard.shared-recipe', compact('compartido'));
    }
}