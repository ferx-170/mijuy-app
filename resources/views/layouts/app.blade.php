<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MIJUY - Alimentación Inteligente</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logosin_sin.png') }}">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap 5 (solo para modales) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ============================================================
           PALETA MIJUY v2
           ============================================================ */
        :root {
            --mijuy-green: #22c55e;
            --mijuy-green-dark: #16a34a;
            --mijuy-orange: #f97316;
            --mijuy-orange-dark: #ea580c;
            --mijuy-cream: #fef9f3;
            --mijuy-dark: #0f172a;
        }

        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }

        /* ===== ANIMACIONES ===== */
        @keyframes fadeSlideIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(120%); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideOutRight {
            from { opacity: 1; transform: translateX(0); }
            to { opacity: 0; transform: translateX(120%); }
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.2); }
        }

        .page-enter { animation: fadeSlideIn 0.4s ease forwards; }
        .animate-slide-down { animation: slideDown 0.25s ease forwards; }

        /* ===== NAVBAR ===== */
        .navbar-mijuy {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }
        .navbar-mijuy.scrolled {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .nav-link-item {
            position: relative;
            padding: 0.55rem 1.1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
            transition: all 0.25s ease;
        }
        .nav-link-item:hover {
            color: var(--mijuy-green-dark);
            background-color: rgba(34, 197, 94, 0.08);
        }
        .nav-link-item.active {
            color: white;
            background-color: var(--mijuy-dark);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }
        .nav-link-item.active:hover {
            color: white;
            background-color: var(--mijuy-dark);
        }

        .nav-link-item:not(.active)::after {
            content: '';
            position: absolute;
            bottom: 0.35rem;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--mijuy-green);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        .nav-link-item:not(.active):hover::after {
            width: 40%;
        }

        /* ===== LOGO ===== */
        .logo-img {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .logo-wrapper:hover .logo-img {
            transform: rotate(-8deg) scale(1.1);
        }

        /* ===== BOTONES ===== */
        .btn-mijuy-primary {
            background-color: var(--mijuy-green);
            color: white;
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-mijuy-primary:hover {
            background-color: var(--mijuy-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.4);
        }

        .btn-mijuy-outline {
            background: white;
            color: var(--mijuy-dark);
            border: 1.5px solid #e5e7eb;
            padding: 0.55rem 1.3rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-mijuy-outline:hover {
            border-color: var(--mijuy-green);
            color: var(--mijuy-green-dark);
            transform: translateY(-2px);
        }

        /* ===== AVATAR USUARIO ===== */
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--mijuy-green) 0%, var(--mijuy-green-dark) 100%);
            box-shadow: 0 2px 8px rgba(34, 197, 94, 0.35);
        }

        /* ===== MENÚ USUARIO DROPDOWN ===== */
        .user-menu {
            animation: slideDown 0.25s ease forwards;
            transform-origin: top right;
        }
        .user-menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
            color: #374151;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            margin: 0 0.25rem;
        }
        .user-menu-item:hover {
            background-color: #f3f4f6;
            color: var(--mijuy-green-dark);
        }
        .user-menu-item:hover i {
            color: var(--mijuy-green-dark);
        }

        /* ===== TOASTS ===== */
        #toastContainer {
            position: fixed;
            top: 90px;
            right: 1rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            pointer-events: none;
        }
        .toast-item {
            pointer-events: auto;
            min-width: 320px;
            max-width: 420px;
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            animation: slideInRight 0.4s ease forwards;
            backdrop-filter: blur(10px);
        }

        /* ===== FOOTER LINKS ===== */
        .footer-link {
            color: #6b7280;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            position: relative;
        }
        .footer-link:hover {
            color: var(--mijuy-green-dark);
            padding-left: 6px;
        }

        .social-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #6b7280;
            transition: all 0.3s ease;
        }
        .social-icon:hover {
            transform: translateY(-3px);
        }
        .social-icon.insta:hover { background: linear-gradient(135deg, #f97316, #ec4899); color: white; }
        .social-icon.fb:hover    { background: #1877f2; color: white; }
        .social-icon.yt:hover    { background: #ff0000; color: white; }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f9fafb; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--mijuy-green); }

        /* ===== OVERRIDE BOOTSTRAP ===== */
        .modal-content { border: none; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .nav-link-item {
                display: block;
                width: 100%;
                text-align: center;
                padding: 0.75rem 1rem;
            }
            #toastContainer { left: 1rem; right: 1rem; }
            .toast-item { min-width: auto; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-white text-gray-800">

    <!-- ============================================================
         NAVBAR
         ============================================================ -->
        <!-- ============================================================
         NAVBAR
         ============================================================ -->
    <nav id="mainNavbar" class="navbar-mijuy sticky top-0 z-40">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-20">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo-wrapper flex items-center gap-2 group">
                    <img src="{{ asset('img/logosin_sin.png') }}" alt="MIJUY" class="logo-img h-9 w-auto">
                    <span class="text-xl font-bold text-gray-900">MI<span class="text-green-600">JUY</span></span>
                </a>

                <!-- Menú desktop -->
                <div class="hidden md:flex items-center gap-1">

                    <!-- Links principales -->
                    <a href="{{ route('home') }}" class="nav-link-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-home mr-1.5"></i> Inicio
                    </a>
                    <a href="{{ route('scan') }}" class="nav-link-item {{ request()->routeIs('scan') ? 'active' : '' }}">
                        <i class="fas fa-camera mr-1.5"></i> Escanear
                    </a>
                    <a href="{{ route('forum.index') }}" class="nav-link-item {{ request()->routeIs('forum.*') ? 'active' : '' }}">
                        <i class="fas fa-users mr-1.5"></i> Foro
                    </a>
                    
                    <!-- NUEVO: Enlace a Planes (Público) -->
                    <a href="{{ route('planes.index') }}" class="nav-link-item {{ request()->routeIs('planes.*') ? 'active' : '' }}">
                        <i class="fas fa-crown mr-1.5 text-amber-500"></i> Planes
                    </a>

                    @auth
                        <a href="{{ route('my.history') }}" class="nav-link-item {{ request()->routeIs('my.history') ? 'active' : '' }}">
                            <i class="fas fa-history mr-1.5"></i> Mi Historial
                        </a>
                        <a href="{{ route('favorites.index') }}" class="nav-link-item {{ request()->routeIs('favorites.*') ? 'active' : '' }}">
                            <i class="fas fa-heart mr-1.5"></i> Favoritos
                        </a>
                    @endauth

                    <!-- Separador vertical -->
                    <div class="w-px h-6 bg-gray-200 mx-2"></div>

                    <!-- Botón usuario / login -->
                    @auth
                        <div class="relative">
                            <button id="userMenuBtn" class="flex items-center gap-2 bg-gray-50 hover:bg-gray-100 px-2 py-1.5 pr-3 rounded-full transition-all duration-300 border border-gray-100 hover:border-green-200">
                                <div class="user-avatar overflow-hidden">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ auth()->user()->avatar }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
                                    @endif
                                </div>
                                <span class="text-sm font-semibold text-gray-700 max-w-[100px] truncate">
                                    {{ auth()->user()->nombre }}
                                </span>
                                <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-300" id="userMenuChevron"></i>
                            </button>

                            <!-- Dropdown -->
                            <div id="userMenu" class="user-menu hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                                <!-- Header del menú -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-bold text-gray-800 truncate">{{ auth()->user()->nombre }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <div class="py-1">
                                    <a href="{{ route('my.history') }}" class="user-menu-item">
                                        <i class="fas fa-history w-4 text-center text-gray-400"></i>
                                        <span>Mi Historial</span>
                                    </a>
                                    <a href="{{ route('favorites.index') }}" class="user-menu-item">
                                        <i class="fas fa-heart w-4 text-center text-gray-400"></i>
                                        <span>Favoritos</span>
                                    </a>
                                    
                                    <!-- NUEVO: Enlace a Mi Suscripción -->
                                    <a href="{{ route('planes.index') }}" class="user-menu-item font-semibold text-amber-600">
                                        <i class="fas fa-crown w-4 text-center text-amber-500"></i>
                                        <span>Mi Suscripción</span>
                                    </a>

                                    <button type="button" data-bs-toggle="modal" data-bs-target="#profileModal" class="user-menu-item w-full text-left">
                                        <i class="fas fa-user w-4 text-center text-gray-400"></i>
                                        <span>Mi Perfil</span>
                                    </button>
                                </div>

                                <div class="border-t border-gray-100 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="user-menu-item w-full text-left text-red-600 hover:bg-red-50 hover:text-red-700">
                                            <i class="fas fa-sign-out-alt w-4 text-center"></i>
                                            <span>Cerrar sesión</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <button type="button" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn-mijuy-primary">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Iniciar Sesión</span>
                        </button>
                    @endauth
                </div>

                <!-- Botón menú móvil -->
                <div class="md:hidden flex items-center">
                    <button id="menu-toggle" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-600 hover:text-green-600 hover:bg-green-50 transition-all duration-300">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Menú móvil desplegable -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-1 animate-slide-down">
                <a href="{{ route('home') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('home') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition-all duration-200 font-medium">
                    <i class="fas fa-home w-5 text-center"></i> Inicio
                </a>
                <a href="{{ route('scan') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('scan') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition-all duration-200 font-medium">
                    <i class="fas fa-camera w-5 text-center"></i> Escanear
                </a>
                <a href="{{ route('forum.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('forum.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition-all duration-200 font-medium">
                    <i class="fas fa-users w-5 text-center"></i> Foro
                </a>
                
                <!-- NUEVO: Planes en Móvil -->
                <a href="{{ route('planes.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('planes.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition-all duration-200 font-medium">
                    <i class="fas fa-crown w-5 text-center text-amber-500"></i> Planes
                </a>

                @auth
                    <div class="border-t border-gray-100 my-2 pt-2">
                        <div class="flex items-center gap-3 px-4 py-3">
                            <div class="user-avatar overflow-hidden">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ auth()->user()->nombre }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('my.history') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('my.history') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition-all duration-200 font-medium">
                        <i class="fas fa-history w-5 text-center"></i> Mi Historial
                    </a>
                    <a href="{{ route('favorites.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('favorites.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition-all duration-200 font-medium">
                        <i class="fas fa-heart w-5 text-center"></i> Favoritos
                    </a>
                    
                    <!-- NUEVO: Mi Suscripción en Móvil -->
                    <a href="{{ route('planes.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-amber-600 font-semibold hover:bg-amber-50 transition-all duration-200">
                        <i class="fas fa-crown w-5 text-center"></i> Mi Suscripción
                    </a>

                    <button type="button" data-bs-toggle="modal" data-bs-target="#profileModal" class="w-full flex items-center gap-3 py-3 px-4 rounded-xl text-gray-600 hover:bg-gray-100 transition-all duration-200 font-medium text-left">
                        <i class="fas fa-user w-5 text-center"></i> Mi Perfil
                    </button>

                    <form method="POST" action="{{ route('logout') }}" class="pt-1">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 py-3 px-4 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-200 font-medium">
                            <i class="fas fa-sign-out-alt w-5 text-center"></i> Cerrar sesión
                        </button>
                    </form>
                @else
                    <div class="pt-3">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn-mijuy-primary w-full justify-center py-3">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Iniciar Sesión</span>
                        </button>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ============================================================
         CONTENIDO PRINCIPAL
         ============================================================ -->
    <main class="page-enter">
        @yield('content')
    </main>

    <!-- ============================================================
         FOOTER
         ============================================================ -->
    <footer class="bg-white border-t border-gray-100 mt-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

                <!-- Columna 1: Logo + descripción -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('img/logosin_sin.png') }}" alt="MIJUY" class="h-8 w-auto">
                        <span class="text-xl font-bold text-gray-900">
                            MI<span class="text-green-600">JUY</span>
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm max-w-xs leading-relaxed">
                        Empoderando tu bienestar a través de la inteligencia alimentaria.
                    </p>
                    <div class="flex gap-3 mt-5">
                        <a href="#" class="social-icon insta" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon fb" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon yt" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Columna 2: Producto -->
                <div>
                    <h6 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">Producto</h6>
                    <ul class="space-y-3">
                        <li><a href="{{ route('scan') }}" class="footer-link">Análisis</a></li>
                        <li><a href="{{ route('forum.index') }}" class="footer-link">Foro</a></li>
                        <li><a href="{{ route('favorites.index') }}" class="footer-link">Favoritos</a></li>
                    </ul>
                </div>

                <!-- Columna 3: Compañía -->
                <div>
                    <h6 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">Compañía</h6>
                    <ul class="space-y-3">
                        <li><a href="#" class="footer-link">Sobre nosotros</a></li>
                        <li><a href="#" class="footer-link">Blog</a></li>
                        <li><a href="#" class="footer-link">Carreras</a></li>
                    </ul>
                </div>

                <!-- Columna 4: Soporte -->
                <div>
                    <h6 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">Soporte</h6>
                    <ul class="space-y-3">
                        <li><a href="#" class="footer-link">Centro de ayuda</a></li>
                        <li><a href="#" class="footer-link">Contacto</a></li>
                        <li><a href="#" class="footer-link">Privacidad</a></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-100 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-sm text-gray-400">
                    © 2026 MIJUY · Instituto Tupac Amaru de Cusco
                </p>
                <p class="text-sm text-gray-400">
                    Hecho con <i class="fas fa-heart text-red-400 mx-1"></i> para tu bienestar
                </p>
            </div>
        </div>
    </footer>
    
    <!-- ============================================================
         TOASTS
         ============================================================ -->
    <div id="toastContainer"></div>

    <!-- ============================================================
         MODALES
         ============================================================ -->
    @guest
        @include('components.login-modal')
        @include('components.register-modal')
    @endguest

    @auth
        @if(session('just_logged_in'))
            @include('components.welcome-modal')
        @endif

        <!-- Modal de Perfil -->
        @include('components.profile-modal')
        @include('components.public-profile-modal')
    @endauth

    <!-- ============================================================
         BOOTSTRAP JS
         ============================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ============================================================
         SCRIPTS GLOBALES
         ============================================================ -->
    <script>
        // ============ TOASTS ============
        window.showToast = function(message, type = 'success', duration = 4000) {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const configs = {
                success: { bg: 'linear-gradient(135deg, #22c55e, #16a34a)', icon: 'fa-check-circle' },
                error:   { bg: 'linear-gradient(135deg, #ef4444, #dc2626)', icon: 'fa-exclamation-circle' },
                info:    { bg: 'linear-gradient(135deg, #3b82f6, #2563eb)', icon: 'fa-info-circle' },
                warning: { bg: 'linear-gradient(135deg, #f97316, #ea580c)', icon: 'fa-exclamation-triangle' },
            };

            const cfg = configs[type] || configs.success;

            const toast = document.createElement('div');
            toast.className = 'toast-item';
            toast.style.background = cfg.bg;
            toast.innerHTML = `
                <i class="fas ${cfg.icon} text-lg"></i>
                <div class="flex-grow-1 text-sm font-medium">${message}</div>
                <button onclick="this.parentElement.remove()" class="btn-close btn-close-white btn-sm ms-2"></button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.4s ease forwards';
                setTimeout(() => toast.remove(), 400);
            }, duration);
        };

        // ============ NAVBAR SCROLL EFFECT ============
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (navbar) {
                if (window.scrollY > 10) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });

        // ============ INICIALIZACIÓN ============
        document.addEventListener('DOMContentLoaded', function() {

            // Mostrar toasts desde session flash
            @if(session('success'))
                showToast(@json(session('success')), 'success');
            @endif
            @if(session('error'))
                showToast(@json(session('error')), 'error');
            @endif
            @if(session('info'))
                showToast(@json(session('info')), 'info');
            @endif

            // Abrir modal login si viene de ruta protegida
            @if(session('open_login_modal'))
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            @endif

            // Abrir modal login si hay errores de validación
            @if($errors->any() && !auth()->check())
                const loginModalErr = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModalErr.show();
            @endif

            // Modal de bienvenida post-login
            @if(session('just_logged_in'))
                setTimeout(function() {
                    const welcomeModalEl = document.getElementById('welcomeBackModal');
                    if (welcomeModalEl) {
                        const welcomeModal = new bootstrap.Modal(welcomeModalEl);
                        welcomeModal.show();
                    }
                }, 600);
            @endif

            // Toggle menú móvil
            document.getElementById('menu-toggle')?.addEventListener('click', function() {
                document.getElementById('mobile-menu').classList.toggle('hidden');
            });

            // Cerrar menú móvil al hacer clic en un enlace
            document.querySelectorAll('#mobile-menu a').forEach(link => {
                link.addEventListener('click', function() {
                    document.getElementById('mobile-menu').classList.add('hidden');
                });
            });

            // Toggle menú de usuario
            document.getElementById('userMenuBtn')?.addEventListener('click', function(e) {
                e.stopPropagation();
                const menu = document.getElementById('userMenu');
                const chevron = document.getElementById('userMenuChevron');
                if (menu) {
                    menu.classList.toggle('hidden');
                    if (chevron) {
                        chevron.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                    }
                }
            });

            // Cerrar menú usuario al hacer clic fuera
            document.addEventListener('click', function(e) {
                const menu = document.getElementById('userMenu');
                const btn = document.getElementById('userMenuBtn');
                if (menu && btn && !menu.classList.contains('hidden') && !btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                    const chevron = document.getElementById('userMenuChevron');
                    if (chevron) chevron.style.transform = 'rotate(0deg)';
                }
            });
        });
                // ============ ABRIR MODAL DE AUTOR (PERFIL PÚBLICO) ============
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

    @stack('scripts')
</body>
</html>