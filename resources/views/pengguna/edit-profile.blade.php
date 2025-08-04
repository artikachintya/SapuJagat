@extends('pengguna.partials.pengguna')

@section('title', 'Profile Pengguna')

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/edit-profile.css') }}" rel="stylesheet">
@endpush

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script> --}}
    <script src="{{ asset('Auth/js/kota.js') }}"></script>

    <!-- Custom Script -->
    <script>
        document.getElementById('profile_pic_upload').addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('preview-image');
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush

@section('content')
    <main class="app-main">
        <!-- Header Section -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0"><b> {{ __('profile.title') }} </b></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-report p-4">
                            <!-- Card Title -->
                            <div class="card-title mb-4">
                                <h5><b> {{ __('profile.edit_title') }} </b></h5>
                            </div>
                            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


                            <!-- Content Body -->
                            <form action="{{ route('pengguna.profile.save') }}" id="bautai" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <!-- Left: Profile Info -->
                                    <div class="col-md-8">
                                        <!-- Foto Profile + Edit Icon -->

                                        <div class="profile-pic d-flex justify-content-center">
                                            <img id="preview-image"
                                                src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('assets/img/default-profile.webp') }}"
                                                alt="Profile Picture" class="profile-picture">

                                            <!-- Icon Kamera Edit -->
                                            <label for="profile_pic_upload" class="edit-icon">
                                                <i class="fas fa-camera"></i>
                                            </label>

                                            <input type="file" name="profile_pic" id="profile_pic_upload" class="d-none">
                                            <br>
                                        </div>
                                        @error('profile_pic')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror


                                        <!-- Form Fields -->
                                        <div class="mb-3">
                                            <label class="form-label"><strong> {{ __('profile.fields.full_name') }}
                                                </strong></label>
                                            <input type="text" class="form-control border-0 p-2" name="name"
                                                value="{{ $user->name }}">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><strong> {{ __('profile.fields.nik') }}
                                                </strong></label>
                                            <input type="text" class="form-control border-0 p-2" name="NIK"
                                                value="{{ $user->NIK }}" @if(!$user->is_google_user || $user->NIK) disabled @endif  >
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label"><strong> {{ __('profile.fields.email') }}
                                                </strong></label>
                                            <input type="email" class="form-control border-0 p-2" name="email"
                                                value="{{ $user->email }}">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><strong> {{ __('profile.fields.password') }}
                                                </strong></label>
                                            <input type="password" class="form-control border-0 p-2" name="password"
                                                id="password" placeholder="********">
                                            @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>


                                        <div class="row">
                                            <div class="col-md-8">

                                                <div class="mb-3">
                                                    <label class="form-label"><strong> {{ __('profile.fields.address') }}
                                                        </strong></label>
                                                    <input type="text" class="form-control border-0 p-2" name="address"
                                                        value="{{ $user->info->address ?? '-' }}">
                                                    @error('address')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>
                                                            {{ __('profile.fields.postal_code') }} </strong></label>
                                                    <input type="text" class="form-control border-0 p-2"
                                                        name="postal_code" value="{{ $user->info->postal_code ?? '-' }}">
                                                    @error('postal_code')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>{{ __('profile.fields.province') }}</strong><br>
                                                <div class="info-card">
                                                    <select name="province" id="province" class="form-select" required>
                                                        <option value="{{ $user->info->province ?? '' }}">
                                                            {{ $user->info->province ?? __('profile.placeholders.province') }}
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>{{ __('profile.fields.city') }}</strong><br>
                                                <div class="info-card">
                                                    <select name="city" id="city" class="form-select" required>
                                                        <option value="{{ $user->info->city ?? '' }}">
                                                            {{ $user->info->city ?? __('profile.placeholders.city') }}
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><strong> {{ __('profile.fields.phone') }}
                                                </strong></label>
                                            <input type="text" class="form-control border-0 p-2" name="phone_num"
                                                value="{{ $user->phone_num }}">
                                            @error('phone_num')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button type="submit"
                                            class="btn btn-success">{{ __('profile.buttons.save') }}</button>

                                    </div>

                                    <!-- Right: Quotes Image -->
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('dashboard-assets/assets/img/Laporan-Quotes.png') }}"
                                            alt="Laporan Quotes" style="max-width: 100%;">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
