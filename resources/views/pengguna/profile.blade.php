@extends('pengguna.partials.pengguna')

@section('title', 'Profile Pengguna')

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/profile.css') }}" rel="stylesheet">
@endpush

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

@section('content')
    <main class="app-main">
        <!-- Header Section -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0"><b>{{__('profile.header.user_title')}}</b></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                         @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card card-report p-4">
                            <!-- Card Title -->
                            <div class="card-title mb-4">
                                <h5><b>{{ __('profile.header.pengguna') }}</b></h5>
                            </div>

                            <!-- Content Body -->
                            <div class="row">
                                <!-- Left: Profile Info -->
                                <div class="col-md-8">
                                    <div class="profil-pic mb-3 d-flex justify-content-center">
                                        <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('assets/img/default-profile.webp') }}"
                                            alt="Profile Picture" class="profile-picture mt-3">

                                    </div>
                                    <br><strong>{{ __('profile.fields.full_name') }}</strong><br>
                                    <div class="info-card">
                                        {{ $user->name ?? '-' }}
                                    </div>

                                    <strong>{{ __('profile.fields.nik') }}</strong><br>
                                    <div class="info-card">
                                        {{ $user->NIK ?? '-' }}
                                    </div>

                                    <strong>{{ __('profile.fields.email') }}</strong><br>
                                    <div class="info-card">
                                        {{ $user->email ?? '-' }}
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <strong>{{ __('profile.fields.address') }}</strong><br>
                                            <div class="info-card">
                                                {{ $user->info->address ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>{{ __('profile.fields.postal_code') }}</strong><br>
                                            <div class="info-card">
                                                {{ $user->info->postal_code ?? '-' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>{{ __('profile.fields.province') }}</strong><br>
                                            <div class="info-card">
                                                {{ $user->info->province ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>{{ __('profile.fields.city') }}</strong><br>
                                            <div class="info-card">
                                                {{ $user->info->city ?? '-' }}
                                            </div>

                                        </div>

                                    </div>

                                    <strong>{{ __('profile.fields.phone') }}</strong><br>
                                    <div class="info-card">
                                        {{ $user->phone_num ? '+62 ' . $user->phone_num : '-' }}
                                    </div>

                                    <a href="{{ route('pengguna.profile.edit') }}" class="btn btn-success mt-3">
                                        <i class="fas fa-edit me-2"></i>{{ __('profile.edit') }}
                                    </a>
                                </div>


                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard-assets/assets/img/Laporan-Quotes.png') }}"
                                        alt="Laporan Quotes" style="max-width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
