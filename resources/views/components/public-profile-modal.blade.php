<!-- ============================================================
     MODAL DE PERFIL PÚBLICO (Autor)
     ============================================================ -->
<div class="modal fade" id="authorProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden" style="max-width: 650px; margin: 0 auto;">
            
            <!-- Botón cerrar -->
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4 z-3" data-bs-dismiss="modal" aria-label="Cerrar" style="z-index: 10;"></button>

            <!-- Header con Cover y Avatar -->
            <div class="position-relative" style="height: 140px; background: linear-gradient(135deg, #22c55e, #16a34a);">
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2">
                    <div id="authorAvatarContainer" class="w-24 h-24 rounded-circle border-4 border-white shadow-lg overflow-hidden bg-white d-flex align-items-center justify-content-center">
                        <!-- Se llena con JS (imagen o inicial) -->
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body p-4 pt-5 mt-3 text-center">
                
                <!-- Nombre y Fecha de registro -->
                <h3 id="authorName" class="fw-bold text-gray-900 mb-1" style="font-size: 1.5rem;">Cargando...</h3>
                <p id="authorJoined" class="text-gray-500 small mb-3">Miembro desde...</p>

                <!-- Bio -->
                <div class="bg-gray-50 rounded-3xl p-4 mb-5 text-left inline-block w-100">
                    <p id="authorBio" class="text-gray-600 text-sm mb-0 italic">"Este usuario aún no ha escrito una biografía."</p>
                </div>

                <!-- Otras recetas -->
                <div class="text-left">
                    <h5 class="font-bold text-gray-900 mb-3 d-flex align-items-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path><circle cx="12" cy="13" r="3"></circle></svg>
                        Más recetas de <span id="authorNameInline" class="text-green-600">...</span>
                    </h5>
                    
                    <div id="authorRecipesGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <!-- Se llenan las recetas con JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>