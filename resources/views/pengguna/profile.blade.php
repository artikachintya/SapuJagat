@extends('pengguna.partials.pengguna')

@section('title', 'Profile Pengguna')

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <style>
        .info-card {
            background: white;
            padding: 10px 15px;
            margin-bottom: 12px;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        .profile-box {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush
{{--
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row page-title">
                    <div class="col-sm-6">
                        <h3 class="mb-0"><b>Profile</b></h3>
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content Header-->

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="container my-2">
                        <div class="card card-report mb-4">
                            <!-- Card Header -->
                            <div class="card-header">
                                <div class="card-title">
                                    <b>Profile Pengguna</b>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body row">
                                <!-- Left Column (Will contain profile fields) -->
                                <div class="col-md-8">
                                    <!-- Profile fields will go here -->
                                    <div class="profile-section">
                                        <!-- Example single field structure -->
                                        <div class="mb-3 field-container">
                                            <form action="/profile" method="POST">
                                                @csrf


                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column (Profile picture and quotes) -->
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard-assets/assets/img/Laporan-Quotes.png') }}"
                                        alt="Laporan Quotes" style="max-width: 100%;">
                                </div>
                            </div>
                            <!--end::Card Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection --}}

{{--
@section('content')
<main class="app-main">
    <!-- Header Section -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><b>Profile Saya</b></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-report">
                        <!-- Card Header -->
                        <div class="card-header">
                            <div class="card-title">
                                <b>Informasi Profil</b>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body row">
                            <!-- Left Column - Profile Info -->
                            <div class="col-md-8">
                                <div class="profile-info">
                                    <div class="info-item">
                                        <div class="info-label">Nama Lengkap</div>
                                        <div class="info-value">{{ Auth::user()->name ?? 'Nama Pengguna' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">NIK</div>
                                        <div class="info-value">{{ Auth::user()->NIK ?? '-' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">Email</div>
                                        <div class="info-value">{{ Auth::user()->email ?? '-' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">Alamat</div>
                                        <div class="info-value">{{ Auth::user()->info->address ?? '-' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">Provinsi</div>
                                        <div class="info-value">{{ Auth::user()->info->province ?? '-' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">Nomor Telepon</div>
                                        <div class="info-value">{{ Auth::user()->phone_num ? '+62 ' . Auth::user()->phone_num : '-' }}</div>
                                    </div>

                                    <a href="{{ route('pengguna.profile.update') }}" class="btn btn-report edit-btn">
                                        <i class="fas fa-edit me-2"></i> Edit Profil
                                    </a>
                                </div>
                            </div>

                            <!-- Right Column - Profile Picture & Quotes -->
                            <div class="col-md-4 text-center">
                                <div class="mb-4">
                                    <img src="{{ Auth::user()->profile_picture ?? asset('images/default-profile.png') }}"
                                         alt="Profile Picture"
                                         class="profile-picture">
                                </div>
                                <div class="profile-quotes mt-4">
                                    <p class="fw-bold mb-0">EVERY PIECE OF PLASTIC</p>
                                    <p class="mb-0">(EVER MADE STILL)</p>
                                    <p>EXISTS TODAY</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection --}}

@section('content')
    <main class="app-main">
        <!-- Header Section -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0"><b>Profile Saya</b></h3>
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
                                        {{-- <img src="{{ $user->profile_pic ?? url('assets/img/default-profile.webp') }}"
                                            alt="Profile Picture" class="profile-picture mt-3"> --}}
                                        <img src="{{ asset('storage/' . $user->profile_pic) ?? url('assets/img/default-profile.webp') }}"
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

                                    <strong>Alamat</strong><br>
                                    <div class="info-card">
                                        {{ $user->info->address ?? '-' }}
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Kota</strong><br>
                                            <div class="info-card">
                                                {{ $user->info->city ?? '-' }}
                                            </div>

                                        </div>
                                        <div class="col-md-4">

                                            <strong>Provinsi</strong><br>
                                            <div class="info-card">
                                                {{ $user->info->province ?? '-' }}
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



                                <!-- Right: Profile Picture -->
                                {{-- <div class="col-md-4 text-center">
                                    <img src="{{ Auth::user()->profile_pic ?? url('assets/img/default-profile.webp') }}"
                                        alt="Profile Picture" class="profile-picture mt-3">
                                </div> --}}

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
        </div>
    </main>
@endsection
