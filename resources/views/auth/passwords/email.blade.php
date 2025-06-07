@extends('layouts.app')

@section('body-class', 'bg-reset-password')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card border-0 shadow-sm" style="background-color: #e6f9e6;"> {{-- hijau muda --}}
                    <div class="card-header text-center fw-bold" style="background-color: #ccf5cc; font-family: 'Inria Sans', sans-serif;">
                        {{ __('Reset Password') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label" style="font-family: 'Inria Sans', sans-serif;">{{ __('Alamat Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn text-white"
                                    style="background-color: #4CAF50; transition: 0.3s; font-family: 'Inria Sans', sans-serif;"
                                    onmouseover="this.style.backgroundColor='#388E3C'"
                                    onmouseout="this.style.backgroundColor='#4CAF50'">
                                    {{ __('Kirim Link Reset Password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection