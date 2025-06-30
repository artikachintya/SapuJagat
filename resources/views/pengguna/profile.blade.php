@extends('pengguna.partials.pengguna')

@section('title', 'Profile Pengguna')

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/profile.css') }}" rel="stylesheet">
@endpush

@section('content')
    <main class="app-main">
        <!-- Header Section -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0"><b>Profile Pengguna</b></h3>
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
                                <h5><b>Informasi Profil</b></h5>
                            </div>

                            <!-- Content Body -->
                            <div class="row">
                                <!-- Left: Profile Info -->
                                <div class="col-md-8">
                                    <div class="profil-pic mb-3 d-flex justify-content-center">
                                        <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('assets/img/default-profile.webp') }}"
                                            alt="Profile Picture" class="profile-picture mt-3">

                                    </div>
                                    <br><strong>Nama Lengkap</strong><br>
                                    <div class="info-card">
                                        {{ $user->name ?? '-' }}
                                    </div>

                                    <strong>NIK</strong><br>
                                    <div class="info-card">
                                        {{ $user->NIK ?? '-' }}
                                    </div>

                                    <strong>Email</strong><br>
                                    <div class="info-card">
                                        {{ $user->email ?? '-' }}
                                    </div>

                                    {{-- <strong>Password</strong><br>
                                    <div class="info-card">
                                        {{ $user->password ?? '-' }}
                                    </div> --}}

                                    <div class="row">
                                        <div class="col-md-8">
                                            <strong>Alamat</strong><br>
                                            <div class="info-card">
                                                {{ $user->info->address ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Kode Pos</strong><br>
                                            <div class="info-card">
                                                {{ $user->info->postal_code ?? '-' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Provinsi</strong><br>
                                            <div class="info-card">
                                                {{ $user->info->province ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Kota</strong><br>
                                            <div class="info-card">
                                                {{ $user->info->city ?? '-' }}
                                            </div>

                                        </div>

                                    </div>

                                    <strong>Nomor Telepon</strong><br>
                                    <div class="info-card">
                                        {{ $user->phone_num ? '+62 ' . $user->phone_num : '-' }}
                                    </div>

                                    <a href="{{ route('pengguna.profile.edit') }}" class="btn btn-success mt-3">
                                        <i class="fas fa-edit me-2"></i>Edit Profil
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
