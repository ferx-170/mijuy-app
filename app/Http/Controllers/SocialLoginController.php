<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            // El usuario canceló el login en la pantalla de Google
            if ($request->has('error')) {
                return redirect('/login')->with('error', 'Cancelaste el inicio de sesión con Google.');
            }

            $googleUser = Socialite::driver('google')->user();
            

            $googleId = $googleUser->getId();
            $email    = $googleUser->getEmail();
            // getName() puede venir null en algunas cuentas → fallback al prefijo del correo
            $nombre   = $googleUser->getName() ?: explode('@', $email)[0];
            $avatar   = $googleUser->getAvatar();

            // 1. Buscar PRIMERO por provider_id (login normal con Google)
            $usuario = Usuario::where('provider_name', 'google')
                              ->where('provider_id', $googleId)
                              ->first();

            // 2. Si no existe, buscar por email (cuenta local → se VINCULA a Google)
            if (! $usuario) {
                $usuario = Usuario::where('email', $email)->first();
            }

            // 3. No existe en absoluto → crear el usuario nuevo
            if (! $usuario) {
                $usuario = new Usuario();

                $usuario->forceFill([
                    'nombre'              => $nombre,
                    'email'               => $email,
                    'provider_name'       => 'google',
                    'provider_id'         => (string) $googleId,
                    'avatar'              => $avatar,
                    'password'            => null, // sin contraseña para login social
                    'email_verificado_en' => now(), // Google ya verificó el correo
                ])->save();

                Log::info('Usuario creado vía Google', ['usuario_id' => $usuario->id, 'email' => $email]);
            } else {
                // Ya existía (local o Google): vincular / refrescar datos de Google.
                // forceFill() NO depende del $fillable del modelo: guarda SIEMPRE.
                $usuario->forceFill([
                    'provider_name'       => 'google',
                    'provider_id'         => (string) $googleId,
                    'avatar'              => $avatar ?? $usuario->avatar,
                    'email_verificado_en' => $usuario->email_verificado_en ?? now(),
                ])->save();
            }

            Auth::login($usuario, true); // true = "recordarme"

            return redirect()->intended('/dashboard');

        } catch (\Throwable $e) {
        Log::error('Error en login con Google: ' . $e->getMessage());
        return redirect('/login')->with('error', 'Error al autenticar con Google.');
    }
    }
}