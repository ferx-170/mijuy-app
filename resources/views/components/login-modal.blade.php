<!-- ============================================================
     MODAL DE LOGIN — Diseño coherente MIJUY v3
     ============================================================ -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden" style="max-width: 440px;">

            <!-- ============ HEADER ============ -->
            <div class="position-relative p-5 pb-4" style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">

                <!-- Botón cerrar -->
                <button type="button"
                        class="position-absolute top-0 end-0 m-3 d-flex align-items-center justify-content-center rounded-circle border-0 transition-all"
                        data-bs-dismiss="modal"
                        aria-label="Cerrar"
                        style="width: 32px; height: 32px; background: rgba(0,0,0,0.04); color: #6b7280;"
                        onmouseover="this.style.background='rgba(0,0,0,0.08)'"
                        onmouseout="this.style.background='rgba(0,0,0,0.04)'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>

                <!-- Logo MIJUY -->
                <div class="text-center pt-3">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-4"
                         style="width: 68px; height: 68px; background: white; box-shadow: 0 8px 24px rgba(34, 197, 94, 0.15);">
                        <img src="{{ asset('img/logosin_sin.png') }}"
                             alt="MIJUY"
                             style="width: 40px; height: 40px; object-fit: contain;">
                    </div>
                    <h4 class="fw-bold text-gray-900 mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em;">
                        Bienvenido a <span style="color: #16a34a;">MIJUY</span>
                    </h4>
                    <p class="text-gray-500 small mb-0">Inicia sesión para continuar tu viaje nutricional</p>
                </div>
            </div>

            <!-- ============ BODY ============ -->
            <div class="modal-body px-4 px-md-5 pb-5 pt-2">
                
                <!-- Botón de Google (Arriba para mayor visibilidad) -->
                <a href="{{ route('google.login') }}" 
                   class="btn w-100 py-3 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2 mb-4" 
                   style="background: white; color: #374151; border: 1px solid #e5e7eb; transition: all 0.2s ease;"
                   onmouseover="this.style.background='#f9fafb'; this.style.borderColor='#d1d5db';"
                   onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Continuar con Google
                </a>

                <!-- Divisor -->
                <div class="d-flex align-items-center mb-4">
                    <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
                    <span class="px-3 small text-gray-400">o usa tu correo</span>
                    <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
                </div>

                <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <!-- Campo: Email -->
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label small fw-semibold text-gray-700 mb-2">
                            Correo electrónico
                        </label>
                        <div class="position-relative">
                            <span class="position-absolute top-50 translate-middle-y d-flex align-items-center justify-content-center"
                                  style="left: 1rem; color: #9ca3af; pointer-events: none;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="m22 7-10 6L2 7"></path>
                                </svg>
                            </span>
                            <input type="email"
                                   name="email"
                                   id="loginEmail"
                                   class="form-control form-control-lg border-0 rounded-3"
                                   placeholder="tu@correo.com"
                                   required
                                   autocomplete="email"
                                   style="padding: 0.85rem 1rem 0.85rem 3rem; background: #f9fafb; box-shadow: none; transition: all 0.25s ease;"
                                   onfocus="this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.15)'"
                                   onblur="this.style.background='#f9fafb'; this.style.boxShadow='none'">
                        </div>
                    </div>

                    <!-- Campo: Password -->
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label small fw-semibold text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="position-relative">
                            <span class="position-absolute top-50 translate-middle-y d-flex align-items-center justify-content-center"
                                  style="left: 1rem; color: #9ca3af; pointer-events: none;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input type="password"
                                   name="password"
                                   id="loginPassword"
                                   class="form-control form-control-lg border-0 rounded-3"
                                   placeholder="••••••••"
                                   required
                                   autocomplete="current-password"
                                   style="padding: 0.85rem 3rem 0.85rem 3rem; background: #f9fafb; box-shadow: none; transition: all 0.25s ease;"
                                   onfocus="this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.15)'"
                                   onblur="this.style.background='#f9fafb'; this.style.boxShadow='none'">

                            <!-- Botón ver/ocultar contraseña -->
                            <button type="button"
                                    id="togglePassword"
                                    class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent d-flex align-items-center justify-content-center"
                                    style="right: 0.75rem; padding: 0.5rem; color: #9ca3af;">
                                <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg id="eyeOffIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                    <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                    <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                    <line x1="2" y1="2" x2="22" y2="22"></line>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Recordar + Olvidé -->
                    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" style="accent-color: #22c55e; cursor: pointer;">
                            <label class="form-check-label small text-gray-600" for="rememberMe" style="cursor: pointer;">Mantener sesión</label>
                        </div>
                        <a href="#" class="small fw-semibold text-decoration-none" style="color: #16a34a; transition: color 0.2s;" onmouseover="this.style.color='#15803d'" onmouseout="this.style.color='#16a34a'">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <!-- Errores -->
                    @if($errors->any())
                        <div class="rounded-3 p-3 mb-3 d-flex align-items-start gap-2" style="background: #fef2f2; border: 1px solid #fecaca;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <span class="small" style="color: #b91c1c;">{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <!-- Botón submit -->
                    <button type="submit"
                            class="btn w-100 py-3 rounded-3 text-white fw-bold border-0 d-flex align-items-center justify-content-center gap-2"
                            style="background: #22c55e; font-size: 1rem; transition: all 0.3s ease; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);"
                            onmouseover="this.style.background='#16a34a'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(34, 197, 94, 0.4)';"
                            onmouseout="this.style.background='#22c55e'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(34, 197, 94, 0.3)';">
                        <span>Iniciar Sesión</span>
                    </button>

                    <!-- Link a registro -->
                    <p class="text-center small text-gray-600 mb-0 mt-4">
                        ¿No tienes cuenta?
                        <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal" class="fw-bold text-decoration-none ms-1" style="color: #f97316; transition: color 0.2s;" onmouseover="this.style.color='#ea580c'" onmouseout="this.style.color='#f97316'">
                            Regístrate gratis
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle mostrar/ocultar contraseña
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('togglePassword');
        const input = document.getElementById('loginPassword');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeIcon.style.display = 'none';
                    eyeOffIcon.style.display = 'block';
                } else {
                    input.type = 'password';
                    eyeIcon.style.display = 'block';
                    eyeOffIcon.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush