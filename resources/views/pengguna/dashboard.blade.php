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
                    <div class="col-sm-6">
                        <h3 class="mb-0"><b>Dashboard Pengguna</b></h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{route('pengguna.dashboard')}}">Home</a></li>
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
                                    <h4 class="fw-bold">Hi, {{ Auth::check() ? Auth::user()->name : 'User' }}!</h4>
                                    <p class="mb-4 text-muted">Yuk buang sampahmu sekarang! Mulai dari diri sendiri untuk
                                        bumi yang bersih</p>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('pengguna.tukar-sampah.index') }}" class="btn btn-success rounded-3">
                                            <i class="bi bi-trash"></i> Tukar Sampah
                                        </a>
                                        <a href="{{ route('pengguna.tarik-saldo.index') }}" class="btn btn-outline-success rounded-3">
                                            Tarik Saldo
                                        </a>
                                    </div>
                                </div>

                                <!-- Right image -->
                                <div class="col-md-4 text-end pe-5">
                                    <img src="{{ asset('dashboard-assets/assets/img/tree.png') }}" alt="Tree"
                                        class="img-fluid" style="max-height: 200px;">
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
                                <img src="{{ asset('dashboard-assets/assets/img/LogoLong.png') }}" alt="Logo"
                                    class="position-absolute" style="top: 1rem; right: 1rem; height: 40px;">
                                <h3 class="fw-bold mt-4">Rp{{$totalBalance}}</h3>
                                <p class="fw-semibold mb-0">{{ Auth::check() ? Auth::user()->name : 'User' }}'s Balance</p>
                                <img src="{{ asset('dashboard-assets/assets/img/trees.png') }}" alt="Trees"
                                    class="position-absolute bottom-0 end-0" style="height: 70px; opacity: 0.9;">
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
                                <img src="{{ asset('dashboard-assets/assets/img/LogoLong.png') }}" alt="Logo"
                                    class="position-absolute" style="top: 1rem; right: 1rem; height: 40px;">
                                <h3 class="fw-bold mt-4">Rp{{$monthlyWithdrawals}}</h3>
                                <p class="fw-semibold mb-0">Minimal Penarikan Rp50.000</p>
                                <img src="{{ asset('dashboard-assets/assets/img/trees.png') }}" alt="Trees"
                                    class="position-absolute bottom-0 end-0" style="height: 70px; opacity: 0.9;">
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
                                            <p class="text-center"><strong>Jarak Waktu: {{ $start }} - {{ $end }}</strong>
                                            </p>
                                            <div class="chart-container mt-2">
                                                <canvas id="sales-chart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-4 d-flex flex-column">
                                        <!-- Card 1 -->
                                        <div class="card p-3 shadow-sm mb-4 borderrem recap-info" style="margin-top: 16px;">
                                            <h5 class="text-center fw-bold mb-3">Legend Grafik</h5>
                                            <div class="legend-grid">
                                                @foreach ($trashColors as $trashName => $color)
                                                    <div class="legend-item">
                                                        <span class="legend-circle"
                                                            style="background-color: {{ $color }};"></span>
                                                        <span class="legend-label">{{ $trashName }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Card 2 -->
                                        <div class="card p-3 shadow-sm borderrem recap-info">
                                            <h5 class="text-center fw-bold mb-3">Statistik Bulanan</h5>

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 card-point"></span>
                                                    <span>Transaksi menunggu</span>
                                                </div>
                                                <span class="fw-bold text-dark">{{$unapprovedOrdersCount}}</span>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 card-point"></span>
                                                    <span>Jenis Sampah Terbanyak</span>
                                                </div>
                                                <span class="fw-bold text-dark">{{$topTrashName}}</span>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 card-point"></span>
                                                    <span>Transaksi Disetujui</span>
                                                </div>
                                                <span class="fw-bold text-dark">{{$approvedOrdersCount}}</span>
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
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = @json($labels);
            const rawDatasets = @json($chartSeries);

            // Buat datasets sesuai format Chart.js
            const datasets = rawDatasets.map(item => ({
                label: item.label,
                data: item.data,
                fill: false,
                borderColor: item.backgroundColor, // warna dari controller
                tension: 0.3
            }));

            const config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Nonaktifkan legend di atas grafik
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    stacked: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100, // <= TAMBAHKAN INI untuk memaksa skala Y sampai 10
                            ticks: {
                                stepSize: 1 // (opsional) biar rapi: 0,1,2,...,10
                            }
                        }
                    }
                }
            };

            const myChart = new Chart(document.getElementById('sales-chart'), config);
            window.addEventListener('resize', function () {
                myChart.resize();
            });

        </script>
    @endpush

@endsection