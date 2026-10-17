@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8" style="background: linear-gradient(180deg, #fef9f3 0%, #ffffff 100%);">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto">

            <!-- ============================================================
                 HEADER
                 ============================================================ -->
            <div class="mb-8 text-center animate-fade-in-up">
                <span class="inline-flex items-center gap-2 bg-white text-green-700 text-xs font-semibold px-4 py-2 rounded-full mb-3 shadow-sm border border-green-100">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Escáner Nutricional
                </span>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                    Captura tu <span class="text-green-600">Plato</span>
                </h1>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto">
                    Toma una foto o sube una imagen para analizar sus nutrientes y obtener una receta saludable.
                </p>
            </div>

            <!-- ============================================================
                 MENSAJES DE ERROR
                 ============================================================ -->
            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl d-flex align-items-start gap-3 animate-fade-in-up"
                     style="background: #fef2f2; border: 1px solid #fecaca;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span class="small" style="color: #b91c1c;">{{ session('error') }}</span>
                </div>
            @endif

            <!-- ============================================================
                 TARJETA PRINCIPAL DE CAPTURA
                 ============================================================ -->
            <div class="bg-white rounded-3xl shadow-lg p-6 md:p-8 border-2 border-dashed border-gray-200 hover:border-green-300 transition-all duration-300 animate-fade-in-up"
                 style="animation-delay: 0.1s;">

                <!-- ============ ESTADO: CAPTURA ============ -->
                <div id="captureState">

                    <!-- Icono + descripción -->
                    <div class="text-center py-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl mb-5"
                             style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); box-shadow: 0 8px 24px rgba(34, 197, 94, 0.15);">
                            <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                <circle cx="12" cy="13" r="3"></circle>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Captura o sube tu plato</h3>
                        <p class="text-gray-500 max-w-md mx-auto text-sm leading-relaxed">
                            Sube una foto clara de tu comida para obtener un análisis nutricional completo.
                        </p>
                    </div>

                    <!-- Botones principales -->
                    <form id="uploadForm" method="POST" action="{{ route('analyze') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="image" id="imageInput">

                        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-4">

                            <!-- Botón Seleccionar Archivo -->
                            <label id="fileLabel"
                                   class="cursor-pointer inline-flex items-center justify-center gap-2 bg-gray-50 hover:bg-gray-100 text-gray-700 px-6 py-3.5 rounded-full font-semibold transition-all duration-300 border-2 border-gray-200 hover:border-green-300 w-full sm:w-auto hover:-translate-y-0.5">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                <span>Seleccionar Archivo</span>
                                <input type="file" id="fileInput" accept="image/*" class="hidden" onchange="handleFile(this)">
                            </label>

                            <!-- Botón Tomar Foto -->
                            <button type="button" id="cameraBtn"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-full font-semibold text-white transition-all duration-300 w-full sm:w-auto hover:-translate-y-0.5"
                                    style="background: #22c55e; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);"
                                    onmouseover="this.style.background='#16a34a'; this.style.boxShadow='0 8px 20px rgba(34, 197, 94, 0.4)';"
                                    onmouseout="this.style.background='#22c55e'; this.style.boxShadow='0 4px 14px rgba(34, 197, 94, 0.3)';">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                    <circle cx="12" cy="13" r="3"></circle>
                                </svg>
                                <span>Tomar Foto</span>
                            </button>
                        </div>
                    </form>

                    <!-- Vista previa de la cámara -->
                    <div id="cameraPreview" class="mt-5 hidden">
                        <div class="rounded-2xl overflow-hidden shadow-lg bg-black">
                            <video id="video" autoplay muted playsinline class="w-full max-h-80 object-cover"></video>
                        </div>
                        <canvas id="canvas" class="hidden"></canvas>
                        <div class="mt-4 flex flex-col sm:flex-row justify-center gap-3">
                            <button id="captureBtn"
                                    class="inline-flex items-center justify-center gap-2 text-white px-6 py-3 rounded-full font-semibold transition-all hover:-translate-y-0.5"
                                    style="background: #22c55e; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <span>Capturar</span>
                            </button>
                            <button id="closeCameraBtn"
                                    class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-semibold transition-all hover:-translate-y-0.5">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                <span>Cancelar</span>
                            </button>
                        </div>
                    </div>

                    <!-- Botón Analizar -->
                    <div class="mt-6 text-center">
                        <button id="analyzeBtn" type="submit" form="uploadForm"
                                class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full font-bold text-white transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed w-full sm:w-auto"
                                style="background: #22c55e; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);"
                                onmouseover="if(!this.disabled) { this.style.background='#16a34a'; this.style.transform='translateY(-2px)'; }"
                                onmouseout="this.style.background='#22c55e'; this.style.transform='translateY(0)';"
                                disabled>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                            <span>Analizar Plato</span>
                        </button>
                    </div>
                </div>

                <!-- ============ ESTADO: LOADING ============ -->
                <div id="loadingState" class="hidden text-center py-12">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-5"
                         style="background: #f0fdf4;">
                        <div class="w-12 h-12 border-4 border-green-200 border-t-green-600 rounded-full animate-spin"></div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Analizando tu plato...</h3>
                    <p class="text-gray-500 text-sm">Esto puede tomar unos segundos</p>
                </div>

            </div>

            <!-- ============================================================
                 CONSEJOS
                 ============================================================ -->
            <div class="mt-8 rounded-2xl p-6 animate-fade-in-up"
                 style="background: #fff7ed; border: 1px solid #ffedd5; animation-delay: 0.2s;">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0"
                         style="background: white; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.15);">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 18h6"></path>
                            <path d="M10 22h4"></path>
                            <path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"></path>
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800 mb-1">Consejos para mejores resultados</h5>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Asegúrate de que el plato esté <strong>bien iluminado</strong>, los ingredientes sean <strong>visibles</strong> y la foto sea <strong>nítida</strong>.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: USUARIO NO LOGUEADO
     ============================================================ -->
@guest
<div id="guestModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300" style="display: none; backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">

        <!-- Header -->
        <div class="relative p-6 pb-4 text-center" style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">

            <!-- Botón cerrar -->
            <button type="button" id="closeGuestModal"
                    class="absolute top-4 right-4 w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <!-- Icono -->
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-3xl mb-3"
                 style="background: white; box-shadow: 0 8px 24px rgba(34, 197, 94, 0.15);">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-1">
                Inicia sesión para <span style="color: #16a34a;">guardar recetas</span>
            </h3>
            <p class="text-sm text-gray-500 mb-0">
                Necesitas una cuenta para analizar y guardar tus platos en tu historial personal.
            </p>
        </div>

        <!-- Body: beneficios -->
        <div class="px-6 pb-4">
            <ul class="space-y-3">
                <li class="flex items-center gap-3 text-sm text-gray-600">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0"
                          style="background: #dcfce7;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </span>
                    <span>Historial de todas tus recetas</span>
                </li>
                <li class="flex items-center gap-3 text-sm text-gray-600">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0"
                          style="background: #dcfce7;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </span>
                    <span>Guarda tus favoritas</span>
                </li>
                <li class="flex items-center gap-3 text-sm text-gray-600">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0"
                          style="background: #dcfce7;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </span>
                    <span>Comparte con la comunidad</span>
                </li>
            </ul>
        </div>

        <!-- Footer: acciones -->
        <div class="px-6 pb-6 pt-2 flex flex-col sm:flex-row gap-3">
            <button type="button" id="closeGuestModalBtn"
                    class="flex-1 py-3 rounded-full font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-all">
                Más tarde
            </button>
            <button type="button" id="openLoginFromScan"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 rounded-full font-semibold text-white transition-all hover:-translate-y-0.5"
                    style="background: #22c55e; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                    <polyline points="10 17 15 12 10 7"></polyline>
                    <line x1="15" y1="12" x2="3" y2="12"></line>
                </svg>
                <span>Iniciar Sesión</span>
            </button>
        </div>
    </div>
</div>
@endguest

<!-- ============================================================
     ESTILOS DE ANIMACIÓN
     ============================================================ -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease forwards; opacity: 0; }

    @keyframes modalPop {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    #guestModal > div { animation: modalPop 0.3s ease; }
</style>

@push('scripts')
<script>
    // ============================================================
    // ELEMENTOS DOM
    // ============================================================
    const fileInput = document.getElementById('fileInput');
    const cameraBtn = document.getElementById('cameraBtn');
    const cameraPreview = document.getElementById('cameraPreview');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('captureBtn');
    const closeCameraBtn = document.getElementById('closeCameraBtn');
    const analyzeBtn = document.getElementById('analyzeBtn');
    const imageInput = document.getElementById('imageInput');
    const loadingState = document.getElementById('loadingState');
    const captureState = document.getElementById('captureState');
    const uploadForm = document.getElementById('uploadForm');
    const fileLabel = document.getElementById('fileLabel');

    let capturedImage = null;
    let stream = null;

    // ============================================================
    // VERIFICAR AUTENTICACIÓN AL CARGAR
    // ============================================================
    const isAuthenticated = @json(auth()->check());

    document.addEventListener('DOMContentLoaded', function() {
        if (!isAuthenticated) {
            // Usuario NO logueado → mostrar modal
            const guestModal = document.getElementById('guestModal');
            if (guestModal) {
                setTimeout(() => {
                    guestModal.style.display = 'flex';
                }, 400);
            }
        }
    });

    // ============================================================
    // MODAL DE INVITADO
    // ============================================================
    function closeGuestModal() {
        const modal = document.getElementById('guestModal');
        if (modal) modal.style.display = 'none';
    }

    document.getElementById('closeGuestModal')?.addEventListener('click', closeGuestModal);
    document.getElementById('closeGuestModalBtn')?.addEventListener('click', closeGuestModal);

    // Botón "Iniciar Sesión" del modal → abre el modal de login global
    document.getElementById('openLoginFromScan')?.addEventListener('click', function() {
        closeGuestModal();
        const loginModalEl = document.getElementById('loginModal');
        if (loginModalEl) {
            const loginModal = new bootstrap.Modal(loginModalEl);
            loginModal.show();
        }
    });

    // ============================================================
    // HABILITAR/DESHABILITAR BOTÓN ANALIZAR
    // ============================================================
    function setAnalyzeEnabled(enabled) {
        analyzeBtn.disabled = !enabled;
    }

    // ============================================================
    // MANEJAR ARCHIVO SELECCIONADO
    // ============================================================
    window.handleFile = function(input) {
        // Bloquear si no está logueado
        if (!isAuthenticated) {
            input.value = '';
            const guestModal = document.getElementById('guestModal');
            if (guestModal) guestModal.style.display = 'flex';
            return;
        }

        const file = input.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(event) {
            capturedImage = event.target.result;
            imageInput.value = capturedImage;
            setAnalyzeEnabled(true);

            // Feedback visual
            fileLabel.innerHTML = `
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span>Imagen seleccionada</span>
            `;
            fileLabel.classList.remove('bg-gray-50', 'hover:bg-gray-100', 'border-gray-200', 'text-gray-700');
            fileLabel.classList.add('bg-green-50', 'border-green-300', 'text-green-700');
        };
        reader.readAsDataURL(file);
    };

    // ============================================================
    // CÁMARA
    // ============================================================
    cameraBtn?.addEventListener('click', async function() {
        // Bloquear si no está logueado
        if (!isAuthenticated) {
            const guestModal = document.getElementById('guestModal');
            if (guestModal) guestModal.style.display = 'flex';
            return;
        }

        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment' },
                audio: false
            });
            video.srcObject = stream;
            await video.play();
            cameraPreview.classList.remove('hidden');
            cameraBtn.disabled = true;
        } catch (err) {
            alert('No se pudo acceder a la cámara. Usa la opción de subir archivo.');
            console.error(err);
        }
    });

    captureBtn?.addEventListener('click', function() {
        if (!video.videoWidth) {
            alert('La cámara no está lista.');
            return;
        }
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        capturedImage = canvas.toDataURL('image/jpeg', 0.9);
        imageInput.value = capturedImage;
        setAnalyzeEnabled(true);

        // Detener cámara
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        cameraPreview.classList.add('hidden');
        cameraBtn.disabled = false;

        // Feedback visual
        cameraBtn.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <span>Foto capturada</span>
        `;
    });

    closeCameraBtn?.addEventListener('click', function() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        cameraPreview.classList.add('hidden');
        cameraBtn.disabled = false;
    });

    // ============================================================
    // ENVIAR FORMULARIO
    // ============================================================
    uploadForm?.addEventListener('submit', function(e) {
        if (!isAuthenticated) {
            e.preventDefault();
            const guestModal = document.getElementById('guestModal');
            if (guestModal) guestModal.style.display = 'flex';
            return;
        }

        if (!capturedImage) {
            e.preventDefault();
            showToast('Primero captura o sube una imagen.', 'warning');
            return;
        }

        // Mostrar loading
        captureState.classList.add('hidden');
        loadingState.classList.remove('hidden');
        analyzeBtn.disabled = true;
    });
</script>
@endpush
@endsection