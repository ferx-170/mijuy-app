@extends('layouts.app')

@section('content')

<!-- ============================================================
     HERO SECTION — Estilo Foody limpio
     ============================================================ -->
<section class="relative overflow-hidden" style="background: linear-gradient(180deg, #fef9f3 0%, #ffffff 100%);">
    <!-- Blobs decorativos suaves -->
    <div class="absolute top-20 -left-20 w-72 h-72 rounded-full opacity-30 blur-3xl" style="background: #bbf7d0;"></div>
    <div class="absolute top-40 right-0 w-80 h-80 rounded-full opacity-20 blur-3xl" style="background: #fed7aa;"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">
        <div class="flex flex-col lg:flex-row items-center gap-12">

            <!-- Columna izquierda -->
            <div class="lg:w-1/2 space-y-6 animate-fade-in-up">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm border border-green-100">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-xs font-semibold text-green-700">Nutrición con Inteligencia Artificial</span>
                </div>

                <!-- Título -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-gray-900">
                    Comer sano es
                    <span class="block text-green-600">parte de tu estilo de vida</span>
                </h1>

                <p class="text-lg text-gray-600 max-w-lg leading-relaxed">
                    Preparamos análisis nutricionales deliciosos y personalizados para ti. Descubre, cocina y comparte con MIJUY.
                </p>

                <!-- CTAs -->
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('scan') }}"
                       class="group inline-flex items-center gap-2 px-7 py-3.5 rounded-full text-white font-semibold bg-green-600 hover:bg-green-700 transition-all duration-300 shadow-lg shadow-green-200 hover:shadow-xl hover:-translate-y-1">
                        <i class="fas fa-camera group-hover:scale-110 transition-transform"></i>
                        <span>Comenzar Análisis</span>
                    </a>

                    <a href="#como-funciona"
                       class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full font-semibold border-2 border-gray-200 text-gray-700 hover:border-green-600 hover:text-green-600 transition-all duration-300">
                        <i class="fas fa-play-circle"></i>
                        <span>Ver Demo</span>
                    </a>
                </div>

                <!-- Social proof -->
                <div class="flex items-center gap-4 pt-6">
                    <div class="flex -space-x-3">
                        <img src="https://i.pravatar.cc/100?img=1" class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="">
                        <img src="https://i.pravatar.cc/100?img=5" class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="">
                        <img src="https://i.pravatar.cc/100?img=8" class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="">
                        <div class="w-10 h-10 rounded-full border-2 border-white shadow-sm bg-green-600 flex items-center justify-center text-xs font-bold text-white">
                            +2k
                        </div>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-900">Unete a nosotros</p>
                        <p class="text-sm text-gray-500">confían en MIJUY</p>
                    </div>
                </div>
            </div>

            <!-- Columna derecha: Imagen principal -->
            <div class="lg:w-1/2 relative animate-fade-in-right">
                <div class="relative">
                    <!-- Círculo decorativo de fondo -->
                    <div class="absolute inset-0 rounded-full opacity-40 blur-3xl scale-90" style="background: radial-gradient(circle, #86efac, transparent);"></div>

                    <!-- Imagen principal redonda -->
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=700&h=700&fit=crop&crop=center"
                         alt="Plato saludable"
                         class="relative w-full max-w-lg mx-auto rounded-full shadow-2xl object-cover aspect-square border-8 border-white">

                    <!-- Badge oferta -->
                    <div class="absolute top-4 right-8 w-20 h-20 rounded-full bg-orange-400 text-white flex items-center justify-center text-center font-bold text-xs shadow-lg rotate-12">
                        <span>20%<br>OFF</span>
                    </div>

                    <!-- Card flotante: Fast Delivery style -->
                    <div class="absolute top-1/4 -left-4 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3 animate-float">
                        <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center">
                            <i class="fas fa-bolt text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Análisis Rápido</p>
                            <p class="text-xs text-gray-500">En 3 segundos</p>
                        </div>
                    </div>

                    <!-- Card flotante: Pick Up style -->
                    <div class="absolute bottom-1/4 -right-4 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3" style="animation: float 4s ease-in-out infinite 1s;">
                        <div class="w-11 h-11 rounded-xl bg-orange-100 flex items-center justify-center">
                            <i class="fas fa-heart text-orange-500"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Meta Saludable</p>
                            <p class="text-xs text-gray-500">85% Completada</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     RECETAS DESTACADAS — Estilo Foody cards
     ============================================================ -->
<section class="py-16 bg-white relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-green-600">Explora</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-1">
                    Platos <span class="text-orange-500">Populares</span>
                </h2>
                <p class="text-gray-500 mt-2">Descubre recetas saludables compartidas por nuestra comunidad.</p>
            </div>
            <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold transition">
                Ver todo <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Cards de recetas: los 4 platos más populares (likes → vistas) -->
        @php
            // Paletas de color (clases completas para que Tailwind las detecte)
            $paletas = [
                ['card' => 'from-pink-100',   'badge' => 'bg-pink-200 text-pink-700'],
                ['card' => 'from-orange-100', 'badge' => 'bg-orange-200 text-orange-700'],
                ['card' => 'from-green-100',  'badge' => 'bg-green-200 text-green-700'],
                ['card' => 'from-purple-100', 'badge' => 'bg-purple-200 text-purple-700'],
            ];
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-16 mt-16">

            @foreach ($recetasPopulares as $i => $plato)
                @php $color = $paletas[$i % count($paletas)]; @endphp

                <div class="group relative flex flex-col items-center h-full bg-gradient-to-b {{ $color['card'] }} to-white rounded-3xl px-5 pb-6 pt-0 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <img src="{{ $plato['imagen'] }}"
                         alt="{{ $plato['nombre'] }}"
                         loading="lazy"
                         class="-mt-12 mb-4 shrink-0 w-32 h-32 rounded-full object-cover shadow-lg border-4 border-white group-hover:scale-110 transition-transform duration-500">
                    <h3 class="w-full font-bold text-gray-800 text-lg leading-snug mb-1">{{ $plato['nombre'] }}</h3>
                    <p class="text-xs text-gray-500 mb-3">{{ $plato['descripcion'] }}</p>
                    <div class="flex items-center justify-center gap-3 mb-4">
                        @if (!empty($plato['kcal']))
                            <span class="text-lg font-bold text-gray-900">{{ $plato['kcal'] }}</span>
                        @endif
                        <span class="text-xs px-2 py-1 rounded-full {{ $color['badge'] }} font-semibold">{{ $plato['categoria'] }}</span>
                    </div>
                    <a href="{{ $plato['url'] }}" class="mt-auto inline-block bg-white text-gray-700 px-5 py-2 rounded-full text-sm font-semibold shadow-sm hover:bg-gray-900 hover:text-white transition-all">
                        Ver Receta <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</section>

<!-- ============================================================
     CATEGORÍAS — Grid limpio
     ============================================================ -->
<section class="py-16" style="background: #fef9f3;">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-orange-500">Categorías</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-1">
                Encuentra tu <span class="text-green-600">plato ideal</span>
            </h2>
            <p class="text-gray-500 mt-3">Filtra por lo que necesitas según tu objetivo nutricional.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <!-- Categoría 1 -->
            <a href="{{ route('forum.index') }}" class="group bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-green-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-bowl-food text-green-600 text-xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 text-sm">Comidas Simples</h4>
                <p class="text-xs text-gray-500 mt-1">Rápidas y fáciles</p>
            </a>

            <!-- Categoría 2 -->
            <a href="{{ route('forum.index') }}" class="group bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-orange-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-dumbbell text-orange-500 text-xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 text-sm">Altas en Proteína</h4>
                <p class="text-xs text-gray-500 mt-1">Para tu masa muscular</p>
            </a>

            <!-- Categoría 3 -->
            <a href="{{ route('forum.index') }}" class="group bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-pink-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-leaf text-pink-500 text-xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 text-sm">Bajas en Calorías</h4>
                <p class="text-xs text-gray-500 mt-1">Para bajar de peso</p>
            </a>

            <!-- Categoría 4 -->
            <a href="{{ route('forum.index') }}" class="group bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-purple-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-ice-cream text-purple-500 text-xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 text-sm">Postres Saludables</h4>
                <p class="text-xs text-gray-500 mt-1">Sin culpa</p>
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     CÓMO FUNCIONA — 3 pasos limpios
     ============================================================ -->
<section id="como-funciona" class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-green-600">Proceso Simple</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-1">
                Cómo funciona <span class="text-orange-500">MIJUY</span>
            </h2>
            <p class="text-gray-500 mt-3">Tres pasos para transformar tu alimentación.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Paso 1 -->
            <div class="group relative bg-white rounded-3xl p-8 text-center shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 border border-gray-100">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-green-100 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                    <i class="fas fa-camera text-green-600 text-2xl"></i>
                </div>
                <div class="absolute top-6 right-6 w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-bold">1</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Captura tu Plato</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Toma una foto de tu comida. Nuestra IA identifica los ingredientes al instante.</p>
            </div>

            <!-- Paso 2 -->
            <div class="group relative bg-white rounded-3xl p-8 text-center shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 border border-gray-100">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-orange-100 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                    <i class="fas fa-bolt text-orange-500 text-2xl"></i>
                </div>
                <div class="absolute top-6 right-6 w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-bold">2</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Obtén el Análisis</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Visualiza macros, calorías y calidad nutricional con datos precisos.</p>
            </div>

            <!-- Paso 3 -->
            <div class="group relative bg-white rounded-3xl p-8 text-center shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 border border-gray-100">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-purple-100 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                    <i class="fas fa-list-ul text-purple-500 text-2xl"></i>
                </div>
                <div class="absolute top-6 right-6 w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-bold">3</div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Recibe Sugerencias</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Descubre recetas alternativas y comparte las tuyas con la comunidad.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     CTA FINAL — Limpio sin gradientes brutales
     ============================================================ -->
<section class="py-16 md:py-24" style="background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl p-8 md:p-12 text-center relative overflow-hidden">
            <!-- Decoración suave -->
            <div class="absolute top-0 right-0 w-48 h-48 rounded-full bg-orange-100 opacity-40 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full bg-green-100 opacity-40 blur-3xl"></div>

            <div class="relative">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-green-100 mb-6">
                    <i class="fas fa-rocket text-green-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    ¿Listo para transformar tu alimentación?
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto mb-8">
                    Únete a los miles de usuarios que ya están tomando decisiones más inteligentes sobre su comida.
                </p>
                <a href="{{ route('scan') }}"
                   class="inline-flex items-center gap-3 bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg shadow-green-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <i class="fas fa-camera"></i>
                    <span>Comenzar Ahora Gratis</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     ESTILOS DE ANIMACIÓN
     ============================================================ -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .animate-fade-in-up { animation: fadeInUp 0.8s ease forwards; opacity: 0; }
    .animate-fade-in-right { animation: fadeInRight 0.8s ease forwards; opacity: 0; }
    .animate-float { animation: float 4s ease-in-out infinite; }

    html { scroll-behavior: smooth; }
</style>

@endsection
