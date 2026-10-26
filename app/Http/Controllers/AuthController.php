<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ============ LOGIN ============
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $request->session()->flash('just_logged_in', true);  // 👈 dispara el modal
            $request->session()->flash('success', '¡Bienvenido de vuelta!');
            return redirect()->intended(route('home'));
        }

        return back()
            ->withErrors(['email' => 'Credenciales incorrectas.'])
            ->onlyInput('email');
    }

    // ============ REGISTRO ============
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'required|email|max:150|unique:usuarios,email',
            'password' => 'required|string|min:6|confirmed',
            'objetivo' => 'nullable|in:mantenimiento,bajar_peso,ganar_masa,mejorar_salud,aprender_cocinar,otro',
        ]);

        $usuario = Usuario::create([
            'nombre'   => $data['nombre'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'objetivo' => $data['objetivo'] ?? 'mantenimiento',
        ]);

        Auth::login($usuario);
        $request->session()->flash('just_logged_in', true);  // 👈 también en registro
        $request->session()->flash('success', '¡Cuenta creada con éxito!');
        return redirect()->route('home');

        
    }

    // ============ LOGOUT ============
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
                         ->with('success', 'Sesión cerrada.');
    }
}