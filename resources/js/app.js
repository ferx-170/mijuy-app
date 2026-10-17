//
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal-preferencias');
    const form = document.getElementById('form-preferencias');

    // 1. Al enviar el formulario, guardamos en localStorage
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const data = {
            objetivo: document.getElementById('objetivo').value,
            restricciones: document.getElementById('restricciones').value
        };
        localStorage.setItem('user_prefs', JSON.stringify(data));
        window.location.href = '/dashboard'; // Redirigimos al panel
    });

    // 2. Lógica para abrir el modal si no hay datos guardados
    // Puedes llamar a esta función desde el botón "Comenzar Análisis"
    window.abrirPreferencias = () => {
        const prefs = localStorage.getItem('user_prefs');
        if (prefs) {
            window.location.href = '/dashboard';
        } else {
            modal.classList.remove('hidden');
        }
    };
});