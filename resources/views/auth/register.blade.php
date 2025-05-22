<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sapu Jagat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="{{ asset('Auth/css/register.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

</head>
<body>
    <div class="container">
        <div class="card">
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
                <form method="POST" action="{{ route('register') }}" id="form-daftar">
                    @csrf
                
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                    @error('name')
                      <div class="text-error">{{ $message }}</div>
                    @enderror
                
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')
                      <div class="text-error">{{ $message }}</div>
                    @enderror
                
                    <label for="password">Kata Sandi</label>
                    <input type="password" name="password" id="password" required>
                    @error('password')
                      <div class="text-error">{{ $message }}</div>
                    @enderror
                
                    <label for="address">Alamat</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}">
                    @error('address')
                      <div class="text-error">{{ $message }}</div>
                    @enderror
                
                    <div class="input-row">
                        <div class="input-group">
                            <label for="province">Provinsi</label>
                            <select name="province" id="province" class="form-select" required>
                                <option value="">Pilih Provinsi</option>
                                {{-- Option akan diisi oleh JS --}}
                            </select>
                            @error('province')
                              <div class="text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mt-3">
                            <label for="city">Kota</label>
                            <select name="city" id="city" class="form-select" required>
                                <option value="">Pilih Kota</option>
                                {{-- Option akan diisi oleh JS --}}
                            </select>
                            @error('city')
                             <div class="text-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <label for="postal_code">Kode Pos</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required>
                    @error('postal_code')
                      <div class="text-error">{{ $message }}</div>
                    @enderror
                
                    <label for="NIK">NIK</label>
                    <input type="text" name="NIK" id="NIK" value="{{ old('NIK') }}" required>
                    @error('NIK')
                      <div class="text-error">{{ $message }}</div>
                    @enderror
                
                    <label for="phone_num">Nomor Telepon</label>
                    <input id="phone_num" name="phone_num" type="tel" value="{{ old('phone_num') }}" required>
                    @error('phone_num')
                      <div class="text-error">{{ $message }}</div>
                    @enderror             
                
                    <div class="btn-group">
                        <button type="button" class="btn-google" onclick="window.location='{{ url('auth/google') }}'">
                            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" style="height: 18px; margin-right: 8px;">
                            Daftar dengan Google
                        </button>

                        <button type="submit" class="btn-daftar">Daftar</button>
                
                        <a href="{{ route('login') }}" class="akun">Masuk dengan Akun</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
<script src="{{ asset('Auth/js/kota.js') }}"></script>
</body>
</html>
