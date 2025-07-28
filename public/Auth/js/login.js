document.addEventListener('DOMContentLoaded', function () {
    const errorOverlay = document.getElementById('error-overlay');
    const successOverlay = document.getElementById('success-overlay');
    const otpModal = document.getElementById('otpModal');

    // --- General Overlay/Modal Handling ---
    if (errorOverlay) {
        setTimeout(() => hideOverlay(errorOverlay), 4000);
        errorOverlay.addEventListener('click', () => hideOverlay(errorOverlay));
    }
    if (successOverlay) {
        setTimeout(() => hideOverlay(successOverlay), 3000);
        successOverlay.addEventListener('click', () => hideOverlay(successOverlay));
    }

    function hideOverlay(element) {
        if (!element) return;
        element.style.transition = 'opacity 0.5s ease';
        element.style.opacity = '0';
        setTimeout(() => {
            element.style.display = 'none';
        }, 500);
    }

    // --- ✨ REWRITTEN OTP LOGIC ---
    if (otpModal) {
        const resendBtn = document.getElementById("resendBtn");
        let countdownTimer;

        // Function to start or restart the countdown timer
        const startCountdown = (expiryTimestamp) => {
            clearInterval(countdownTimer); // Clear any existing timer
            resendBtn.disabled = true;

            countdownTimer = setInterval(() => {
                const now = Math.floor(Date.now() / 1000);
                const secondsLeft = expiryTimestamp - now;

                if (secondsLeft <= 0) {
                    clearInterval(countdownTimer);
                    resendBtn.disabled = false;
                    resendBtn.textContent = "Kirim ulang kode";
                    sessionStorage.removeItem('otpExpiry'); // Clean up storage
                } else {
                    resendBtn.textContent = `Kirim ulang kode (${secondsLeft} detik)`;
                }
            }, 1000);
        };

        // Initialize timer on page load
        const initializeTimer = () => {
            // Priority 1: Use the initial timestamp from Laravel if this is the first load
            let expiry = window.otpConfig.initialExpiresAt;
            if (expiry) {
                sessionStorage.setItem('otpExpiry', expiry);
            } else {
                // Priority 2: Use the timestamp from sessionStorage if it's a refresh
                expiry = sessionStorage.getItem('otpExpiry');
            }

            if (expiry) {
                startCountdown(parseInt(expiry, 10));
            } else {
                // If no expiry exists, enable the button immediately
                resendBtn.disabled = false;
                resendBtn.textContent = "Kirim ulang kode";
            }
        };

        // Resend Button Click Handler
        resendBtn.addEventListener("click", function () {
            resendBtn.disabled = true;
            resendBtn.textContent = "Mengirim ulang...";

            fetch(window.otpConfig.resendUrl, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": window.otpConfig.csrfToken,
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.expires_at) {
                        // Store new expiry time and restart countdown
                        sessionStorage.setItem('otpExpiry', data.expires_at);
                        startCountdown(data.expires_at);
                    } else {
                        throw new Error(data.message || "Resend failed");
                    }
                })
                .catch((error) => {
                    console.error("Resend OTP Error:", error);
                    alert("Gagal mengirim ulang kode OTP.");
                    resendBtn.disabled = false; // Re-enable on failure
                    resendBtn.textContent = "Kirim ulang kode";
                });
        });

        // Start the process
        initializeTimer();
    }
});


// ✨ REWRITTEN FUNCTION: Close OTP Modal and clear the session on the server
function closeOtpModal() {
    const modal = document.getElementById('otpModal');
    if (!modal) return;

    // Call the server to cancel the OTP session
    fetch(window.otpConfig.cancelUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.otpConfig.csrfToken,
            'Content-Type': 'application/json'
        }
    }).then(response => {
        if (response.ok) {
            // Hide the modal only after the server confirms
            modal.style.display = 'none';
            // Clear the timer from storage so it doesn't resume if the user logs in again
            sessionStorage.removeItem('otpExpiry');
        } else {
            // If the server fails, alert the user but maybe don't close the modal
            alert('Could not close the OTP prompt. Please try again.');
        }
    }).catch(error => {
        console.error('Error closing OTP modal:', error);
        alert('An error occurred. Please refresh the page.');
    });
}

function closeSuccessPopup() {
    const overlay = document.getElementById('success-overlay');
    if (!overlay) return;
    overlay.style.transition = 'opacity 0.5s ease';
    overlay.style.opacity = '0';
    setTimeout(() => {
        overlay.style.display = 'none';
    }, 500);
}