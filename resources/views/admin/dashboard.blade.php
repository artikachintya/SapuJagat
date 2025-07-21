@extends('admin.partials.admin')

@section('Admin Dashboard', 'Dashboard')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row page-title">
                    <div class="col-sm-6">
                        <h3 class="mb-0"><b>Welcome,</b> <i>{{ Auth::check() ? Auth::user()->name : 'Admin' }}</i></h3>
                    </div>
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
                                    {{$todayTransactions}}
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
                                    {{$totalMoneyOut}}
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
                                    {{$processedTransactions}}
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
                                                    <span>Pengguna Aktif</span>
                                                </div>
                                                <span class="fw-bold text-dark">{{$activeUserCount}}</span>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 card-point"></span>
                                                    <span>Jenis Sampah Terbanyak</span>
                                                </div>
                                                <span class="fw-bold text-dark">{{ $mostOrderedTrash->name ?? '-' }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 card-point"></span>
                                                    <span>Total Transaksi</span>
                                                </div>
                                                <span class="fw-bold text-dark">{{$totalTransactions}}</span>
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
                                    {{-- Total Trash In (Sampah Masuk) --}}
                                    <div class="col-md-3 col-6">
                                        <div class="text-center border-end">
                                            @php $value = $trashKgDiffPercent; @endphp
                                            @if($value !== null)
                                                @if($value > 0)
                                                    <span class="text-success"><i class="bi bi-caret-up-fill"></i>
                                                        {{ number_format($value, 2) }}%</span>
                                                @elseif($value < 0)
                                                    <span class="text-danger"><i class="bi bi-caret-down-fill"></i>
                                                        {{ number_format(abs($value), 2) }}%</span>
                                                @else
                                                    <span class="text-muted"><i class="bi bi-dot"></i> 0%</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                            <h5 class="fw-bold mb-0">{{ $totalTrashKg }}<small>KG</small></h5>
                                            <span class="text-uppercase">SAMPAH MASUK</span>
                                        </div>
                                    </div>

                                    {{-- Total Money Out --}}
                                    <div class="col-md-3 col-6">
                                        <div class="text-center border-end">
                                            @php $value = $moneyOutDiffPercent; @endphp
                                            @if($value !== null)
                                                @if($value > 0)
                                                    <span class="text-success"><i class="bi bi-caret-up-fill"></i>
                                                        {{ number_format($value, 2) }}%</span>
                                                @elseif($value < 0)
                                                    <span class="text-danger"><i class="bi bi-caret-down-fill"></i>
                                                        {{ number_format(abs($value), 2) }}%</span>
                                                @else
                                                    <span class="text-muted"><i class="bi bi-dot"></i> 0%</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                            <h5 class="fw-bold mb-0"><small>RP</small>{{ $totalMoneyOutMonth }}</h5>
                                            <span class="text-uppercase">TOTAL PENGELUARAN</span>
                                        </div>
                                    </div>

                                    {{-- Active Drivers --}}
                                    <div class="col-md-3 col-6">
                                        <div class="text-center border-end">
                                            @php $value = $driverDiffPercent; @endphp
                                            @if($value !== null)
                                                @if($value > 0)
                                                    <span class="text-success"><i class="bi bi-caret-up-fill"></i>
                                                        {{ number_format($value, 2) }}%</span>
                                                @elseif($value < 0)
                                                    <span class="text-danger"><i class="bi bi-caret-down-fill"></i>
                                                        {{ number_format(abs($value), 2) }}%</span>
                                                @else
                                                    <span class="text-muted"><i class="bi bi-dot"></i> 0%</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                            <h5 class="fw-bold mb-0">{{ $activeDrivers }}<small>ORANG</small></h5>
                                            <span class="text-uppercase">PENGEMUDI BULAN INI</span>
                                        </div>
                                    </div>

                                    {{-- Active Users --}}
                                    <div class="col-md-3 col-6">
                                        <div class="text-center">
                                            @php $value = $userDiffPercent; @endphp
                                            @if($value !== null)
                                                @if($value > 0)
                                                    <span class="text-success"><i class="bi bi-caret-up-fill"></i>
                                                        {{ number_format($value, 2) }}%</span>
                                                @elseif($value < 0)
                                                    <span class="text-danger"><i class="bi bi-caret-down-fill"></i>
                                                        {{ number_format(abs($value), 2) }}%</span>
                                                @else
                                                    <span class="text-muted"><i class="bi bi-dot"></i> 0%</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                            <h5 class="fw-bold mb-0">{{ $activeUserCount }}<small>ORANG</small></h5>
                                            <span class="text-uppercase">PENGGUNA BULAN INI</span>
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
                                            @foreach($latestOrders as $order)
                                                <tr>
                                                    <td>{{ $order->order_id }}</td>
                                                    <td>{{ $order->date_time_request }}</td>
                                                    <td>{{ $order->user->name ?? '-' }}</td>
                                                    <td>{{ $order->pickup->user->name ?? '-' }}</td>
                                                    <td>
                                                        @foreach($order->details as $detail)
                                                            {{ $detail->trash->name ?? '-' }}
                                                            @if(!$loop->last), @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @php
                                                            $status = $order->approval->approval_status ?? null;
                                                        @endphp

                                                        @if($status === 1)
                                                            <span class="badge text-bg-success">Shipped</span>
                                                        @elseif($status === 0)
                                                            <span class="badge text-bg-warning">Pending</span>
                                                        @else
                                                            <span class="badge text-bg-secondary">No Status</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix d-flex justify-content-center">
                                <a href="{{ route('admin.histori.index') }}" class="btn btn-sm btn-secondary">
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
                                    @foreach($pendingApprovals as $order)
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-start bg-light mb-2 mx-2 rounded">
                                            <div>
                                                <strong>{{ \Carbon\Carbon::parse($order->date_time_request)->format('d-m-y : H-i') }}</strong><br>
                                                <em class="text-success">
                                                    @if(optional($order->approval)->approval_status === 0)
                                                        Unapproved
                                                    @else
                                                        No Approval
                                                    @endif
                                                </em>
                                            </div>

                                            <div>
                                                <small>
                                                    Order ID : {{ $order->order_id }}<br>
                                                    Jenis :
                                                    @foreach($order->details as $detail)
                                                        {{ $detail->trash->name ?? '-' }}@if(!$loop->last), @endif
                                                    @endforeach
                                                    <br>
                                                    Pengguna : {{ $order->user->name ?? '-' }}
                                                </small>
                                            </div>

                                            <div class="text-end">
                                                @if($order->approval)
                                                    <strong>{{ \Carbon\Carbon::parse($order->approval->date_time)->format('d-m-y') }}</strong><br>
                                                    <small>{{ \Carbon\Carbon::parse($order->approval->date_time)->format('H-i') }}<br>Waktu
                                                        Selesai</small>
                                                @else
                                                    <strong>Belum Selesai</strong><br>
                                                    <small>-<br>-</small>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Footer button -->
                            <div class="card-footer text-center bg-success text-white fw-bold hover-pointer"
                                onclick="window.location='{{ route('admin.persetujuan.index') }}'">
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

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = @json($dates);
            const rawDatasets = @json($chartSeries);

            const datasets = rawDatasets.map(item => ({
                label: item.label,
                data: item.data,
                fill: false,
                borderColor: item.borderColor,
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
                            display: false
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
                            max: 500,
                            ticks: {
                                stepSize: 5
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