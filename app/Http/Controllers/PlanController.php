<?php

namespace App\Http\Controllers;

use App\Models\Plan; // <-- IMPORTANTE: Asegúrate de tener esta línea
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
        public function index()
    {
        $planes = Plan::where('activo', 1)->orderBy('precio', 'asc')->get();
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        
        $planActualStripeId = null;
        
        if ($user) {
            // Buscamos directamente en la tabla de suscripciones usando TU columna
            $suscripcion = \Laravel\Cashier\Subscription::where('usuario_id', $user->id)
                                ->where('stripe_status', 'active')
                                ->first();
            
            if ($suscripcion) {
                $planActualStripeId = $suscripcion->stripe_price;
            }
        }

        return view('dashboard.planes', compact('planes', 'planActualStripeId'));
    }
    
        public function checkout(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:planes,id'
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();

        if ($plan->precio == 0) {
            return back()->with('error', 'El plan gratuito no requiere pago.');
        }

        // 1. Forzamos a Cashier a usar la tabla 'usuarios' y el modelo 'Usuario'
        config(['cashier.model' => \App\Models\Usuario::class]);
        config(['cashier.tables.customer' => 'usuarios']);

        // 2. Buscamos o creamos el cliente en Stripe
        $user->createOrGetStripeCustomer();

        // 3. Redirigimos a Stripe
        return $user->newSubscription('default', $plan->stripe_price_id)
            ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('planes.index') . '?success=1',
                'cancel_url' => route('planes.index') . '?cancel=1',
            ]);
    }
}