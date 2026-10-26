@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8" style="background: linear-gradient(180deg, #fef9f3 0%, #ffffff 100%);">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

        <!-- ============================================================
             HEADER
             ============================================================ -->
        <div class="mb-10 text-center animate-fade-in-up">
            <span class="inline-flex items-center gap-2 bg-white text-red-500 text-xs font-bold uppercase tracking-wider px-4 py-2 rounded-full mb-4 shadow-sm border border-red-100">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                Tus Favoritos
            </span>
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 leading-tight">
                Recetas que <span class="text-red-500">amas</span>
            </h1>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto text-lg">Tu colección personal de platos saludables guardados.</p>
        </div>

        <!-- ============================================================
             GRID DE FAVORITOS
             ============================================================ -->
        @if($favoritos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($favoritos as $index => $receta)
                    <a href="{{ route('recipe.show', $receta) }}"
                       class="group bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 flex flex-col hover:-translate-y-1.5 animate-fade-in-up"
                       style="animation-delay: {{ $index * 0.05 }}s;">
                        
                        <!-- Imagen -->
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            @if($receta->imagen_base64 || $receta->imagen_path)
                                <img src="{{ $receta->imagen_base64 ?? asset('storage/' . $receta->imagen_path) }}" alt="{{ $receta->nombre }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path><circle cx="12" cy="13" r="3"></circle></svg>
                                </div>
                            @endif
                            
                            <!-- Icono de corazón flotante (indica que está en favs) -->
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white/90 backdrop-blur-md shadow-sm text-red-500">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-lg text-gray-900 leading-snug mb-2 group-hover:text-red-500 transition-colors line-clamp-2">
                                {{ $receta->nombre }}
                            </h3>
                            
                            <!-- Autor -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-white shadow-sm" style="background: linear-gradient(135deg, #22c55e, #16a34a);">
                                    {{ strtoupper(substr($receta->usuario->nombre ?? 'U', 0, 1)) }}
                                </div>
                                <span class="text-xs text-gray-500 font-medium">{{ $receta->usuario->nombre ?? 'Usuario' }}</span>
                            </div>

                            <!-- Macros -->
                            <div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-gray-100">
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1.5 rounded-lg" style="background: #fff7ed; color: #ea580c;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                                    {{ $receta->nutricion->calorias ?? 'N/D' }}
                                </span>
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1.5 rounded-lg" style="background: #f0fdf4; color: #16a34a;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6.5 6.5h11"></path><path d="M6.5 17.5h11"></path><path d="M3 12h18"></path></svg>
                                    {{ $receta->nutricion->proteinas ?? 'N/D' }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-12 flex justify-center">
                {{ $favoritos->links() }}
            </div>
        @else
            <!-- ============================================================
                 ESTADO VACÍO
                 ============================================================ -->
            <div class="bg-white rounded-3xl shadow-sm p-12 md:p-16 text-center border border-gray-100 max-w-xl mx-auto animate-fade-in-up">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-50 mb-6">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Aún no tienes favoritos</h3>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto">
                    Explora el foro, descubre recetas increíbles y dale al corazón para guardarlas aquí.
                </p>
                <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-bold text-white bg-green-600 hover:bg-green-700 transition-all hover:-translate-y-0.5 shadow-lg shadow-green-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Explorar el Foro
                </a>
            </div>
        @endif

    </div>
</div>

<!-- Estilos -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease forwards; opacity: 0; }
    
    nav[role="navigation"] svg { width: 16px; height: 16px; }
    nav[role="navigation"] > div:first-child { display: none; }
    nav[role="navigation"] > div:last-child { display: flex; justify-content: center; }
    nav[role="navigation"] span[aria-current="page"] span,
    nav[role="navigation"] a { display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 0.75rem; border-radius: 50%; font-size: 0.875rem; font-weight: 600; margin: 0 0.25rem; transition: all 0.2s ease; }
    nav[role="navigation"] a { color: #4b5563; background: white; border: 1px solid #e5e7eb; text-decoration: none; }
    nav[role="navigation"] a:hover { background: #fef2f2; color: #ef4444; border-color: #ef4444; transform: translateY(-1px); }
    nav[role="navigation"] span[aria-current="page"] span { background: #ef4444; color: white; border: 1px solid #ef4444; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }
    nav[role="navigation"] span[aria-disabled="true"] span { opacity: 0.4; cursor: not-allowed; background: #f9fafb; border: 1px solid #e5e7eb; color: #9ca3af; }
</style>

@endsection