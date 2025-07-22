<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('register.title') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="{{ asset('Auth/css/register.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

</head>

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

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
                        <p>{{ __('register.quote.text') }}</p>
<p class="author">{{ __('register.quote.author') }}</p>

                    </div>
                </div>
            </div>

            {{-- Kanan: Form Daftar --}}
            <div class="right">
                <h2 class="form-title">{{ __('register.form.title') }}</h2>
                <form method="POST" action="{{ route('register') }}" id="form-daftar">
                    @csrf

                    <label for="name">{{ __('register.form.fields.name') }}</label>
<input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="{{ __('register.form.placeholders.name') }}">
                    @error('name')
                      <div class="text-error">{{ $message }}</div>
                    @enderror

                    <label for="email">{{ __('register.form.fields.email') }}</label>
<input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="{{ __('register.form.placeholders.email') }}">
                    @error('email')
                      <div class="text-error">{{ $message }}</div>
                    @enderror

                    <label for="password">{{ __('register.form.fields.password') }}</label>
<input type="password" name="password" id="password" required placeholder="{{ __('register.form.placeholders.password') }}">
                    @error('password')
                      <div class="text-error">{{ $message }}</div>
                    @enderror


<label for="address">{{ __('register.form.fields.address') }}</label>
<input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="{{ __('register.form.placeholders.address') }}">
                    @error('address')
                      <div class="text-error">{{ $message }}</div>
                    @enderror

                    <div class="input-row">
                        <div class="input-group">
                            <label for="province">{{ __('register.form.fields.province') }}</label>
<select name="province" id="province" required>
    <option value="">{{ __('register.form.placeholders.province') }}</option>
    {{-- option diisi JS --}}
</select>
                            @error('province')
                              <div class="text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mt-3">
                            <label for="city">{{ __('register.form.fields.city') }}</label>
<select name="city" id="city" required>
    <option value="">{{ __('register.form.placeholders.city') }}</option>
    {{-- option diisi JS --}}
</select>

                            @error('city')
                             <div class="text-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <label for="postal_code">{{ __('register.form.fields.postal_code') }}</label>
<input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required placeholder="{{ __('register.form.placeholders.postal_code') }}">
                    @error('postal_code')
                      <div class="text-error">{{ $message }}</div>
                    @enderror

                    <label for="NIK">{{ __('register.form.fields.nik') }}</label>
<input type="text" name="NIK" id="NIK" value="{{ old('NIK') }}" required placeholder="{{ __('register.form.placeholders.nik') }}">

                    @error('NIK')
                      <div class="text-error">{{ $message }}</div>
                    @enderror

                  <label for="phone_num">{{ __('register.form.fields.phone_num') }}</label>
<input id="phone_num" name="phone_num" type="tel" value="{{ old('phone_num') }}" required placeholder="{{ __('register.form.placeholders.phone_num') }}">
                    @error('phone_num')
                      <div class="text-error">{{ $message }}</div>
                    @enderror

                    <div class="btn-group">
                        <button type="button" class="btn-google" onclick="window.location='{{ route('auth.google', ['mode' => 'register']) }}'">
                            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" style="height: 18px; margin-right: 8px;">
                             {{ __('register.form.buttons.google') }}
                        </button>

                        <button type="submit" class="btn-daftar">{{ __('register.form.buttons.register') }}</button>

                        <button type="button" class="btn-akun" onclick="window.location='{{ route('login') }}'">{{ __('register.form.buttons.login') }}</button>


                    </div>
                </form>

            </div>
        </div>
    </div>
<script src="{{ asset('Auth/js/kota.js') }}"></script>
</body>
</html>
