@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8" style="background: linear-gradient(180deg, #fef9f3 0%, #ffffff 100%);">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

        <!-- ============================================================
             HEADER
             ============================================================ -->
        <div class="mb-8 animate-fade-in-up">
            <span class="inline-flex items-center gap-2 bg-white text-green-700 text-xs font-semibold px-4 py-2 rounded-full mb-3 shadow-sm border border-green-100">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                    <path d="M3 3v5h5"></path>
                    <path d="M12 7v5l4 2"></path>
                </svg>
                Historial
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                Tus análisis <span class="text-green-600">nutricionales</span>
            </h1>
            <p class="text-gray-500 mt-2">Revisa todos los platos que has analizado con MIJUY.</p>
        </div>

        <!-- ============================================================
             GRID DE RECETAS
             ============================================================ -->
        @if($recetas->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recetas as $index => $receta)
                    @php
                        $nutricion = $receta->nutricion;
                    @endphp

                    <!-- Card de Receta -->
                    <a href="{{ route('recipe.show', $receta) }}"
                       class="group bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col animate-fade-in-up hover:-translate-y-1"
                       style="animation-delay: {{ $index * 0.05 }}s;">

                        <!-- Imagen -->
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            @if($receta->imagen_base64 || $receta->imagen_path)
                                <img src="{{ $receta->imagen_base64 ?? asset('storage/' . $receta->imagen_path) }}"
                                     alt="{{ $receta->nombre }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                        <circle cx="12" cy="13" r="3"></circle>
                                    </svg>
                                </div>
                            @endif

                            <!-- Badges flotantes -->
                            <div class="absolute top-3 left-3 flex flex-col gap-2">
                                @if($receta->es_publica)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full backdrop-blur-md shadow-sm" style="background: rgba(255,255,255,0.9); color: #16a34a;">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="2" y1="12" x2="22" y2="12"></line>
                                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                        </svg>
                                        Pública
                                    </span>
                                @endif
                                @if($receta->es_favorita)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full backdrop-blur-md shadow-sm" style="background: rgba(255,255,255,0.9); color: #d97706;">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                        Favorita
                                    </span>
                                @endif
                            </div>

                            <!-- Fecha flotante -->
                            <div class="absolute bottom-3 right-3">
                                <span class="text-[11px] font-medium text-white bg-black/50 backdrop-blur-sm px-2.5 py-1 rounded-full">
                                    {{ $receta->creado_en?->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-lg text-gray-900 leading-snug mb-1 group-hover:text-green-600 transition-colors">
                                {{ $receta->nombre }}
                            </h3>
                            <p class="text-sm text-gray-500 line-clamp-2 mb-4 flex-1">
                                {{ $receta->descripcion ?? 'Sin descripción.' }}
                            </p>

                            <!-- Macros -->
                            <div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-gray-100">
                                <!-- Calorías -->
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2 py-1 rounded-lg" style="background: #fff7ed; color: #ea580c;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path>
                                    </svg>
                                    {{ $nutricion->calorias ?? 'N/D' }}
                                </span>
                                
                                <!-- Proteína -->
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2 py-1 rounded-lg" style="background: #f0fdf4; color: #16a34a;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6.5 6.5h11"></path>
                                        <path d="M6.5 17.5h11"></path>
                                        <path d="M3 12h18"></path>
                                    </svg>
                                    {{ $nutricion->proteinas ?? 'N/D' }}
                                </span>

                                <!-- Carbohidratos -->
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2 py-1 rounded-lg" style="background: #eff6ff; color: #2563eb;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                        <path d="M2 12h20"></path>
                                    </svg>
                                    {{ $nutricion->carbohidratos ?? 'N/D' }}
                                </span>
                            </div>
                        </div>

                    </a>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-10 flex justify-center">
                {{ $recetas->links() }}
            </div>

        @else
            <!-- ============================================================
                 ESTADO VACÍO
                 ============================================================ -->
            <div class="bg-white rounded-3xl shadow-sm p-10 md:p-16 text-center animate-fade-in-up max-w-2xl mx-auto border border-gray-100">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full mb-6"
                     style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                        <circle cx="12" cy="13" r="3"></circle>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Aún no hay análisis</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8">
                    Escanea tu primer plato para comenzar a ver resultados aquí y descubrir sus valores nutricionales.
                </p>
                <a href="{{ route('scan') }}"
                   class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-bold text-white transition-all hover:-translate-y-0.5"
                   style="background: #22c55e; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                        <circle cx="12" cy="13" r="3"></circle>
                    </svg>
                    Escanear ahora
                </a>
            </div>
        @endif

    </div>
</div>

<!-- ============================================================
     ESTILOS EXTRA
     ============================================================ -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease forwards; opacity: 0; }

    /* Para que el texto largo no rompa la tarjeta */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    /* Paginación de Laravel estilizada */
    nav[role="navigation"] svg { width: 16px; height: 16px; }
    nav[role="navigation"] > div:first-child { display: none; }
    nav[role="navigation"] > div:last-child { display: flex; justify-content: center; }
    nav[role="navigation"] span[aria-current="page"] span,
    nav[role="navigation"] a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 0.75rem;
        border-radius: 50%;
        font-size: 0.875rem;
        font-weight: 600;
        margin: 0 0.25rem;
        transition: all 0.2s ease;
    }
    nav[role="navigation"] a {
        color: #4b5563;
        background: white;
        border: 1px solid #e5e7eb;
        text-decoration: none;
    }
    nav[role="navigation"] a:hover {
        background: #f0fdf4;
        color: #16a34a;
        border-color: #22c55e;
        transform: translateY(-1px);
    }
    nav[role="navigation"] span[aria-current="page"] span {
        background: #22c55e;
        color: white;
        border: 1px solid #22c55e;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }
    nav[role="navigation"] span[aria-disabled="true"] span {
        opacity: 0.4;
        cursor: not-allowed;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        color: #9ca3af;
    }
</style>

@endsection