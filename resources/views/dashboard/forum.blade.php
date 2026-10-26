@extends('layouts.app')

@section('content')
@php
    $buscar    = request('buscar');
    $catActiva = request('categoria');
    $orden     = request('orden', 'recientes');
    $catActual = $catActiva ? $categorias->firstWhere('slug', $catActiva) : null;
    $hayFiltros = $buscar || $catActiva;
@endphp

<div class="min-h-screen pb-12" style="background: linear-gradient(180deg, #fef9f3 0%, #ffffff 100%);">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

        {{-- ============================================================
             HEADER
             ============================================================ --}}
        <header class="pt-8 pb-6 md:pt-12 md:pb-8 text-center">
            <span class="inline-flex items-center gap-2 bg-white text-orange-600 text-xs font-bold uppercase tracking-wider px-4 py-2 rounded-full mb-4 shadow-sm border border-orange-100">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Comunidad
            </span>
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 leading-tight">
                Foro de <span class="text-orange-500">Recetas</span>
            </h1>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto text-base md:text-lg">
                Descubre, guarda y comparte platos saludables creados por la comunidad MIJUY.
            </p>
        </header>

        {{-- ============================================================
             BARRA DE BÚSQUEDA Y FILTROS (sticky)
             Si tu navbar principal es fijo, ajusta --foro-sticky-top
             ============================================================ --}}
        <div id="filtrosBar" class="foro-bar sticky z-30 mb-4">
            <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-sm border border-gray-100 p-2 flex flex-col lg:flex-row lg:items-center gap-2">

                {{-- Buscador --}}
                <form id="filtrosForm" action="{{ route('forum.index') }}" method="GET" role="search"
                      class="relative w-full lg:w-80 flex-shrink-0">
                    @if($catActiva)
                        <input type="hidden" name="categoria" value="{{ $catActiva }}">
                    @endif

                    <label for="buscar" class="sr-only">Buscar recetas</label>
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>

                    <input id="buscar" type="search" name="buscar" value="{{ $buscar }}"
                           placeholder="Buscar recetas…" autocomplete="off" enterkeyhint="search"
                           class="foro-search w-full pl-10 pr-20 py-2.5 rounded-xl border-0 bg-gray-50 text-sm font-medium transition-shadow focus:bg-white focus:ring-2 focus:ring-green-500"
                           style="box-shadow: none;">

                    <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                        @if($buscar)
                            <a href="{{ route('forum.index', request()->except('buscar', 'page')) }}"
                               aria-label="Borrar búsqueda"
                               class="w-7 h-7 inline-flex items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-200 transition-colors">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </a>
                        @else
                            <kbd class="hidden lg:inline-flex items-center justify-center w-6 h-6 rounded-md border border-gray-200 bg-white text-[11px] font-semibold text-gray-400" aria-hidden="true">/</kbd>
                        @endif
                    </div>
                </form>

                <div class="hidden lg:block w-px h-8 bg-gray-200 mx-1"></div>

                {{-- Categorías con scroll horizontal y fundidos en los bordes --}}
                <div class="relative flex-1 min-w-0">
                    <button type="button" id="catPrev" aria-label="Categorías anteriores"
                            class="foro-arrow hidden lg:flex absolute left-0 top-1/2 -translate-y-1/2 z-10 w-8 h-8 items-center justify-center rounded-full bg-white border border-gray-200 shadow-sm text-gray-600 hover:text-green-600 hover:border-green-500 transition-colors opacity-0 pointer-events-none">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>

                    <nav id="catScroller" aria-label="Filtrar por categoría"
                         class="foro-cats flex items-center gap-1.5 overflow-x-auto scrollbar-hide py-1 px-1 snap-x">
                        <a href="{{ route('forum.index', request()->except('categoria', 'page')) }}"
                           @if(!$catActiva) aria-current="true" data-active="true" @endif
                           class="foro-chip snap-start px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ !$catActiva ? 'bg-gray-900 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                            Todas
                        </a>

                        @foreach($categorias as $cat)
                            @php $activa = $catActiva === $cat->slug; @endphp
                            <a href="{{ route('forum.index', array_merge(request()->except('page'), ['categoria' => $cat->slug])) }}"
                               @if($activa) aria-current="true" data-active="true" @endif
                               class="foro-chip snap-start px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap flex items-center gap-1.5 {{ $activa ? 'bg-green-600 text-white shadow-md shadow-green-200' : 'text-gray-600 hover:bg-gray-100' }}">
                                {{ $cat->nombre }}
                                <span class="text-[10px] px-1.5 py-0.5 rounded-md {{ $activa ? 'bg-white/20 text-white' : 'bg-gray-200/60 text-gray-500' }}">
                                    {{ $cat->total_recetas }}
                                </span>
                            </a>
                        @endforeach
                    </nav>

                    <button type="button" id="catNext" aria-label="Más categorías"
                            class="foro-arrow hidden lg:flex absolute right-0 top-1/2 -translate-y-1/2 z-10 w-8 h-8 items-center justify-center rounded-full bg-white border border-gray-200 shadow-sm text-gray-600 hover:text-green-600 hover:border-green-500 transition-colors">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                </div>

                {{-- Ordenar (requiere soporte en el controlador: ?orden=) --}}
                <div class="flex-shrink-0 lg:pl-1">
                    <label for="orden" class="sr-only">Ordenar recetas</label>
                    <select id="orden" name="orden" form="filtrosForm"
                            class="foro-select w-full lg:w-auto rounded-xl border-0 bg-gray-50 py-2.5 pl-3 pr-9 text-xs font-bold text-gray-700 cursor-pointer hover:bg-gray-100 focus:ring-2 focus:ring-green-500 transition-colors">
                        <option value="recientes" @selected($orden === 'recientes')>Más recientes</option>
                        <option value="populares" @selected($orden === 'populares')>Más populares</option>
                        <option value="vistas"    @selected($orden === 'vistas')>Más vistas</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- ============================================================
             RESUMEN DE RESULTADOS + FILTROS ACTIVOS
             ============================================================ --}}
        <div class="flex flex-wrap items-center gap-2 mb-6 min-h-[2rem]" aria-live="polite">
            <p class="text-sm text-gray-500">
                <span class="font-bold text-gray-900">{{ $recetas->total() }}</span>
                {{ $recetas->total() === 1 ? 'receta' : 'recetas' }}
            </p>

            @if($buscar)
                <a href="{{ route('forum.index', request()->except('buscar', 'page')) }}"
                   class="foro-tag inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-white border border-gray-200 text-gray-700 hover:border-red-300 hover:text-red-600">
                    “{{ \Illuminate\Support\Str::limit($buscar, 24) }}”
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    <span class="sr-only">Quitar búsqueda</span>
                </a>
            @endif

            @if($catActual)
                <a href="{{ route('forum.index', request()->except('categoria', 'page')) }}"
                   class="foro-tag inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-green-50 border border-green-200 text-green-700 hover:border-red-300 hover:text-red-600 hover:bg-red-50">
                    {{ $catActual->nombre }}
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    <span class="sr-only">Quitar categoría</span>
                </a>
            @endif

            @if($hayFiltros)
                <a href="{{ route('forum.index') }}" class="text-xs font-semibold text-gray-500 hover:text-orange-600 underline-offset-4 hover:underline transition-colors">
                    Limpiar todo
                </a>
            @endif
        </div>

        {{-- ============================================================
             GRID DE RECETAS
             ============================================================ --}}
        @if($recetas->count() > 0)
            <div id="recetasGrid" class="foro-grid grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                @foreach($recetas as $index => $receta)
                    @php
                        $img = $receta->imagen_base64 ?? ($receta->imagen_path ? asset('storage/' . $receta->imagen_path) : null);
                    @endphp
                    <a href="{{ route('recipe.show', $receta) }}"
                       class="foro-card group bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100 flex flex-col"
                       style="--i: {{ min($index, 8) }};">

                        {{-- Imagen + stats --}}
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                            @if($img)
                                <img src="{{ $img }}" alt="{{ $receta->nombre }}" loading="lazy" decoding="async"
                                     class="foro-img w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path><circle cx="12" cy="13" r="3"></circle></svg>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 group-focus-visible:opacity-100 transition-opacity duration-300"></div>

                            <div class="absolute top-3 right-3 flex flex-col gap-1.5 items-end">
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-white bg-black/40 backdrop-blur-md px-2.5 py-1.5 rounded-full border border-white/10 shadow-sm" title="Me gusta">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#dc2626" stroke="#dc2626" stroke-width="2" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                    <span class="sr-only">Me gusta:</span>{{ $receta->total_likes }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-white bg-black/40 backdrop-blur-md px-2.5 py-1.5 rounded-full border border-white/10 shadow-sm" title="Vistas">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    <span class="sr-only">Vistas:</span>{{ $receta->vistas }}
                                </span>
                            </div>
                        </div>

                        {{-- Contenido --}}
                        <div class="p-4 sm:p-5 flex-1 flex flex-col">
                            @if($receta->categorias->count() > 0)
                                <span class="text-[10px] font-bold uppercase tracking-wider text-green-600 mb-1">
                                    {{ $receta->categorias->first()->nombre }}
                                </span>
                            @endif

                            <h3 class="font-bold text-lg text-gray-900 leading-snug mb-2 group-hover:text-green-600 transition-colors line-clamp-2">
                                {{ $receta->nombre }}
                            </h3>

                                                       <!-- Autor (Clickeable para abrir Modal) -->
                            <div class="flex items-center gap-2 mb-4">
                                <button type="button" 
                                        onclick="event.preventDefault(); openAuthorModal(@js($receta->usuario), @js($receta->usuario->recetasPublicas))"
                                        class="flex items-center gap-2 hover:opacity-80 transition-opacity text-left">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-white shadow-sm flex-shrink-0 overflow-hidden" style="background: linear-gradient(135deg, #22c55e, #16a34a);" aria-hidden="true">
                                        @if($receta->usuario->avatar)
                                            <img src="{{ $receta->usuario->avatar }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($receta->usuario->nombre ?? 'U', 0, 1)) }}
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-500 font-medium truncate hover:text-green-600 transition-colors">{{ $receta->usuario->nombre ?? 'Usuario' }}</span>
                                </button>
                                <span class="text-[10px] text-gray-400 ml-auto whitespace-nowrap">{{ $receta->creado_en?->diffForHumans() }}</span>
                            </div>

                            <div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-gray-100">
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1.5 rounded-lg" style="background: #fff7ed; color: #ea580c;" title="Calorías">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path>
                                    </svg>
                                    <span class="sr-only">Calorías:</span>{{ $receta->nutricion->calorias ?? 'N/D' }}
                                </span>
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1.5 rounded-lg" style="background: #f0fdf4; color: #16a34a;" title="Proteínas">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M6.5 6.5h11"></path>
                                        <path d="M6.5 17.5h11"></path>
                                        <path d="M3 12h18"></path>
                                    </svg>
                                    <span class="sr-only">Proteínas:</span>{{ $receta->nutricion->proteinas ?? 'N/D' }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $recetas->links() }}
            </div>
        @else
            {{-- ============================================================
                 ESTADO VACÍO
                 ============================================================ --}}
            <div class="foro-fade bg-white rounded-3xl shadow-sm p-10 md:p-16 text-center border border-gray-100 max-w-xl mx-auto">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-orange-50 mb-6">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No se encontraron recetas</h3>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto">
                    @if($hayFiltros)
                        No hay resultados para tu búsqueda. Prueba con otros términos o limpia los filtros.
                    @else
                        Aún no hay recetas públicas. ¡Sé el primero en compartir tu creación con la comunidad!
                    @endif
                </p>

                @if($hayFiltros)
                    <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        Limpiar filtros
                    </a>
                @else
                    <a href="{{ route('my.history') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-bold text-white bg-green-600 hover:bg-green-700 transition-all hover:-translate-y-0.5 shadow-lg shadow-green-200">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
                        Ir a mi historial
                    </a>
                @endif
            </div>
        @endif

    </div>
</div>

{{-- Barra de progreso al navegar --}}
<div id="foroProgress" class="fixed top-0 left-0 h-0.5 bg-green-500 z-50 w-0 opacity-0 pointer-events-none"></div>

{{-- ============================================================
     ESTILOS
     ============================================================ --}}
<style>
    :root { --foro-sticky-top: 0.5rem; }
    .foro-bar { top: var(--foro-sticky-top); }

    /* Entrada: solo al cargar, escalonada hasta la 8.ª tarjeta */
    @keyframes foroIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .foro-card { animation: foroIn .45s cubic-bezier(.22,.61,.36,1) both; animation-delay: calc(var(--i, 0) * 45ms); }
    .foro-fade { animation: foroIn .4s ease both; }

    /* Tarjetas */
    .foro-card {
        transition: transform .3s cubic-bezier(.22,.61,.36,1), box-shadow .3s ease, border-color .3s ease;
        -webkit-tap-highlight-color: transparent;
    }
    .foro-img { transition: transform .6s cubic-bezier(.22,.61,.36,1); }
    @media (hover: hover) {
        .foro-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(0,0,0,.15); border-color: #bbf7d0; }
        .foro-card:hover .foro-img { transform: scale(1.06); }
    }
    .foro-card:active { transform: scale(.985); }
    .foro-card:focus-visible,
    .foro-chip:focus-visible,
    .foro-tag:focus-visible,
    .foro-arrow:focus-visible { outline: 3px solid #22c55e; outline-offset: 2px; }

    /* Chips de categoría */
    .foro-chip { transition: background-color .2s ease, color .2s ease, box-shadow .2s ease, transform .15s ease; }
    .foro-chip:active { transform: scale(.96); }
    .foro-tag { transition: all .2s ease; }

    /* Scroll de categorías con fundido en los bordes */
    .foro-cats {
        scroll-behavior: smooth;
        -webkit-mask-image: linear-gradient(to right, transparent 0, #000 var(--fade-l, 0px), #000 calc(100% - var(--fade-r, 24px)), transparent 100%);
                mask-image: linear-gradient(to right, transparent 0, #000 var(--fade-l, 0px), #000 calc(100% - var(--fade-r, 24px)), transparent 100%);
    }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .foro-arrow { transition: opacity .2s ease, color .2s ease, border-color .2s ease; }

    /* Inputs */
    .foro-search::-webkit-search-cancel-button { display: none; }
    .foro-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right .75rem center; }

    /* Estado de carga al cambiar filtros */
    .foro-grid { transition: opacity .25s ease, filter .25s ease; }
    .foro-grid.is-loading { opacity: .45; filter: grayscale(.2); pointer-events: none; }

    /* Paginación de Laravel */
    nav[role="navigation"] svg { width: 16px; height: 16px; }
    nav[role="navigation"] > div:first-child { display: none; }
    nav[role="navigation"] > div:last-child { display: flex; justify-content: center; }
    nav[role="navigation"] > div:last-child > div:first-child { display: none; }
    nav[role="navigation"] span[aria-current="page"] span,
    nav[role="navigation"] a,
    nav[role="navigation"] span[aria-disabled="true"] span {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 40px; height: 40px; padding: 0 .75rem;
        border-radius: 9999px; font-size: .875rem; font-weight: 600;
        margin: 0 .2rem; transition: all .2s ease;
    }
    nav[role="navigation"] a { color: #4b5563; background: #fff; border: 1px solid #e5e7eb; text-decoration: none; }
    nav[role="navigation"] a:hover { background: #f0fdf4; color: #16a34a; border-color: #22c55e; transform: translateY(-1px); }
    nav[role="navigation"] span[aria-current="page"] span { background: #22c55e; color: #fff; border: 1px solid #22c55e; box-shadow: 0 4px 12px rgba(34,197,94,.3); }
    nav[role="navigation"] span[aria-disabled="true"] span { opacity: .4; cursor: not-allowed; background: #f9fafb; border: 1px solid #e5e7eb; color: #9ca3af; }
    @media (max-width: 480px) {
        nav[role="navigation"] a, nav[role="navigation"] span[aria-current="page"] span, nav[role="navigation"] span[aria-disabled="true"] span { min-width: 36px; height: 36px; margin: 0 .1rem; }
    }

    /* Accesibilidad: sin movimiento si el usuario lo pide */
    @media (prefers-reduced-motion: reduce) {
        .foro-card, .foro-fade { animation: none; }
        .foro-card, .foro-img, .foro-chip, .foro-grid { transition: none; }
        .foro-cats { scroll-behavior: auto; }
    }
</style>

{{-- ============================================================
     SCRIPT (sin dependencias)
     ============================================================ --}}
<script>
(function () {
    const form     = document.getElementById('filtrosForm');
    const input    = document.getElementById('buscar');
    const orden    = document.getElementById('orden');
    const scroller = document.getElementById('catScroller');
    const prev     = document.getElementById('catPrev');
    const next     = document.getElementById('catNext');
    const grid     = document.getElementById('recetasGrid');
    const bar      = document.getElementById('foroProgress');
    if (!form || !input || !scroller) return;

    /* ---- Estado de carga + barra de progreso ---- */
    function startLoading() {
        if (grid) { grid.classList.add('is-loading'); grid.setAttribute('aria-busy', 'true'); }
        if (bar) {
            bar.style.opacity = '1';
            bar.style.transition = 'width 8s cubic-bezier(.1,.7,.2,1)';
            requestAnimationFrame(() => { bar.style.width = '85%'; });
        }
    }
    // Al volver con el botón "atrás" (bfcache) se quita el estado de carga
    window.addEventListener('pageshow', () => {
        if (grid) { grid.classList.remove('is-loading'); grid.removeAttribute('aria-busy'); }
        if (bar) { bar.style.transition = 'none'; bar.style.width = '0'; bar.style.opacity = '0'; }
    });

    /* ---- Búsqueda con debounce (se envía sola al dejar de escribir) ---- */
    let timer;
    input.addEventListener('input', () => {
        clearTimeout(timer);
        const v = input.value.trim();
        if (v.length === 1) return; // evita buscar con 1 letra
        timer = setTimeout(() => {
            try { sessionStorage.setItem('foroFocus', '1'); } catch (e) {}
            startLoading();
            form.requestSubmit();
        }, 500);
    });
    form.addEventListener('submit', () => { clearTimeout(timer); startLoading(); });

    // Recupera el foco y el cursor tras recargar por escribir
    try {
        if (sessionStorage.getItem('foroFocus')) {
            sessionStorage.removeItem('foroFocus');
            input.focus({ preventScroll: true });
            const len = input.value.length;
            input.setSelectionRange(len, len);
        }
    } catch (e) {}

    /* ---- Ordenar: envía al cambiar ---- */
    if (orden) orden.addEventListener('change', () => { startLoading(); form.requestSubmit(); });

    /* ---- Atajo "/" para buscar ---- */
    document.addEventListener('keydown', (e) => {
        const tag = (e.target.tagName || '').toLowerCase();
        if (e.key === '/' && !['input', 'textarea', 'select'].includes(tag) && !e.target.isContentEditable) {
            e.preventDefault();
            input.focus();
            input.select();
        }
        if (e.key === 'Escape' && document.activeElement === input && input.value) {
            input.value = '';
            form.requestSubmit();
        }
    });

    /* ---- Categorías: centrar la activa y flechas ---- */
    const active = scroller.querySelector('[data-active="true"]');
    if (active) {
        const left = active.offsetLeft - (scroller.clientWidth - active.offsetWidth) / 2;
        scroller.scrollTo({ left: Math.max(0, left), behavior: 'auto' });
    }

    function updateEdges() {
        const max = scroller.scrollWidth - scroller.clientWidth;
        const x = scroller.scrollLeft;
        const canPrev = x > 4, canNext = x < max - 4;
        scroller.style.setProperty('--fade-l', canPrev ? '32px' : '0px');
        scroller.style.setProperty('--fade-r', canNext ? '32px' : '0px');
        if (prev) { prev.style.opacity = canPrev ? '1' : '0'; prev.style.pointerEvents = canPrev ? 'auto' : 'none'; }
        if (next) { next.style.opacity = canNext ? '1' : '0'; next.style.pointerEvents = canNext ? 'auto' : 'none'; }
    }
    scroller.addEventListener('scroll', updateEdges, { passive: true });
    window.addEventListener('resize', updateEdges);
    updateEdges();

    const step = () => Math.max(160, scroller.clientWidth * 0.6);
    if (prev) prev.addEventListener('click', () => scroller.scrollBy({ left: -step() }));
    if (next) next.addEventListener('click', () => scroller.scrollBy({ left: step() }));

    // Rueda del ratón vertical -> scroll horizontal sobre las categorías
    scroller.addEventListener('wheel', (e) => {
        if (Math.abs(e.deltaY) > Math.abs(e.deltaX) && scroller.scrollWidth > scroller.clientWidth) {
            e.preventDefault();
            scroller.scrollLeft += e.deltaY;
        }
    }, { passive: false });

    /* ---- Estado de carga al hacer clic en filtros, chips y paginación ---- */
    document.addEventListener('click', (e) => {
        const a = e.target.closest('a.foro-chip, a.foro-tag, nav[role="navigation"] a');
        if (a && !e.metaKey && !e.ctrlKey && !e.shiftKey && a.target !== '_blank') startLoading();
    });
})();
</script>
@endsection