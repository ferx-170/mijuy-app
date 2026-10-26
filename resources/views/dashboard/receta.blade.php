@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8" style="background: linear-gradient(180deg, #fef9f3 0%, #ffffff 100%);">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col lg:flex-row gap-8 max-w-6xl mx-auto">

            <!-- ============================================================
                 CONTENIDO PRINCIPAL
                 ============================================================ -->
            <main class="flex-1">

                <!-- Botón volver -->
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-green-600 transition mb-4">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Volver
                </a>

                <!-- Título y acciones principales -->
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 flex-wrap mb-2">
                            @if($receta->es_publica)
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full" style="background: #dcfce7; color: #16a34a;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                    </svg>
                                    Pública
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full" style="background: #f3f4f6; color: #6b7280;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    Privada
                                </span>
                            @endif

                            @if($receta->es_favorita)
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full" style="background: #fef3c7; color: #d97706;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                    Favorita
                                </span>
                            @endif

                            <span class="text-xs text-gray-400">
                                {{ $receta->creado_en?->diffForHumans() }}
                            </span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                            {{ $receta->nombre }}
                        </h1>
                        <p class="text-gray-500 mt-2 text-lg">{{ $receta->descripcion }}</p>
                    </div>
                </div>

                <!-- ============================================================
                     BARRA DE ACCIONES
                     ============================================================ -->
                <div class="flex flex-wrap items-center gap-3 mb-8">

                    <!-- Botón Guardar en Favoritos (Visible para TODOS) -->
                    <form action="{{ route('favorites.toggle', $receta) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-300 hover:-translate-y-0.5
                                {{ $esFavorita ? 'text-red-600' : 'text-gray-600' }}"
                                style="{{ $esFavorita ? 'background: #fef2f2; border: 1px solid #fecaca; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);' : 'background: white; border: 1px solid #e5e7eb;' }}">

                            <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $esFavorita ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>

                            <span>{{ $esFavorita ? 'Guardado en Favoritos' : 'Guardar en Favoritos' }}</span>
                        </button>
                    </form>

                    <!-- Botón Dar Like (Solo si NO es el creador) -->
                    @if(!$receta->esDelUsuario(Auth::id()))
                        <form action="{{ route('likes.toggle', $receta) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-300 hover:-translate-y-0.5
                                    {{ $tieneLike ? 'text-orange-600' : 'text-gray-600' }}"
                                    style="{{ $tieneLike ? 'background: #fff7ed; border: 1px solid #ffedd5;' : 'background: white; border: 1px solid #e5e7eb;' }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $tieneLike ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                </svg>
                                <span>{{ $tieneLike ? 'Te gusta' : 'Me gusta' }}</span>
                            </button>
                        </form>
                    @endif

                    <!-- Botón Compartir (Visible para TODOS si es pública, o si eres el dueño) -->
                    @if($receta->es_publica || $receta->esDelUsuario(Auth::id()))
                        <button type="button"
                                onclick="compartirReceta()"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm text-gray-600 bg-white hover:bg-gray-50 transition-all duration-300 hover:-translate-y-0.5"
                                style="border: 1px solid #e5e7eb;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="18" cy="5" r="3"></circle>
                                <circle cx="6" cy="12" r="3"></circle>
                                <circle cx="18" cy="19" r="3"></circle>
                                <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                            </svg>
                            <span>Compartir</span>
                        </button>
                    @endif

                    <!-- Botón Publicar/Ocultar (SOLO si eres el creador) -->
                    @if($receta->esDelUsuario(Auth::id()))
                        <form action="{{ route('recipe.publish', $receta) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-300 hover:-translate-y-0.5"
                                    style="{{ $receta->es_publica ? 'background: #fef3c7; color: #d97706; border: 1px solid #fde68a;' : 'background: #22c55e; color: white; border: 1px solid #16a34a; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);' }}">
                                @if($receta->es_publica)
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                        <line x1="1" y1="1" x2="23" y2="23"></line>
                                    </svg>
                                    <span>Ocultar del Foro</span>
                                @else
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <span>Publicar en Foro</span>
                                @endif
                            </button>
                        </form>
                    @endif
                </div>

                <!-- ============================================================
                     GRID: FOTO + MACROS
                     ============================================================ -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">

                    <!-- Foto -->
                    <div class="lg:col-span-1 bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
                        @if($receta->imagen_base64 || $receta->imagen_path)
                            <img src="{{ $receta->imagen_base64 ?? asset('storage/' . $receta->imagen_path) }}"
                                 alt="{{ $receta->nombre }}"
                                 class="w-full h-56 object-cover">
                        @else
                            <div class="w-full h-56 flex items-center justify-center bg-gray-100">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                    <circle cx="12" cy="13" r="3"></circle>
                                </svg>
                            </div>
                        @endif
                        <div class="p-3 bg-gray-50 flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                    <circle cx="12" cy="13" r="3"></circle>
                                </svg>
                                Foto analizada
                            </span>
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
                                IA Vision
                            </span>
                        </div>
                    </div>

                    <!-- Macros -->
                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-orange-50 rounded-3xl p-5 text-center border border-orange-100">
                            <p class="inline-flex items-center gap-1.5 text-xs text-gray-500 font-semibold mb-1">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path>
                                </svg>
                                Calorías
                            </p>
                            <p class="text-2xl font-bold text-orange-600">{{ $receta->nutricion->calorias ?? 'N/D' }}</p>
                        </div>
                        <div class="bg-green-50 rounded-3xl p-5 text-center border border-green-100">
                            <p class="inline-flex items-center gap-1.5 text-xs text-gray-500 font-semibold mb-1">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6.5 6.5h11"></path>
                                    <path d="M6.5 17.5h11"></path>
                                    <path d="M3 12h18"></path>
                                </svg>
                                Proteína
                            </p>
                            <p class="text-2xl font-bold text-green-600">{{ $receta->nutricion->proteinas ?? 'N/D' }}</p>
                        </div>
                        <div class="bg-blue-50 rounded-3xl p-5 text-center border border-blue-100">
                            <p class="inline-flex items-center gap-1.5 text-xs text-gray-500 font-semibold mb-1">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                    <path d="M2 12h20"></path>
                                </svg>
                                Carbohidratos
                            </p>
                            <p class="text-2xl font-bold text-blue-600">{{ $receta->nutricion->carbohidratos ?? 'N/D' }}</p>
                        </div>
                    </div>
                </div>

                <!-- ============================================================
                     TABLA NUTRICIONAL COMPLETA
                     ============================================================ -->
                @if($receta->nutricion)
                <div class="bg-white rounded-3xl shadow-sm p-6 mb-8 border border-gray-100">
                    <h3 class="font-bold text-gray-900 text-lg mb-4">Información Nutricional</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @php
                            $nutrientes = [
                                ['label' => 'Calorías', 'value' => $receta->nutricion->calorias, 'bg' => '#fff7ed', 'color' => '#ea580c', 'icon' => '<path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path>'],
                                ['label' => 'Proteínas', 'value' => $receta->nutricion->proteinas, 'bg' => '#f0fdf4', 'color' => '#16a34a', 'icon' => '<path d="M6.5 6.5h11"></path><path d="M6.5 17.5h11"></path><path d="M3 12h18"></path>'],
                                ['label' => 'Grasas totales', 'value' => $receta->nutricion->grasas_totales, 'bg' => '#fef3c7', 'color' => '#d97706', 'icon' => '<circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>'],
                                ['label' => 'Grasas saturadas', 'value' => $receta->nutricion->grasas_saturadas, 'bg' => '#fef2f2', 'color' => '#dc2626', 'icon' => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>'],
                                ['label' => 'Carbohidratos', 'value' => $receta->nutricion->carbohidratos, 'bg' => '#eff6ff', 'color' => '#2563eb', 'icon' => '<path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"></path><path d="M7 2v20"></path>'],
                                ['label' => 'Azúcares', 'value' => $receta->nutricion->azucares, 'bg' => '#fce7f3', 'color' => '#db2777', 'icon' => '<path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>'],
                                ['label' => 'Fibra', 'value' => $receta->nutricion->fibra, 'bg' => '#f0fdf4', 'color' => '#15803d', 'icon' => '<path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>'],
                                ['label' => 'Sodio', 'value' => $receta->nutricion->sodio, 'bg' => '#f3f4f6', 'color' => '#4b5563', 'icon' => '<circle cx="12" cy="12" r="10"></circle>'],
                                ['label' => 'Colesterol', 'value' => $receta->nutricion->colesterol, 'bg' => '#f3e8ff', 'color' => '#7c3aed', 'icon' => '<circle cx="12" cy="12" r="10"></circle>'],
                                ['label' => 'Calcio', 'value' => $receta->nutricion->calcio, 'bg' => '#f0fdfa', 'color' => '#0d9488', 'icon' => '<circle cx="12" cy="12" r="10"></circle>'],
                            ];
                        @endphp
                        @foreach($nutrientes as $n)
                            <div class="rounded-2xl p-3 flex items-center gap-3" style="background: {{ $n['bg'] }};">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $n['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    {!! $n['icon'] !!}
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-500">{{ $n['label'] }}</p>
                                    <p class="font-bold text-sm" style="color: {{ $n['color'] }};">{{ $n['value'] ?? 'N/D' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- ============================================================
                     TIP NUTRICIONAL
                     ============================================================ -->
                @if($receta->tip_nutricional)
                <div class="rounded-3xl p-6 mb-8" style="background: #f0fdf4; border: 1px solid #dcfce7;">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0 bg-white">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18h6"></path>
                                <path d="M10 22h4"></path>
                                <path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"></path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-bold text-green-800 mb-1">Tip Nutricional</h5>
                            <p class="text-sm text-gray-600">{!! $receta->tip_nutricional !!}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- ============================================================
                     INGREDIENTES FALTANTES
                     ============================================================ -->
                @if($receta->ingredientesFaltantes->count() > 0)
                <div class="bg-white rounded-3xl shadow-sm p-6 mb-8 border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-gray-900 inline-flex items-center gap-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            Ingredientes faltantes
                        </h3>
                        <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-2 py-1 rounded-full">
                            {{ $receta->ingredientesFaltantes->count() }} items
                        </span>
                    </div>
                    <div class="space-y-2">
                        @foreach($receta->ingredientesFaltantes as $ing)
                            <div class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition">
                                <input type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-green-600">
                                <span class="text-gray-700">{{ $ing->nombre }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- ============================================================
                     INGREDIENTES + PREPARACIÓN
                     ============================================================ -->
                <div class="bg-white rounded-3xl shadow-sm p-6 md:p-8 border border-gray-100">

                    @if($receta->recomendacion)
                        <div class="mb-6 pb-6 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-1 inline-flex items-center gap-2">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                Versión MIJUY: {{ $receta->recomendacion }}
                            </h3>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- Ingredientes -->
                        <div>
                            <h4 class="font-bold text-gray-900 mb-4 inline-flex items-center gap-2">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"></path>
                                    <path d="M7 2v20"></path>
                                    <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"></path>
                                </svg>
                                INGREDIENTES
                            </h4>
                            <ul class="space-y-2">
                                @forelse($receta->ingredientesReales as $ing)
                                    <li class="flex items-start gap-2 text-gray-600">
                                        <span class="w-1.5 h-1.5 rounded-full mt-2 flex-shrink-0" style="background: #22c55e;"></span>
                                        <span>{{ $ing->nombre }}</span>
                                    </li>
                                @empty
                                    <li class="text-gray-400 text-sm">No hay ingredientes registrados.</li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Preparación -->
                        <div>
                            <h4 class="font-bold text-gray-900 mb-4 inline-flex items-center gap-2">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                PREPARACIÓN
                            </h4>
                            <ol class="space-y-3">
                                @forelse($receta->pasos as $paso)
                                    <li class="flex gap-3 text-sm text-gray-600 leading-relaxed">
                                        <span class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-white" style="background: #f97316;">
                                            {{ $paso->numero_paso }}
                                        </span>
                                        <span class="pt-0.5">{{ $paso->descripcion }}</span>
                                    </li>
                                @empty
                                    <li class="text-gray-400 text-sm">No hay pasos registrados.</li>
                                @endforelse
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Botón escanear otro -->
                <div class="text-center mt-8">
                    <a href="{{ route('scan') }}"
                       class="inline-flex items-center gap-2 px-8 py-3 rounded-full font-bold text-white transition-all hover:-translate-y-0.5"
                       style="background: #22c55e; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Analizar otro plato
                    </a>
                </div>

            </main>

            <!-- ============================================================
                 SIDEBAR: INFO DEL AUTOR + COMENTARIOS
                 ============================================================ -->
            <aside class="lg:w-72 xl:w-80">
                <div class="lg:sticky lg:top-24">

                    <!-- Tarjeta del autor -->
                    <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                        <h6 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Autor</h6>

                        <!-- Bloque del Autor (Clickeable) -->
                        <button type="button"
                                onclick="openAuthorModal(@js($receta->usuario), @js($receta->usuario->recetasPublicas))"
                                class="w-full flex items-center gap-3 mb-4 p-2 rounded-2xl hover:bg-gray-50 transition-colors text-left border-0 bg-transparent">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold overflow-hidden shadow-sm flex-shrink-0"
                                 style="background: linear-gradient(135deg, #22c55e, #16a34a);">
                                @if($receta->usuario->avatar)
                                    <img src="{{ $receta->usuario->avatar }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($receta->usuario->nombre ?? 'U', 0, 1)) }}
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-gray-900 truncate group-hover:text-green-600 transition-colors">{{ $receta->usuario->nombre ?? 'Usuario' }}</p>
                                <p class="text-xs text-gray-500">
                                    Ver perfil
                                </p>
                            </div>
                        </button>

                        <div class="grid grid-cols-2 gap-3 mt-4 pt-4 border-t border-gray-100">
                            <div class="text-center">
                                <p class="text-xl font-bold text-gray-900 inline-flex items-center gap-1">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#dc2626" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                    {{ $receta->total_likes }}
                                </p>
                                <p class="text-xs text-gray-500">Likes</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xl font-bold text-gray-900 inline-flex items-center gap-1">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    {{ $receta->vistas }}
                                </p>
                                <p class="text-xs text-gray-500">Vistas</p>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================
                         COMENTARIOS (SIDEBAR)
                         ============================================================ -->
                    <div class="bg-white rounded-3xl shadow-sm p-6 mt-6 border border-gray-100">

                        <!-- Encabezado -->
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                Comentarios
                            </h3>
                            <span class="text-xs font-bold text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                                {{ $receta->comentarios->count() }}
                            </span>
                        </div>

                        <!-- Formulario -->
                        @if(!$receta->esDelUsuario(Auth::id()))
                            <form action="{{ route('comments.store', $receta) }}" method="POST" class="mb-6">
                                @csrf
                                <div class="flex gap-3 items-start">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0 text-sm overflow-hidden"
                                         style="background: linear-gradient(135deg, #22c55e, #16a34a);">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ Auth::user()->avatar }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <textarea name="contenido" rows="3" required
                                                  class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm text-gray-700 placeholder-gray-400 transition-all resize-none"
                                                  placeholder="Escribe un comentario..."></textarea>
                                        @error('contenido')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit"
                                        class="w-full mt-3 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-bold text-sm text-white transition-all duration-300 hover:-translate-y-0.5 active:scale-95"
                                        style="background: #22c55e; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                    Publicar comentario
                                </button>
                            </form>
                        @else
                            <div class="bg-gray-50 rounded-2xl p-4 mb-6 text-center">
                                <p class="text-sm text-gray-500">Eres el autor de esta receta. Los usuarios podrán dejar sus comentarios aquí.</p>
                            </div>
                        @endif

                        <!-- Lista de comentarios -->
                        <div class="space-y-4 max-h-[460px] overflow-y-auto pr-2 custom-scrollbar border-t border-gray-100 pt-5">
                            @forelse($receta->comentarios as $comentario)
                                <div class="flex gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0 text-sm overflow-hidden"
                                         style="background: linear-gradient(135deg, #f97316, #ea580c);">
                                        @if($comentario->usuario->avatar)
                                            <img src="{{ $comentario->usuario->avatar }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($comentario->usuario->nombre ?? 'U', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0 bg-gray-50 rounded-2xl px-4 py-3">
                                        <div class="flex justify-between items-center gap-2 mb-1">
                                            <p class="font-bold text-sm text-gray-900 truncate">{{ $comentario->usuario->nombre ?? 'Usuario' }}</p>

                                            {{-- Solo el autor del comentario ve el botón de borrar --}}
                                            @if(Auth::id() === $comentario->usuario_id)
                                                <button type="button"
                                                        onclick="openDeleteModal('{{ route('comments.destroy', $comentario) }}')"
                                                        title="Eliminar comentario" aria-label="Eliminar comentario"
                                                        class="w-8 h-8 -mr-2 flex-shrink-0 rounded-full inline-flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path></svg>
                                                </button>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-700 leading-relaxed break-words">{{ $comentario->contenido }}</p>
                                        <p class="text-xs text-gray-400 mt-2">{{ $comentario->creado_en->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6">
                                    <p class="text-gray-400 text-sm">Sin comentarios aún.</p>
                                    <p class="text-gray-300 text-xs mt-1">¡Sé el primero en comentar!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </aside>

        </div>
    </div>
</div>

<!-- ============================================================
     ESTILOS Y SCRIPTS
     ============================================================ -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease forwards; }

    /* Scrollbar de los comentarios */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>

<!-- Modal de confirmación de borrado -->
<div id="deleteCommentModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999; align-items: center; justify-content: center; background: rgba(0, 0, 0, 0.5); padding: 1rem;">
    <div class="bg-white rounded-3xl shadow-2xl p-6 text-center" style="width: 100%; max-width: 24rem; margin: auto;">
        <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">¿Eliminar comentario?</h3>
        <p class="text-gray-500 text-sm mb-6">Esta acción no se puede deshacer. El comentario desaparecerá permanentemente.</p>

        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 py-3 rounded-xl font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                Cancelar
            </button>
            <form id="deleteCommentForm" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-3 rounded-xl font-semibold text-white bg-red-500 hover:bg-red-600 transition-colors">
                    Sí, eliminar
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Lógica para el modal de borrar comentario
    function openDeleteModal(actionUrl) {
        const modal = document.getElementById('deleteCommentModal');
        const form = document.getElementById('deleteCommentForm');

        // Mover el modal al <body> para que quede centrado en la pantalla
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }

        // Asignar la URL de acción al formulario
        form.action = actionUrl;

        // Mostrar el modal
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteCommentModal');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    // Cerrar al hacer clic en el fondo
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'deleteCommentModal') closeDeleteModal();
    });

    // Cerrar con la tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });

    function compartirReceta() {
        const url = window.location.href;
        const titulo = "{{ addslashes($receta->nombre) }}";

        if (navigator.share) {
            navigator.share({
                title: titulo,
                text: 'Mira esta receta saludable en MIJUY',
                url: url
            }).catch(err => console.log('Error compartiendo:', err));
        } else {
            navigator.clipboard.writeText(url).then(() => {
                if (window.showToast) {
                    showToast('Enlace copiado al portapapeles', 'success');
                } else {
                    alert('Enlace copiado al portapapeles');
                }
            });
        }
    }

    /* ---- Lógica del Modal de Perfil Público ---- */
    window.openAuthorModal = function(author, recipes) {
        // 1. Nombre y Bio
        document.getElementById('authorName').textContent = author.nombre;
        document.getElementById('authorNameInline').textContent = author.nombre;

        const date = new Date(author.creado_en);
        const options = { year: 'numeric', month: 'long' };
        document.getElementById('authorJoined').textContent = 'Miembro desde ' + date.toLocaleDateString('es-ES', options);

        document.getElementById('authorBio').textContent = author.bio
            ? `"${author.bio}"`
            : '"Este usuario aún no ha escrito una biografía."';

        // 2. Avatar
        const avatarContainer = document.getElementById('authorAvatarContainer');
        if (author.avatar) {
            avatarContainer.innerHTML = `<img src="${author.avatar}" class="w-100 h-100 object-cover">`;
        } else {
            avatarContainer.innerHTML = `<span class="fs-2 fw-bold text-white">${author.nombre.charAt(0).toUpperCase()}</span>`;
            avatarContainer.style.background = 'linear-gradient(135deg, #22c55e, #16a34a)';
        }

        // 3. Otras recetas
        const recipesGrid = document.getElementById('authorRecipesGrid');
        recipesGrid.innerHTML = '';

        if (recipes && recipes.length > 0) {
            recipes.forEach(receta => {
                const imgSrc = receta.imagen_base64 || (receta.imagen_path ? `/storage/${receta.imagen_path}` : null);

                let imgHTML = '';
                if (imgSrc) {
                    imgHTML = `<img src="${imgSrc}" class="w-100 h-100 object-cover transition-transform duration-500 group-hover:scale-110">`;
                } else {
                    imgHTML = `<div class="w-100 h-100 d-flex align-items-center justify-content-center bg-gray-100"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path><circle cx="12" cy="13" r="3"></circle></svg></div>`;
                }

                const recipeCard = `
                    <a href="/receta/${receta.id}" class="group block rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-shadow bg-white text-decoration-none">
                        <div class="h-24 overflow-hidden">
                            ${imgHTML}
                        </div>
                        <div class="p-2">
                            <p class="text-[11px] font-bold text-gray-800 line-clamp-2 m-0 leading-tight group-hover:text-green-600 transition-colors">${receta.nombre}</p>
                        </div>
                    </a>
                `;
                recipesGrid.innerHTML += recipeCard;
            });
        } else {
            recipesGrid.innerHTML = `<p class="text-gray-400 text-sm col-span-full">No tiene más recetas públicas.</p>`;
        }

        // 4. Mostrar Modal
        const modal = new bootstrap.Modal(document.getElementById('authorProfileModal'));
        modal.show();
    };
</script>
@endpush
@endsection