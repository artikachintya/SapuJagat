document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('error-overlay');

    if (overlay) {
        // Otomatis hilang setelah 4 detik
        setTimeout(() => {
            hideOverlay();
        }, 4000);

        // Hilang saat diklik
        overlay.addEventListener('click', function () {
            hideOverlay();
        });
    }

    function hideOverlay() {
        overlay.style.transition = 'opacity 0.5s ease';
        overlay.style.opacity = '0';

        setTimeout(() => {
            overlay.style.display = 'none';
        }, 250); // setelah transisi selesai
    }
});

function closeOtpModal() {
    const modal = document.getElementById('otpModal');
    if (modal) {
        modal.style.display = 'none';
    }
}
