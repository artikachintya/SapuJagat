@extends('layouts.app')

@section('body-class', 'bg-reset-password')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div style="background-color: #e6ffed; border: 1px solid #b7eb8f; padding: 30px; border-radius: 10px;">
                <h3 style="color: #237804; text-align: center; margin-bottom: 30px;">Reset Password</h3>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Anda</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ $email ?? old('email') }}"
                               required autocomplete="email" autofocus
                               placeholder="Masukkan email Anda">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password"
                               placeholder="Masukkan password baru">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                        <input id="password-confirm" type="password"
                               class="form-control"
                               name="password_confirmation" required autocomplete="new-password"
                               placeholder="Ulangi password baru Anda">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn" style="background-color: #52c41a; color: white; font-weight: bold; padding: 10px 30px; border-radius: 5px;">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
