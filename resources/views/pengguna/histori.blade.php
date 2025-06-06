@extends('pengguna.partials.pengguna')

@section('title', 'Histori Penukaran')

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/histori-user.js') }}"></script>
@endpush

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <h3 class="mb-0"><b>Daftar Histori</b></h3>
            </div>
            <!--end::Container-->
        </div>
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <div class="container my-4">
                    <div class="card card-light mb-4">
                        {{-- begin::header --}}
                        <div class="card-header">
                            <div class="card-title">
                                <b>
                                    @if (session('success'))
                                        {{ session('success') }}
                                    @else
                                        Histori Penukaran {{ Auth::check() ? Auth::user()->name : 'Pengguna' }}
                                    @endif
                                </b>
                            </div>
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body row">
                            <div class="card-body row">
                                <!-- Left: Form -->
                                <div class="col-md-12">
                                    {{-- for each --}}
                                    {{-- <pre>{{ dd($orderlist[0]) }}</pre> --}}

                                    @foreach ($orderlist as $order)
                                        <div class="mb-3 p-3 rounded"
                                            style="background-color: #f9fdf9; border: 1px solid #d4ecd4;">
                                            <div class="d-flex justify-content-between align-items-start mb-2">

                                                @php
                                                    if (is_null($order->status)) {
                                                        $badgeClass = 'bg-secondary';
                                                        $label = 'Dalam Proses'; // or any label you want
                                                    } elseif ($order->status) {
                                                        $badgeClass = 'bg-success';
                                                        $label = 'Sukses';
                                                    } else {
                                                        $badgeClass = 'bg-danger';
                                                        $label = 'Gagal';
                                                    }

                                                    $htmlSummary = '<table class="table table-bordered text-sm"><thead><tr>
                                                        <th>No</th><th>Nama Sampah</th><th>Kuantitas</th><th>Harga/kg</th><th>Total</th>
                                                    </tr></thead><tbody>';
                                                    $total = 0;
                                                    foreach ($order->details as $index => $detail) {
                                                        $qty = $detail->quantity;
                                                        $price = $detail->trash->price_per_kg;
                                                        $subtotal = $qty * $price;
                                                        $total += $subtotal;
                                                        $htmlSummary .= "<tr>
                                                            <td>".($index+1)."</td>
                                                            <td>{$detail->trash->name}</td>
                                                            <td>{$qty}</td>
                                                            <td>Rp. ".number_format($price, 0, ',', '.')."</td>
                                                            <td>Rp. ".number_format($subtotal, 0, ',', '.')."</td>
                                                        </tr>";
                                                    }
                                                    $htmlSummary .= "<tr><td colspan='4'><b>Total yang Diperoleh</b></td>
                                                        <td><b>Rp. ".number_format($total, 0, ',', '.')."</b></td></tr>";
                                                    $htmlSummary .= '</tbody></table>';
                                                @endphp


                                                <span class="badge {{ $badgeClass }}">
                                                    {{ $label }}
                                                </span>
                                                <span class="fw-semibold text-success">
                                                    @if ($order->status){
                                                        Rp{{ number_format(
                                                            $order->details->sum(function ($detail) {
                                                                return $detail->quantity * $detail->trash->price_per_kg;
                                                            }),
                                                            0,
                                                            ',',
                                                            '.',
                                                        ) }}
                                                    }
                                                    @else Rp0
                                                    @endif
                                                </span>

                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="text-muted">
                                                        {{ \Carbon\Carbon::parse($order->date_time_request)->translatedFormat('l, d M Y') }}
                                                    </div>
                                                    <div class="text-success fw-semibold text-truncate"
                                                        style="max-width: 250px;">
                                                        @php
                                                            $trashNames = $order->details
                                                                ->pluck('trash.name')
                                                                ->unique()
                                                                ->toArray();
                                                            $trashSummary = implode(', ', $trashNames);
                                                        @endphp
                                                        {{ $trashSummary }}
                                                    </div>
                                                </div>
                                                <button class="btn btn-outline-success lihat-detail-btn"
                                                data-date="{{ \Carbon\Carbon::parse($order->date_time_request)->translatedFormat('l, d M Y') }}"
                                                data-address="{{ $order->user->info->address }}, {{ $order->user->info->city }}, {{ $order->user->info->province }}, {{ $order->user->info->postal_code }}"
                                                data-driver="{{ $order->pickup->user->name }}"
                                                data-summary="{!! htmlspecialchars($htmlSummary) !!}">
                                                    Lihat Detail
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- end for each --}}
                                </div>

                                {{-- POP UP DETAIL --}}
                                <div id="historiModal" class="modal-overlay" style="display: none;">
                                    <div class="modal-content">
                                        <div cla ss="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <span class="badge bg-success mb-1" id="modal-status">Selesai</span><br>
                                                <strong>Hari/Tgl: <span id="modal-date"></span></strong><br>
                                                <strong>Alamat: <span id="modal-address"></span></strong><br>
                                                <strong>Pengemudi: <span id="modal-driver"></span></strong><br>
                                            </div>
                                            <button class="close-btn btn btn-sm btn-light"
                                                style="font-size: 1.25rem; line-height: 1; padding: 0 10px;">&times;</button>
                                        </div>

                                        <div>
                                            <h6>Ringkasan Penukaran</h6>
                                            <div class="bg-light p-2 mb-2" id="modal-summary"></div>
                                        </div>
                                        {{-- <div>
                                        <h6>Foto Bukti</h6>
                                        <img id="modal-photo" src="" alt="Foto Bukti" class="img-fluid mb-2" />
                                        <div class="bg-light p-2" id="photo-none"></div>
                                    </div> --}}
                                        {{-- <div>
                                        <h6> - <b id="response-time"></b></h6>
                                        <div class="bg-light p-2" id="modal-response"></div>
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    </div>
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
    </main>
@endsection
