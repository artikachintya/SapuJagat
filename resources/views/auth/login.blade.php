<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sapu Jagat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('Auth/css/login.css') }}">
</head>

<body>
    <div class="container">
        <div class="login-card">
            <div class="left">
                <div class="logo-container">
                    <img src="{{ asset('Auth/images/logo.png') }}" alt="Logo Sapu Jagat" class="logo-img">
                </div>
                <div class="quote-box">
                    <img src="{{ asset('Auth/images/card-image.png') }}" alt="Quote Background" class="quote-image">
                    <div class="quote-text">
                        <p>"Tidak ada tindakan kecil jika dilakukan bersama. Pilah sampah hari ini, selamatkan dunia
                            untuk generasi esok!"</p>
                        <p class="author">~By Copitol~</p>
                    </div>
                </div>
            </div>

            <div class="right">
                <img src="Auth/images/logo.png" class="mobile-logo" alt="Logo">
                <h2>Masuk</h2>

                @if (session('error'))
                    <div class="overlay" id="error-overlay">
                        <div class="error-modal">
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="overlay" id="success-overlay" onclick="closeSuccessPopup()">
                        <div class="success-modal">
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="overlay" id="error-overlay">
                        <div class="error-modal">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email Anda">

                    <label>Kata Sandi</label>
                    <input type="password" name="password" value="{{ old('password') }}" required placeholder="Masukkan password Anda">

                    <div class="checkbox-group">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span>Ingat saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
                    </div>

                    <button type="submit" class="btn-primary">Masuk</button>

                    <div class="divider"><span>atau</span></div>

                    <div class="btn-group">
                        <form method="GET" action="{{ route('auth.google') }}">
                            <button type="button" class="btn-google"
                                onclick="window.location='{{ route('auth.google', ['mode' => 'login']) }}'">
                                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google"
                                    style="height: 18px; margin-right: 8px;">
                                Masuk dengan Google
                            </button>
                        </form>
                        <a href="{{ route('register') }}" class="btn-secondary">Belum punya akun</a>
                    </div>
                </form>

                @if (session('otp_required') && session()->has('otp_user_id'))
                    <div id="otpModal" class="modal" style="display:flex;">
                        <div class="modal-content">
                            <button class="close-btn" onclick="closeOtpModal()">×</button>
                            <h2>Masukkan OTP</h2>
                            <form method="POST" action="{{ route('otp.verify') }}">
                                @csrf
                                <input type="text" name="otp" maxlength="6" required placeholder="Kode OTP">
                                <button type="submit" class="btn-verify">Verifikasi</button>
                            </form>

                            <div class="resend-otp-section">
                                <button id="resendBtn" class="btn-resend" disabled>Kirim ulang kode (60 detik)</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>

    </script>

    <style>

    </style>

    <script src="{{ asset('Auth/js/login.js') }}"></script>
    <script>
        function closeSuccessPopup() {
            document.getElementById('success-overlay').style.display = 'none';
        }
    </script>
</body>

</html>