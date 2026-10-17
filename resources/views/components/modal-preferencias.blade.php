<!-- Modal de Preferencias -->
<div class="modal fade" id="preferencesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-3 border-0 shadow-lg">
            <!-- Header -->
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" style="font-size: 1.5rem;">Preferencias de Salud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-2">
                <p class="text-muted small mb-4">Personaliza cómo MIJUY analiza tus platos para alinearse con tus metas.</p>

                <form id="preferencesForm">
                    <!-- Objetivo principal -->
                    <div class="mb-4">
                        <label for="prefGoal" class="form-label fw-semibold text-dark" style="font-size: 0.9rem;">¿Cuál es tu objetivo principal?</label>
                        <select class="form-select form-select-lg rounded-3" id="prefGoal" style="border: 1px solid #e5e7eb; background: #f9fafb;">
                            <option value="mantenimiento">Mantenimiento saludable</option>
                            <option value="bajar_peso">Bajar de peso</option>
                            <option value="ganar_masa">Ganar masa muscular</option>
                            <option value="mejorar_salud">Mejorar salud general</option>
                        </select>
                    </div>

                    <!-- Alergias alimentarias -->
                    <div class="mb-4">
                        <label for="prefAllergies" class="form-label fw-semibold text-dark" style="font-size: 0.9rem;">Alergias alimentarias</label>
                        <input type="text" class="form-control form-control-lg rounded-3" id="prefAllergies" placeholder="Ej: Maní, mariscos, gluten..." style="border: 1px solid #e5e7eb; background: #f9fafb;">
                        <small class="text-muted d-block mt-1">Identificaremos estos ingredientes automáticamente en tus análisis.</small>
                    </div>

                    <!-- Restricciones dietéticas -->
                    <div class="mb-3">
                        <label for="prefDiet" class="form-label fw-semibold text-dark" style="font-size: 0.9rem;">Restricciones dietéticas</label>
                        <input type="text" class="form-control form-control-lg rounded-3" id="prefDiet" placeholder="Ej: Vegano, Keto, bajo en sodio..." style="border: 1px solid #e5e7eb; background: #f9fafb;">
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 pt-0 d-flex gap-2">
                <button type="button" class="btn btn-light px-5 py-3 rounded-3 fw-bold" data-bs-dismiss="modal" style="font-size: 1rem; border: 1px solid #e5e7eb;">Cancelar</button>
                <button type="button" class="btn px-5 py-3 rounded-3 text-white fw-bold" id="savePreferences" style="background: #1a2a3a; font-size: 1rem;">
                    Guardar Preferencias
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar preferencias guardadas (si existen)
        const savedPrefs = localStorage.getItem('mijuy_preferences');
        if (savedPrefs) {
            const prefs = JSON.parse(savedPrefs);
            document.getElementById('prefGoal').value = prefs.goal || 'mantenimiento';
            document.getElementById('prefAllergies').value = prefs.allergies || '';
            document.getElementById('prefDiet').value = prefs.diet || '';
        }

        // Guardar preferencias
        document.getElementById('savePreferences').addEventListener('click', function() {
            const goal = document.getElementById('prefGoal').value;
            const allergies = document.getElementById('prefAllergies').value.trim();
            const diet = document.getElementById('prefDiet').value.trim();

            localStorage.setItem('mijuy_preferences', JSON.stringify({
                goal: goal,
                allergies: allergies,
                diet: diet
            }));

            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('preferencesModal'));
            if (modal) modal.hide();

            // Opcional: mostrar mensaje de éxito
            alert('✅ Preferencias guardadas correctamente.');
        });
    });
</script>
@endpush