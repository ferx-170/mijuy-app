<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use App\Models\Usuario;
use App\Models\Subscription;
use Laravel\Cashier\Subscription as CashierSubscription;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // 1. Le decimos a Cashier cuál es tu modelo de cliente
        Cashier::useCustomerModel(Usuario::class);
        
        // 2. Le decimos a Cashier que use tu modelo Subscription (el que creaste)
        Cashier::useSubscriptionModel(Subscription::class);

        // 3. 🔥 LA CLAVE: Le indicamos a Cashier que la llave foránea es 'usuario_id'
        // Esto se ejecuta a nivel global y afecta al WebhookController.
        CashierSubscription::resolveRelationUsing('user', function ($subscription) {
            return $subscription->belongsTo(Usuario::class, 'usuario_id');
        });
    }
}
