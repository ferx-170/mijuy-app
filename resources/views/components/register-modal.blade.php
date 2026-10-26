<!-- ============================================================
     MODAL DE REGISTRO — Diseño coherente MIJUY v2
     ============================================================ -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden" style="max-width: 560px; margin: 0 auto;">

            <!-- ============ HEADER ============ -->
            <div class="position-relative p-5 pb-4" style="background: linear-gradient(180deg, #fff7ed 0%, #ffffff 100%);">

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
                         style="width: 68px; height: 68px; background: white; box-shadow: 0 8px 24px rgba(249, 115, 22, 0.15);">
                        <img src="{{ asset('img/logosin_sin.png') }}"
                             alt="MIJUY"
                             style="width: 40px; height: 40px; object-fit: contain;">
                    </div>
                    <h4 class="fw-bold text-gray-900 mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em;">
                        Únete a <span style="color: #ea580c;">MIJUY</span>
                    </h4>
                    <p class="text-gray-500 small mb-0">Crea tu cuenta y comienza a transformar tu alimentación</p>
                </div>
            </div>

            <!-- ============ BODY ============ -->
            <div class="modal-body px-4 px-md-5 pb-4 pt-2">
                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row g-3">

                        <!-- Nombre -->
                        <div class="col-12">
                            <label for="regName" class="form-label small fw-semibold text-gray-700 mb-2">
                                Nombre completo
                            </label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y d-flex align-items-center justify-content-center"
                                      style="left: 1rem; color: #9ca3af; pointer-events: none;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </span>
                                <input type="text"
                                       name="nombre"
                                       id="regName"
                                       class="form-control form-control-lg border-0 rounded-3"
                                       placeholder="Tu nombre"
                                       required
                                       style="padding: 0.85rem 1rem 0.85rem 3rem; background: #f9fafb; box-shadow: none; transition: all 0.25s ease;"
                                       onfocus="this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.15)'"
                                       onblur="this.style.background='#f9fafb'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-12">
                            <label for="regEmail" class="form-label small fw-semibold text-gray-700 mb-2">
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
                                       id="regEmail"
                                       class="form-control form-control-lg border-0 rounded-3"
                                       placeholder="tu@correo.com"
                                       required
                                       style="padding: 0.85rem 1rem 0.85rem 3rem; background: #f9fafb; box-shadow: none; transition: all 0.25s ease;"
                                       onfocus="this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.15)'"
                                       onblur="this.style.background='#f9fafb'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label for="regPassword" class="form-label small fw-semibold text-gray-700 mb-2">
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
                                       id="regPassword"
                                       class="form-control form-control-lg border-0 rounded-3"
                                       placeholder="Mín. 6 caracteres"
                                       required
                                       style="padding: 0.85rem 1rem 0.85rem 3rem; background: #f9fafb; box-shadow: none; transition: all 0.25s ease;"
                                       onfocus="this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.15)'"
                                       onblur="this.style.background='#f9fafb'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        <!-- Confirmar password -->
                        <div class="col-md-6">
                            <label for="regPasswordConfirm" class="form-label small fw-semibold text-gray-700 mb-2">
                                Confirmar contraseña
                            </label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y d-flex align-items-center justify-content-center"
                                      style="left: 1rem; color: #9ca3af; pointer-events: none;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 12l2 2 4-4"></path>
                                        <path d="M21 12c-1 0-3-1-3-3s2-3 3-3"></path>
                                        <path d="M3 12c1 0 3-1 3-3s-2-3-3-3"></path>
                                    </svg>
                                </span>
                                <input type="password"
                                       name="password_confirmation"
                                       id="regPasswordConfirm"
                                       class="form-control form-control-lg border-0 rounded-3"
                                       placeholder="Repite la contraseña"
                                       required
                                       style="padding: 0.85rem 1rem 0.85rem 3rem; background: #f9fafb; box-shadow: none; transition: all 0.25s ease;"
                                       onfocus="this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.15)'"
                                       onblur="this.style.background='#f9fafb'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        <!-- Objetivo -->
                        <div class="col-12">
                            <label for="regGoal" class="form-label small fw-semibold text-gray-700 mb-2">
                                Objetivo principal
                            </label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y d-flex align-items-center justify-content-center"
                                      style="left: 1rem; color: #9ca3af; pointer-events: none; z-index: 10;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <circle cx="12" cy="12" r="6"></circle>
                                        <circle cx="12" cy="12" r="2"></circle>
                                    </svg>
                                </span>
                                <select name="objetivo"
                                        id="regGoal"
                                        class="form-select form-select-lg border-0 rounded-3"
                                        style="padding: 0.85rem 1rem 0.85rem 3rem; background: #f9fafb; box-shadow: none; transition: all 0.25s ease; cursor: pointer;"
                                        onfocus="this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.15)'"
                                        onblur="this.style.background='#f9fafb'; this.style.boxShadow='none'">
                                    <option value="mantenimiento">Mantenimiento saludable</option>
                                    <option value="bajar_peso">Bajar de peso</option>
                                    <option value="ganar_masa">Ganar masa muscular</option>
                                    <option value="mejorar_salud">Mejorar salud general</option>
                                    <option value="aprender_cocinar">Aprender a cocinar</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Errores -->
                    @if($errors->any())
                        <div class="rounded-3 p-3 mt-3 d-flex align-items-start gap-2"
                             style="background: #fef2f2; border: 1px solid #fecaca;">
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
                            class="btn w-100 py-3 rounded-3 text-white fw-bold border-0 mt-4 d-flex align-items-center justify-content-center gap-2"
                            style="background: #f97316; font-size: 1rem; transition: all 0.3s ease; box-shadow: 0 4px 14px rgba(249, 115, 22, 0.3);"
                            onmouseover="this.style.background='#ea580c'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(249, 115, 22, 0.4)';"
                            onmouseout="this.style.background='#f97316'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(249, 115, 22, 0.3)';">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <line x1="19" y1="8" x2="19" y2="14"></line>
                            <line x1="22" y1="11" x2="16" y2="11"></line>
                        </svg>
                        <span>Crear mi cuenta</span>
                    </button>

                    <!-- Link a login -->
                    <p class="text-center small text-gray-600 mt-4 mb-0">
                        ¿Ya tienes cuenta?
                        <a href="#"
                           data-bs-dismiss="modal"
                           data-bs-toggle="modal"
                           data-bs-target="#loginModal"
                           class="fw-bold text-decoration-none ms-1"
                           style="color: #16a34a; transition: color 0.2s;"
                           onmouseover="this.style.color='#15803d'"
                           onmouseout="this.style.color='#16a34a'">
                            Inicia sesión
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>