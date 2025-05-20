@extends('admin.partials.admin')

@section('title', 'Dashboard')

@section('content')
<main class="app-main">
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row page-title">
        <div class="col-sm-6"><h3 class="mb-0"><b>Welcome,</b> <i>Nama User</i></h3></div>
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
    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon text-bg-primary shadow-sm">
            <i class="bi bi-arrow-left-right"></i>
            </span>
            <div class="info-box-content">
            <span class="info-box-text">Penukaran Hari Ini</span>
            <span class="info-box-number">
                240
                <small>Transaksi</small>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon text-bg-primary shadow-sm">
            <i class="bi bi-cash"></i>
            </span>
            <div class="info-box-content">
            <span class="info-box-text">Uang Keluar</span>
            <span class="info-box-number">
                <small>Rp</small>
                100,000
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- fix for small devices only -->
        <!-- <div class="clearfix hidden-md-up"></div> -->
        <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon text-bg-primary shadow-sm">
            <i class="bi bi-recycle"></i>
            </span>
            <div class="info-box-content">
            <span class="info-box-text">Pesanan Diproses</span>
            <span class="info-box-number">
                15
                <small>Pesanan</small>
            </span>
            </div>
            <!-- /.info-box-content -->
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
            <h5 class="card-title">Rekapan Jenis Sampah Bulanan</h5>
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
                </div>
                </div>
            </div>

            <!--end::Row-->
            </div>
            <!-- ./card-body -->
            <div class="card-footer">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-2 col-6">
                <div class="text-center border-end">
                    <span class="text-success">
                    <i class="bi bi-caret-up-fill"></i> 17%
                    </span>
                    <h5 class="fw-bold mb-0">7000<small>KG</small></h5>
                    <span class="text-uppercase">SAMPAH MASUK</span>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-md-2 col-6">
                <div class="text-center border-end">
                    <span class="text-info"> <i class="bi bi-caret-left-fill"></i> 0% </span>
                    <h5 class="fw-bold mb-0"><small>RP</small>7,000,000</h5>
                    <span class="text-uppercase">TOTAL PENGELUARAN</span>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-md-2 col-6">
                <div class="text-center border-end">
                    <span class="text-success">
                    <i class="bi bi-caret-up-fill"></i> 20%
                    </span>
                    <h5 class="fw-bold mb-0">7000<small>KG</small></h5>
                    <span class="text-uppercase">SAMPAH KELUAR</span>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-6">
                <div class="text-center border-end">
                    <span class="text-danger">
                    <i class="bi bi-caret-down-fill"></i> 18%
                    </span>
                    <h5 class="fw-bold mb-0">21<small>ORANG</small></h5>
                    <span class="text-uppercase">PENGEMUDI BULAN INI</span>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-6">
                <div class="text-center">
                    <span class="text-danger">
                    <i class="bi bi-caret-down-fill"></i> 18%
                    </span>
                    <h5 class="fw-bold mb-0">21<small>ORANG</small></h5>
                    <span class="text-uppercase">PENGEMUDI BULAN INI</span>
                </div>
                </div>
            </div>
            <!--end::Row-->
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!--end::Row-->
    <!--begin::Row-->
    <div class="row">
        <!-- Start col -->
        <div class="col-md-7">
        <!--begin::Histori Transaksi Widget-->
        <div class="card history">
            <div class="card-header">
            <h3 class="card-title">Histori Transaksi</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                <thead>
                    <tr>
                    <th>Order ID</th>
                    <th>Waktu & Tanggal</th>
                    <th>Pengguna</th>
                    <th>Penjemput</th>
                    <th>Tipe Sampah</th>
                    <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>OD001</td>
                    <td>2025-05-19 : 20-12</td>
                    <td>Nama Pengguna</td>
                    <td>Nama Penjemput</td>
                    <td>Kaleng</td>
                    <td><span class="badge text-bg-success"> Shipped </span></td>
                    </tr>
                    <tr>
                    <td>OD002</td>
                    <td>2025-05-19 : 20-12</td>
                    <td>Nama Pengguna</td>
                    <td>Nama Penjemput</td>
                    <td>Kaleng</td>
                    <td><span class="badge text-bg-success"> Shipped </span></td>
                    </tr>
                    <tr>
                    <td>OD003</td>
                    <td>2025-05-19 : 20-12</td>
                    <td>Nama Pengguna</td>
                    <td>Nama Penjemput</td>
                    <td>Kaleng</td>
                    <td><span class="badge text-bg-success"> Shipped </span></td>
                    </tr>
                    <tr>
                    <td>OD004</td>
                    <td>2025-05-19 : 20-12</td>
                    <td>Nama Pengguna</td>
                    <td>Nama Penjemput</td>
                    <td>Kaleng</td>
                    <td><span class="badge text-bg-success"> Shipped </span></td>
                    </tr>
                    <tr>
                    <td>OD005</td>
                    <td>2025-05-19 : 20-12</td>
                    <td>Nama Pengguna</td>
                    <td>Nama Penjemput</td>
                    <td>Kaleng</td>
                    <td><span class="badge text-bg-success"> Shipped </span></td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix d-flex justify-content-center">
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary">
                Lihat Semua Histori
            </a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
        </div>

        <!-- /.col -->
        <div class="col-md-5">
        <!-- PRODUCT LIST -->
        <div class="card approval">
            <div class="card-header">
            <h3 class="card-title">Tugas Persetujuan</h3>
            </div>
            <!-- /.card-header -->
            <!-- Scrollable content -->
            <div class="card-body p-0" style="max-height: 250px; overflow-y: auto;">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-start bg-light mb-2 mx-2 rounded">
                <div>
                    <strong>25-12-20 : 21-45</strong><br>
                    <em class="text-success">Unapproved</em>
                </div>
                <div>
                    <small>Order ID : 0012<br>Jenis : Besi<br>Pengguna : Admad</small>
                </div>
                <div class="text-end">
                    <strong>25-11-10</strong><br><small>20-15<br>Waktu Selesai</small>
                </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start bg-light mb-2 mx-2 rounded">
                <div>
                    <strong>25-12-20 : 21-45</strong><br>
                    <em class="text-success">Unapproved</em>
                </div>
                <div>
                    <small>Order ID : 0012<br>Jenis : Besi<br>Pengguna : Admad</small>
                </div>
                <div class="text-end">
                    <strong>25-11-10</strong><br><small>20-15<br>Waktu Selesai</small>
                </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start bg-light mb-2 mx-2 rounded">
                <div>
                    <strong>25-12-20 : 21-45</strong><br>
                    <em class="text-success">Unapproved</em>
                </div>
                <div>
                    <small>Order ID : 0012<br>Jenis : Besi<br>Pengguna : Admad</small>
                </div>
                <div class="text-end">
                    <strong>25-11-10</strong><br><small>20-15<br>Waktu Selesai</small>
                </div>
                </li>
            </ul>
            </div>

            <!-- Footer button -->
            <div class="card-footer text-center bg-success text-white fw-bold">
            Approve/Deny
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->
</main>
@endsection