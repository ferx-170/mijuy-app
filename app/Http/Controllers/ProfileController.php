<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        // Validamos los datos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email,' . $usuario->id,
            'avatar' => 'nullable|url|max:255',
            'bio' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Actualizamos los datos básicos
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->avatar = $request->avatar;
        $usuario->bio = $request->bio;

        // Si el usuario escribió una nueva contraseña, la actualizamos
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return back()->with('success', '¡Perfil actualizado correctamente!');
    }
}