<!-- Modal de Bienvenida -->
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow-lg" style="max-width: 480px;">
            <!-- Header -->
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" style="font-size: 1.5rem;">¡Bienvenido a MIJUY!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-2">
                <p class="text-muted small mb-4">Cuéntanos un poco sobre ti para personalizar tu experiencia.</p>

                <form id="userForm">
                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="userName" class="form-label fw-semibold text-dark" style="font-size: 0.9rem;">Nombre</label>
                        <input type="text" class="form-control form-control-lg rounded-3" id="userName" placeholder="Tu nombre" required style="border: 1px solid #e5e7eb; background: #f9fafb;">
                    </div>

                    <!-- Objetivo -->
                    <div class="mb-3">
                        <label for="userGoal" class="form-label fw-semibold text-dark" style="font-size: 0.9rem;">Objetivo principal</label>
                        <select class="form-select form-select-lg rounded-3" id="userGoal" style="border: 1px solid #e5e7eb; background: #f9fafb;">
                            <option value="bajar_peso">Bajar de peso</option>
                            <option value="cuidar_salud">Cuidar mi salud</option>
                            <option value="ganar_masa">Ganar masa muscular</option>
                            <option value="mejorar_alimentacion">Mejorar mi alimentación</option>
                            <option value="aprender_cocinar">Aprender a cocinar</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <!-- Meta (opcional) -->
                    <div class="mb-3">
                        <label for="userMeta" class="form-label fw-semibold text-dark" style="font-size: 0.9rem;">Meta (opcional)</label>
                        <textarea class="form-control rounded-3" id="userMeta" rows="2" placeholder="Describe tu meta..." style="border: 1px solid #e5e7eb; background: #f9fafb;"></textarea>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn w-100 py-3 rounded-3 text-white fw-bold" id="saveUserData" style="background: #1a2a3a; font-size: 1rem;">
                    Guardar y continuar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verificar si ya se mostró el modal
        if (!localStorage.getItem('mijuy_welcome_shown')) {
            var myModal = new bootstrap.Modal(document.getElementById('welcomeModal'), {
                backdrop: 'static',
                keyboard: false
            });
            myModal.show();

            document.getElementById('saveUserData').addEventListener('click', function() {
                const name = document.getElementById('userName').value.trim();
                if (!name) {
                    alert('Por favor, ingresa tu nombre.');
                    return;
                }
                const goal = document.getElementById('userGoal').value;
                const meta = document.getElementById('userMeta').value.trim();

                // Guardar en localStorage
                localStorage.setItem('mijuy_user', JSON.stringify({
                    name: name,
                    goal: goal,
                    meta: meta
                }));
                localStorage.setItem('mijuy_welcome_shown', 'true');

                myModal.hide();
            });
        }
    });
</script>
@endpush