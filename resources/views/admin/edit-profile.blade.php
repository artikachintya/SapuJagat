@extends('admin.partials.admin')

@section('title', 'Profile Admin')

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/edit-profile.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <!-- External libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
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

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

@section('content')
    <main class="app-main">
        <!-- Main Content -->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-report p-4">
                            <!-- Card Title -->
                            <div class="card-title mb-4">
                                <h5><b>{{ __('profile.edit_title') }}</b></h5>
                            </div>

                            <form action="{{ route('admin.profile.save') }}" method="POST" id="bautai"
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
                                        <div class="mb-3">
                                            <label class="form-label"><strong> {{__('profile.fields.full_name')}} </strong></label>
                                            <input type="text" class="form-control border-0 p-2" name="name"
                                                value="{{ $user->name }}">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong> {{__('profile.fields.nik')}} </strong></label>
                                            <input type="text" class="form-control border-0 p-2" name="NIK"
                                                value="{{ $user->NIK }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong> {{__('profile.fields.email')}} </strong></label>
                                            <input type="email" class="form-control border-0 p-2" name="email"
                                                value="{{ $user->email }}" disabled>
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong> {{__('profile.fields.password')}} </strong></label>
                                            <input type="password" class="form-control border-0 p-2" name="password"
                                                id="password" placeholder="********">
                                            @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong> {{__('profile.fields.phone')}} </strong></label>
                                            <input type="text" class="form-control border-0 p-2" name="phone_num"
                                                value="{{ $user->phone_num }}">
                                            @error('phone_num')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-success">{{__('profile.buttons.save')}}</button>
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

