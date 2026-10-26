@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12" style="background: linear-gradient(180deg, #fef9f3 0%, #ffffff 100%);">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 animate-fade-in-up">
            <span class="inline-flex items-center gap-2 bg-white text-green-700 text-xs font-bold uppercase tracking-wider px-4 py-2 rounded-full mb-4 shadow-sm border border-green-100">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                Membresías MIJUY
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                Potencia tu <span class="text-green-600">Alimentación</span>
            </h1>
            <p class="text-gray-500 mt-4 text-lg">Elige el plan perfecto para tus necesidades. Escanea más recetas y descubre nuevos platillos cada día.</p>
        </div>

        <!-- Mensajes de Alerta -->
        @if(session('error'))
            <div class="max-w-2xl mx-auto mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl flex items-center gap-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if(request('success'))
            <div class="max-w-2xl mx-auto mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl flex items-center gap-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>¡Felicidades! Tu suscripción se ha activado correctamente.</span>
            </div>
        @endif

        <!-- Grid de Planes -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 items-stretch">
            
            @foreach($planes as $plan)
                @php
                    $isCurrent = ($plan->stripe_price_id === $planActualStripeId) || ($plan->precio == 0 && !$planActualStripeId);
                    $isPopular = ($plan->precio == 3.00);
                    $isPremium = ($plan->precio == 10.00);
                @endphp

                <!-- Tarjeta -->
                <div class="relative bg-white rounded-3xl shadow-sm border {{ $isPopular ? 'border-green-500 border-2 shadow-green-100 scale-105 z-10' : 'border-gray-100' }} p-8 flex flex-col transition-all duration-300 hover:shadow-xl animate-fade-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                    
                    @if($isPopular)
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white text-xs font-bold uppercase tracking-wider py-1 px-4 rounded-full shadow-md">
                            Más Popular
                        </div>
                    @endif

                    <!-- Icono y Nombre -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center {{ $isPopular ? 'bg-green-100 text-green-600' : ($isPremium ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-600') }}">
                            @if($plan->precio == 0)
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            @elseif($isPopular)
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                            @else
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"></path></svg>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $plan->nombre }}</h3>
                    </div>

                    <p class="text-gray-500 text-sm mb-6">{{ $plan->descripcion }}</p>

                    <!-- Precio -->
                    <div class="mb-6 flex items-baseline gap-1">
                        <span class="text-4xl font-bold {{ $isPremium ? 'text-purple-600' : 'text-gray-900' }}">
                            S/ {{ number_format($plan->precio, 2) }}
                        </span>
                        <span class="text-gray-500 text-sm">/ mes</span>
                    </div>

                    <!-- Características -->
                    <ul class="space-y-3 mb-8 flex-1">
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <svg class="text-green-500 mt-0.5 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span><strong>{{ $plan->limite_consultas_diario }}</strong> escaneos por día con IA</span>
                        </li>
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <svg class="text-green-500 mt-0.5 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Guardar recetas en tu historial</span>
                        </li>
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <svg class="text-green-500 mt-0.5 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Publicar recetas en el foro</span>
                        </li>
                        <li class="flex items-start gap-2 text-sm text-gray-600 {{ $plan->precio == 0 ? 'opacity-40' : '' }}">
                            <svg class="{{ $plan->precio == 0 ? 'text-gray-400' : 'text-green-500' }} mt-0.5 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Soporte prioritario</span>
                        </li>
                    </ul>

                    <!-- Botón de Acción -->
                    @if($isCurrent)
                        <button disabled class="w-full py-3.5 rounded-xl font-bold text-sm bg-gray-100 text-gray-400 cursor-not-allowed flex items-center justify-center gap-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            Tu plan actual
                        </button>
                    @else
                        <form action="{{ route('planes.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-sm text-white transition-all duration-300 hover:-translate-y-0.5
                                {{ $isPremium ? 'bg-purple-600 hover:bg-purple-700 shadow-lg shadow-purple-200' : ($isPopular ? 'bg-green-500 hover:bg-green-600 shadow-lg shadow-green-200' : 'bg-gray-900 hover:bg-gray-800') }}">
                                {{ $plan->precio == 0 ? 'Comenzar Gratis' : 'Suscribirme' }}
                            </button>
                        </form>
                    @endif

                </div>
            @endforeach
        </div>

        <div class="text-center mt-12 text-sm text-gray-400">
            <p>Los pagos se procesan de forma segura a través de Stripe. Puedes cancelar en cualquier momento.</p>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease forwards; opacity: 0; }
</style>
@endsection