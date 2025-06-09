document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('error-overlay');
    const resendBtn = document.getElementById("resendBtn");
    let countdown = 60;
    let timer;

    // Overlay Error Handling
    if (overlay) {
        // Otomatis hilang setelah 4 detik
        setTimeout(() => {
            hideOverlay();
        }, 4000);

        // Hilang saat diklik
        overlay.addEventListener('click', function () {
            hideOverlay();
        });

        function hideOverlay() {
            overlay.style.transition = 'opacity 0.5s ease';
            overlay.style.opacity = '0';

            setTimeout(() => {
                overlay.style.display = 'none';
            }, 250); // setelah transisi selesai
        }
    }

    // Resend OTP Handling
    if (resendBtn) {
        startCountdown(); // Jalankan timer saat halaman dimuat

        resendBtn.addEventListener("click", function () {
            resendBtn.disabled = true;
            resendBtn.textContent = "Mengirim ulang...";

            fetch(resendOtpUrl, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({})
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Resend failed");
                    }
                    return response.json();
                })
                .then(data => {
                    countdown = 60;
                    clearInterval(timer);
                    startCountdown();
                })
                .catch(() => {
                    alert("Gagal mengirim ulang kode OTP.");
                    resendBtn.disabled = false;
                    resendBtn.textContent = "Kirim ulang kode";
                });
        });

        function startCountdown() {
            resendBtn.disabled = true;
            resendBtn.classList.remove("active");
            countdown = 60;

            timer = setInterval(() => {
                countdown--;

                if (countdown <= 0) {
                    clearInterval(timer);
                    resendBtn.disabled = false;
                    resendBtn.textContent = "Kirim ulang kode";
                    resendBtn.classList.add("active");
                } else {
                    resendBtn.textContent = `Kirim ulang kode (${countdown} detik)`;
                }
            }, 1000);
        }
    }
});

const resendOtpUrl = "{{ route('otp.resend') }}";
const csrfToken = "{{ csrf_token() }}";

// Auto-dismiss success modal after 3 seconds
$(document).ready(function () {
    setTimeout(function () {
        $('#success-overlay').fadeOut();
    }, 3000);
});

// Fungsi untuk menutup modal OTP
function closeOtpModal() {
    const modal = document.getElementById('otpModal');
    if (modal) {
        modal.style.display = 'none';
    }
}
