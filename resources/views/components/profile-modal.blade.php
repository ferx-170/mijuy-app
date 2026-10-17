<!-- ============================================================
     MODAL DE PERFIL (Solo para usuarios logueados)
     ============================================================ -->
@auth
<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden" style="max-width: 600px; margin: 0 auto;">
            
            <!-- Header -->
            <div class="position-relative p-5 pb-4 text-center" style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                
                <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle position-relative" style="width: 90px; height: 90px;">
                    <!-- Mostramos el avatar si tiene, sino las iniciales -->
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-100 h-100 rounded-circle object-cover shadow-md border-4 border-white">
                    @else
                        <div class="w-100 h-100 rounded-circle d-flex align-items-center justify-content-center text-white fs-2 fw-bold shadow-md border-4 border-white" style="background: linear-gradient(135deg, #22c55e, #16a34a);">
                            {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <h4 class="fw-bold text-gray-900 mb-1" style="font-size: 1.4rem;">Mi Perfil</h4>
                <p class="text-gray-500 small mb-0">Actualiza tu información personal</p>
            </div>

            <!-- Body -->
            <div class="modal-body p-4 p-md-5 pt-2">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-gray-700 mb-2">Nombre completo</label>
                            <input type="text" name="nombre" value="{{ old('nombre', auth()->user()->nombre) }}" required
                                   class="form-control form-control-lg border-0 rounded-3" style="background: #f9fafb; box-shadow: none;">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-gray-700 mb-2">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                   class="form-control form-control-lg border-0 rounded-3" style="background: #f9fafb; box-shadow: none;">
                        </div>

                        <!-- Avatar (URL) -->
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-gray-700 mb-2">URL de tu Foto de Perfil (Opcional)</label>
                            <input type="url" name="avatar" value="{{ old('avatar', auth()->user()->avatar) }}" placeholder="https://ejemplo.com/mi-foto.jpg"
                                   class="form-control form-control-lg border-0 rounded-3" style="background: #f9fafb; box-shadow: none;">
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">Pega el enlace de una imagen (JPG, PNG).</small>
                        </div>

                        <!-- Bio -->
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-gray-700 mb-2">Biografía (Opcional)</label>
                            <textarea name="bio" rows="3" placeholder="Cuéntale a la comunidad sobre ti y tus metas nutricionales..."
                                      class="form-control border-0 rounded-3" style="background: #f9fafb; box-shadow: none; resize: none;">{{ old('bio', auth()->user()->bio) }}</textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <hr class="border-gray-100">
                            <p class="small fw-semibold text-gray-500 mb-3">Cambiar Contraseña (dejar en blanco para no cambiar)</p>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-gray-700 mb-2">Nueva Contraseña</label>
                            <input type="password" name="password" placeholder="Mín. 6 caracteres"
                                   class="form-control form-control-lg border-0 rounded-3" style="background: #f9fafb; box-shadow: none;">
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-gray-700 mb-2">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" placeholder="Repite la contraseña"
                                   class="form-control form-control-lg border-0 rounded-3" style="background: #f9fafb; box-shadow: none;">
                        </div>
                    </div>

                    <!-- Botón Guardar -->
                    <div class="mt-5">
                        <button type="submit" class="btn w-100 py-3 rounded-3 text-white fw-bold border-0 d-flex align-items-center justify-content-center gap-2"
                                style="background: #22c55e; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth