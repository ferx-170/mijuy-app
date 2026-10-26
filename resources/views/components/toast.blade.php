<!-- Sistema de Toasts (alertas flotantes) -->
<div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 9999; margin-top: 80px;"></div>

@push('scripts')
<script>
    window.showToast = function(message, type = 'success', duration = 4000) {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const configs = {
            success: { bg: 'linear-gradient(135deg, #059669, #10b981)', icon: 'fa-check-circle' },
            error:   { bg: 'linear-gradient(135deg, #dc2626, #ef4444)', icon: 'fa-exclamation-circle' },
            info:    { bg: 'linear-gradient(135deg, #7c3aed, #a78bfa)', icon: 'fa-info-circle' },
            warning: { bg: 'linear-gradient(135deg, #f59e0b, #fbbf24)', icon: 'fa-exclamation-triangle' },
        };

        const cfg = configs[type] || configs.success;

        const toast = document.createElement('div');
        toast.className = 'toast-item mb-3 d-flex align-items-center gap-3 px-4 py-3 rounded-3 shadow-lg text-white';
        toast.style.cssText = `
            background: ${cfg.bg};
            min-width: 320px;
            max-width: 420px;
            animation: slideInRight 0.4s ease forwards;
            backdrop-filter: blur(10px);
        `;
        toast.innerHTML = `
            <i class="fas ${cfg.icon} fs-5"></i>
            <div class="flex-grow-1 small fw-medium">${message}</div>
            <button onclick="this.parentElement.remove()" class="btn-close btn-close-white btn-sm"></button>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.4s ease forwards';
            setTimeout(() => toast.remove(), 400);
        }, duration);
    };

    // Auto-disparar toasts desde session flash
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () => showToast(@json(session('success')), 'success'));
    @endif
    @if(session('error'))
        document.addEventListener('DOMContentLoaded', () => showToast(@json(session('error')), 'error'));
    @endif
    @if(session('info'))
        document.addEventListener('DOMContentLoaded', () => showToast(@json(session('info')), 'info'));
    @endif
</script>

<style>
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideOutRight {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(100%); }
    }
</style>
@endpush