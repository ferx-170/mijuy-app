<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Receta $receta)
    {
        // 🛑 NUEVA REGLA: Un usuario no puede comentar su propia receta
        if ($receta->esDelUsuario(Auth::id())) {
            return back()->with('error', 'No puedes comentar en tu propia receta.');
        }

        $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        Comentario::create([
            'receta_id'  => $receta->id,
            'usuario_id' => Auth::id(),
            'contenido'  => $request->contenido,
        ]);

        return back()->with('success', 'Comentario publicado.');
    }

    public function destroy(Comentario $comentario)
    {
        // 🛑 CORRECCIÓN: SOLO el autor del comentario puede borrarlo. 
        // (El dueño de la receta ya no tiene permiso para borrar comentarios ajenos)
        if (Auth::id() !== $comentario->usuario_id) {
            abort(403, 'No tienes permiso para eliminar este comentario.');
        }

        $comentario->delete();

        return back()->with('success', 'Comentario eliminado.');
    }
}