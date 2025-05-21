@extends('pengguna.partials.pengguna')

@section('title', 'Dashboard')

@section('content')
<main class="app-main">
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row page-title">
        <div class="col-sm-6"><h3 class="mb-0"><b>Dashboard Pengguna</b></h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        
        <div class="row">
            <div class="container my-4">
                <div class="card border-0 rounded-4 overflow-hidden" 
                    style="background: linear-gradient(90deg, #D5F5DC, #A9DFBF);">
                    <div class="row g-0 align-items-center">
                        <!-- Left content -->
                        <div class="col-md-8 px-5 py-4">
                            <h4 class="fw-bold">Hi, {{ $user->name ?? 'Username' }}!</h4>
                            <p class="mb-4 text-muted">Yuk buang sampahmu sekarang! Mulai dari diri sendiri untuk bumi yang bersih</p>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-success rounded-3">
                                    <i class="bi bi-trash"></i> Tukar Sampah
                                </a>
                                <a href="#" class="btn btn-outline-success rounded-3">
                                    Tarik Saldo
                                </a>
                            </div>
                        </div>

                        <!-- Right image -->
                        <div class="col-md-4 text-end pe-5">
                            <img src="{{ asset('dashboard-assets/assets/img/tree.png') }}" 
                                alt="Tree" class="img-fluid" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box card border-0 rounded-4 text-white overflow-hidden" 
                    style="background: linear-gradient(90deg, #006837, #A8E6A1);">
                    <div class="card-body position-relative p-4">
                        <h5 class="fw-semibold">Saldo</h5>
                        <img src="{{ asset('dashboard-assets/assets/img/LogoLong.png') }}" 
                            alt="Logo" class="position-absolute" 
                            style="top: 1rem; right: 1rem; height: 40px;">
                        <h3 class="fw-bold mt-4">Rp102.500,00</h3>
                        <p class="fw-semibold mb-0">User's Full Name</p>
                        <img src="{{ asset('dashboard-assets/assets/img/trees.png') }}" 
                            alt="Trees" class="position-absolute bottom-0 end-0" 
                            style="height: 70px; opacity: 0.9;">
                    </div>
                </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box card border-0 rounded-4 text-white overflow-hidden" 
                    style="background: linear-gradient(90deg, #006837, #A8E6A1);">
                    <div class="card-body position-relative p-4">
                        <h5 class="fw-semibold">Total Penarikan</h5>
                        <img src="{{ asset('dashboard-assets/assets/img/LogoLong.png') }}" 
                            alt="Logo" class="position-absolute" 
                            style="top: 1rem; right: 1rem; height: 40px;">
                        <h3 class="fw-bold mt-4">Rp50.500,00</h3>
                        <p class="fw-semibold mb-0">Minimal Penarikan Rp50.000</p>
                        <img src="{{ asset('dashboard-assets/assets/img/trees.png') }}" 
                            alt="Trees" class="position-absolute bottom-0 end-0" 
                            style="height: 70px; opacity: 0.9;">
                    </div>
                </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 recap">
                    <div class="card-header">
                        <h5 class="card-title">Rekapan Penukaran Sampah</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <!--begin::Row-->
                    <div class="row d-flex align-items-stretch">
                        <!-- Left Column -->
                        <div class="col-md-8 d-flex flex-column">
                            <div class="card p-3 shadow-sm h-100" style="border-radius: 1rem;">
                                <p class="text-center">
                                <strong>Jarak Waktu: 1 Jan, 2023 - 30 Jul, 2023</strong>
                                </p>
                                <div id="sales-chart" style="flex-grow: 1;"></div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4 d-flex flex-column">
                        <!-- Card 1 -->
                            <div class="card p-3 shadow-sm mb-4 borderrem recap-info">
                                <h5 class="text-center fw-bold mb-3">Legend Grafik</h5>

                                <div class="row text-center">
                                <div class="col-4 mb-2 d-flex align-items-center justify-content-center">
                                    <span class="me-2 card-point" style="background-color:rgb(240, 255, 247)"></span>
                                    <span>Kaleng</span>
                                </div>

                                <div class="col-4 mb-2 d-flex align-items-center justify-content-center">
                                    <span class="me-2 card-point"></span>
                                    <span>Plastik</span>
                                </div>

                                <div class="col-4 mb-2 d-flex align-items-center justify-content-center">
                                    <span class="me-2 card-point"></span>
                                    <span>Kertas</span>
                                </div>
                                
                                <div class="col-4 mb-2 d-flex align-items-center justify-content-center">
                                    <span class="me-2 card-point"></span>
                                    <span>Kaleng</span>
                                </div>

                                <div class="col-4 mb-2 d-flex align-items-center justify-content-center">
                                    <span class="me-2 card-point"></span>
                                    <span>Plastik</span>
                                </div>

                                <div class="col-4 mb-2 d-flex align-items-center justify-content-center">
                                    <span class="me-2 card-point"></span>
                                    <span>Kertas</span>
                                </div>
                                </div>
                            </div>



                            <!-- Card 2 -->
                            <div class="card p-3 shadow-sm borderrem recap-info">
                                <h5 class="text-center fw-bold mb-3">Statistik Bulanan</h5>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="me-2 card-point"></span>
                                    <span>Pengguna Aktif</span>
                                </div>
                                <span class="fw-bold text-dark">1,200</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="me-2 card-point"></span>
                                    <span>Jenis Sampah Terbanyak</span>
                                </div>
                                <span class="fw-bold text-dark">Organik</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="me-2 card-point"></span>
                                    <span>Total Transaksi</span>
                                </div>
                                <span class="fw-bold text-dark">560</span>
                                </div>
                                <div class="d-flex justify-content-center topborder">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary">
                                        Unduh Laporan Bulanan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Row-->
                    </div>
                    <!-- ./card-body -->
                </div>
            <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
    <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->
</main>
@endsection