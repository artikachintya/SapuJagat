<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sapu Jagat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
                      <p>
                          "Tidak ada tindakan kecil jika dilakukan bersama. Pilah sampah hari ini, selamatkan dunia untuk generasi esok!"
                      </p>
                      <p class="author">~By Copitol~</p>
                  </div>
              </div>
          </div>
            <div class="right">
                <img src="Auth/images/logo.png" class="mobile-logo" alt="Logo">
                <h2>Masuk</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <label>Email</label>
                    <input type="email" name="email" required>

                    <label>Kata Sandi</label>
                    <input type="password" name="password" required>

                    <div class="checkbox-group">
                        <div class="remember-me">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Ingatkan saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
                    </div>

                    <button type="submit" class="btn-primary">Masuk</button>

                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <div class="btn-group">
                        <button class="btn-google">
                            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" style="height: 18px; margin-right: 8px;">
                            Masuk dengan Google
                        </button>
                        <a href="{{ route('register') }}" class="btn-secondary">Belum punya akun</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
