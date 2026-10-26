<!-- ============================================================
     MODAL DE BIENVENIDA POST-LOGIN — Coherencia MIJUY v2
     ============================================================ -->
<div class="modal fade" id="welcomeBackModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden">

            <!-- ============ HEADER ============ -->
            <div class="position-relative p-5 text-center" style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">

                <!-- Decoraciones suaves -->
                <div class="position-absolute rounded-circle" style="width: 120px; height: 120px; background: rgba(34, 197, 94, 0.08); top: -50px; right: -30px;"></div>
                <div class="position-absolute rounded-circle" style="width: 80px; height: 80px; background: rgba(249, 115, 22, 0.06); bottom: -20px; left: 20px;"></div>

                <div class="position-relative">
                    <!-- Icono principal -->
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle"
                         style="width: 72px; height: 72px; background: white; box-shadow: 0 8px 24px rgba(34, 197, 94, 0.15);">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            <path d="M11 7V5a1 1 0 0 1 1-1 1 1 0 0 1 1 1v2"></path>
                            <path d="M17 7V5a1 1 0 0 1 1-1 1 1 0 0 1 1 1v4"></path>
                            <path d="M18 13v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7"></path>
                            <path d="M2 13h20"></path>
                        </svg>
                    </div>

                    <!-- Título -->
                    <h3 class="fw-bold text-gray-900 mb-1" style="font-size: 1.35rem;">
                        ¡Hola de nuevo, <span style="color: #16a34a;">{{ auth()->user()->nombre }}</span>!
                    </h3>
                    <p class="text-gray-500 small mb-0">Nos alegra verte otra vez por aquí</p>
                </div>
            </div>

            <!-- ============ BODY ============ -->
            <div class="modal-body p-4 pt-2">
                <p class="text-center text-gray-500 small mb-4">¿Qué te gustaría hacer hoy?</p>

                <div class="row g-3">

                    <!-- Opción 1: Escanear (verde) -->
                    <div class="col-6">
                        <a href="{{ route('scan') }}"
                           class="d-block p-4 rounded-4 text-decoration-none text-center welcome-option"
                           style="background: #f0fdf4; border: 1.5px solid #dcfce7;">
                            <div class="d-inline-flex align-items-center justify-content-center mb-2 rounded-3"
                                 style="width: 44px; height: 44px; background: white; box-shadow: 0 2px 8px rgba(34, 197, 94, 0.15);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                    <circle cx="12" cy="13" r="3"></circle>
                                </svg>
                            </div>
                            <p class="small fw-bold text-gray-700 mb-0">Escanear</p>
                        </a>
                    </div>

                    <!-- Opción 2: Mi Historial (naranja) -->
                    <div class="col-6">
                        <a href="{{ route('my.history') }}"
                           class="d-block p-4 rounded-4 text-decoration-none text-center welcome-option"
                           style="background: #fff7ed; border: 1.5px solid #ffedd5;">
                            <div class="d-inline-flex align-items-center justify-content-center mb-2 rounded-3"
                                 style="width: 44px; height: 44px; background: white; box-shadow: 0 2px 8px rgba(249, 115, 22, 0.15);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                    <path d="M3 3v5h5"></path>
                                    <path d="M12 7v5l4 2"></path>
                                </svg>
                            </div>
                            <p class="small fw-bold text-gray-700 mb-0">Mi Historial</p>
                        </a>
                    </div>

                    <!-- Opción 3: Explorar Foro (verde) -->
                    <div class="col-6">
                        <a href="{{ route('forum.index') }}"
                           class="d-block p-4 rounded-4 text-decoration-none text-center welcome-option"
                           style="background: #f0fdf4; border: 1.5px solid #dcfce7;">
                            <div class="d-inline-flex align-items-center justify-content-center mb-2 rounded-3"
                                 style="width: 44px; height: 44px; background: white; box-shadow: 0 2px 8px rgba(34, 197, 94, 0.15);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <p class="small fw-bold text-gray-700 mb-0">Explorar Foro</p>
                        </a>
                    </div>

                    <!-- Opción 4: Favoritos (naranja) -->
                    <div class="col-6">
                        <a href="{{ route('favorites.index') }}"
                           class="d-block p-4 rounded-4 text-decoration-none text-center welcome-option"
                           style="background: #fff7ed; border: 1.5px solid #ffedd5;">
                            <div class="d-inline-flex align-items-center justify-content-center mb-2 rounded-3"
                                 style="width: 44px; height: 44px; background: white; box-shadow: 0 2px 8px rgba(249, 115, 22, 0.15);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                                </svg>
                            </div>
                            <p class="small fw-bold text-gray-700 mb-0">Favoritos</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ============ FOOTER ============ -->
            <div class="modal-footer border-0 justify-content-center pb-4 pt-0">
                <button type="button"
                        class="btn px-5 py-2 rounded-pill text-white fw-bold border-0 d-inline-flex align-items-center gap-2 btn-continue"
                        data-bs-dismiss="modal"
                        style="background: #22c55e; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                    <span>Continuar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hover en las opciones */
    .welcome-option {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .welcome-option:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        filter: brightness(0.98);
    }

    /* Hover en botón continuar */
    .btn-continue {
        transition: all 0.3s ease;
    }
    .btn-continue:hover {
        background: #16a34a !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(34, 197, 94, 0.4) !important;
    }
</style>