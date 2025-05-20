<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sapu Jagat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Auth/css/register.css') }}">
</head>
<body>
    <div class="container">
        <div class="login-card">
            {{-- Kiri: Gambar dan Quote --}}
            <div class="left">
                <div class="logo-container">
                    <img src="{{ asset('Auth/images/logo.png') }}" alt="Logo Sapu Jagat" class="logo-img">
                </div>
                <div class="quote-box">
                    <img src="{{ asset('Auth/images/card-image.png') }}" alt="Quote Background" class="quote-image">
                    <div class="quote-text">
                        <p>"Tidak ada tindakan kecil jika dilakukan bersama. Pilah sampah hari ini, selamatkan dunia untuk generasi esok!"</p>
                        <p class="author">~By Copitol~</p>
                    </div>
                </div>
            </div>

            {{-- Kanan: Form Daftar --}}
            <div class="right">
                <h2 class="form-title">Daftar</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>

                    <label for="password">Kata Sandi</label>
                    <input type="password" name="password" id="password" required>

                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" required>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="provinsi">Provinsi</label>
                            <select name="provinsi" id="provinsi" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="kota">Kota</label>
                            <select name="kota" id="kota" required>
                                <option value="">Pilih Kota</option>
                            </select>
                        </div>
                    </div>

                    <label for="kode_pos">Kode Pos</label>
                    <input type="text" name="kode_pos" id="kode_pos" required>

                    <label for="nik">NIK</label>
                    <input type="text" name="nik" id="nik" required>

                    <label for="telepon">Nomor Telepon</label>
                    <div class="phone-group">
                        <select name="kode_negara" id="kode_negara" class="phone-code">
                            <option value="+62" selected>+62</option>
                        </select>
                        <input type="text" name="telepon" id="telepon" required>
                    </div>

                    <a href="{{ route('login') }}" class="forgot-link">Masuk dengan akun?</a>

                    <button type="submit" class="btn-submit">Daftar</button>

                    <div class="divider"><span>atau</span></div>

                    <button type="button" class="btn-google">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" style="height: 18px; margin-right: 8px;">
                        Daftar dengan Google
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
