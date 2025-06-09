@extends('driver.partials.driver')

@section('title', 'Histori Penjemputan')

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <style>
        .card-report {
            background-image: url('../img/custom-background.jpg') !important;
            background-size: cover !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/histori-driver.js') }}"></script>
@endpush

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        {{-- <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <h3 class="mb-0"><b>Daftar Histori</b></h3>
            </div>
            <!--end::Container-->
        </div> --}}
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
                        <div class="card-body row d-flex justify-content-center">
                            <div class="card-body row">
                                <!-- Left: Form -->
                                <div class="col-md-12">
                                    {{-- for each --}}
                                    {{-- <pre>{{ dd($orderlist[0]) }}</pre> --}}
                                    @if ($pickuplist->count())
                                        @foreach ($pickuplist as $pickup)
                                            <div class="mb-3 p-3 rounded"
                                                style="background-color: #f9fdf9; border: 1px solid #d4ecd4;">
                                                <div class="d-flex justify-content-between align-items-start mb-2">

                                                    @php
                                                        if (!$pickup->pick_up_date) {
                                                            $badgeClass = 'bg-secondary';
                                                            $label = 'Menunggu';
                                                        } elseif (!$pickup->pick_up_date) {
                                                            $badgeClass = 'bg-secondary';
                                                            $label = 'Dalam Penjemputan'; // or any label you want
                                                        } elseif (!$pickup->arrival_date) {
                                                            $badgeClass = 'bg-warning';
                                                            $label = 'Dalam Pengantaran';
                                                        } elseif ($pickup->arrival_date) {
                                                            $badgeClass = 'bg-success';
                                                            $label = 'Selesai';
                                                        } else {
                                                            $badgeClass = 'bg-secondary';
                                                            $label = 'Menunggu';
                                                        }

                                                    @endphp


                                                    <span class="badge {{ $badgeClass }}">
                                                        {{ $label }}
                                                    </span>

                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        @if ($pickup->arrival_date)
                                                            <div class="text-muted">
                                                                {{ \Carbon\Carbon::parse($pickup->arrival_date)->translatedFormat('l, d M Y') }}
                                                            </div>
                                                        @endif
                                                        <div class="text-success fw-semibold text-truncate"
                                                            style="max-width: 75%;">
                                                            {{-- @php
                                                            $trashNames = $order->details
                                                                ->pluck('trash.name')
                                                                ->unique()
                                                                ->toArray();
                                                            $trashSummary = implode(', ', $trashNames);
                                                        @endphp
                                                        {{ $trashSummary }} --}}
                                                            {{ $pickup->order->user->name }}
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-outline-success lihat-detail-btn"
                                                        style="white-space: nowrap;"
                                                        data-arrival="{{ $pickup->arrival_date }}"
                                                        data-pickup="{{ $pickup->pick_up_date }}"
                                                        data-start="{{ $pickup->start_time }}"
                                                        data-address="{{ $pickup->order->user->info->address }}, {{ $pickup->order->user->info->city }}, {{ $pickup->order->user->info->province }}, {{ $pickup->order->user->info->postal_code }}"
                                                        data-user="{{ $pickup->order->user->name }}"
                                                        data-photo="{{ asset('storage/' . $pickup->photos) }}"
                                                        data-photos="{{ asset('storage/') }}">
                                                        Lihat Detail
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{-- end for each --}}
                                    @else
                                        <div class="text-center text-muted my-4">
                                            <p>Tidak ada histori penjemputan tersedia.</p>
                                        </div>
                                    @endif
                                </div>

                                @if ($pickuplist->count())
                                    {{-- POP UP DETAIL --}}
                                    <div id="historiDriverModal" class="modal-overlay" style="display: none;">
                                        <div class="modal-content">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    {{-- <span class="badge bg-success mb-1" id="modal-status">Selesai</span><br> --}}
                                                    {{-- <span class="badge {{ $badgeClass }}">
                                                    {{ $label }} --}}
                                                    </span><br>
                                                    <strong>Waktu Penjemputan: <br><span
                                                            id="modal-start"></span></strong><br>
                                                    <strong>Waktu Pengambilan Sampah:<br> <span
                                                            id="modal-pickup"></span></strong><br>
                                                    <strong>Waktu Pengantaran Selesai:<br> <span
                                                            id="modal-arrival"></span></strong><br>
                                                    <strong>Alamat:<br> <span id="modal-address"></span></strong><br>
                                                    <strong>Pemesan:<br> <span id="modal-user"></span></strong><br>
                                                </div>
                                                <button class="close-btn btn btn-sm btn-light"
                                                    style="font-size: 1.25rem; line-height: 1; padding: 0 10px;">&times;</button>
                                            </div>

                                            {{-- <div>
                                            <h6>Ringkasan Penukaran</h6>
                                            <div class="bg-light p-2 mb-2" id="modal-summary"></div>
                                        </div> --}}
                                            <div>
                                                <strong>Foto Bukti<strong>
                                                        <img id="modal-photo" src="" alt="Foto Bukti"
                                                            class="img-fluid mb-2" />
                                                        <div class="bg-light p-2" id="photo-none"></div>
                                            </div>
                                            {{-- <div>
                                        <h6> - <b id="response-time"></b></h6>
                                        <div class="bg-light p-2" id="modal-response"></div>
                                    </div> --}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
    </main>
@endsection
