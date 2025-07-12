@extends('driver.partials.driver')

@section('title', 'Driver Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('pickup-driver/style.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('pickup-driver/script.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <style>
        .star-rating {
            font-size: 24px;
            margin: 10px 0;
        }

        .star-rating i {
            color: #616161;
            /* Warna default bintang kosong */
            cursor: pointer;
            transition: color 0.2s;
            padding: 0 2px;
        }

        .star-rating i.selected,
        .star-rating i:hover,
        .star-rating i:hover~i {
            color: #FFD700;
            /* Warna kuning emas */
            text-shadow: 0 0 2px rgba(255, 215, 0, 0.5);
        }

        .star-rating i.fa-star {
            color: #FFD700;
            /* Warna untuk bintang terisi */
        }

        .star-rating i.fa-star-o {
            color: #616161;
            /* Warna untuk bintang kosong */
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            width: 95%;
            margin: 0 auto;
        }

        @media (max-width: 576px) {
            .lihat-detail-btn {
                font-size: 14px;
                padding: 8px 12px;
            }

            .modal-content {
                padding: 15px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/histori-user.js') }}"></script>
@endpush



@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0"><b>Daftar Penjemputan Order</b></h3>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="container my-4">
                    <div class="card card-light mb-4">
                        <div class="card-header">
                            <div class="card-title">
                                <b>
                                    @if (session('success'))
                                        {{ session('success') }}
                                    @else
                                        Daftar Penjemputan {{ Auth::check() ? Auth::user()->name : 'Pengemudi' }}
                                    @endif
                                </b>
                            </div>
                        </div>

                        <div class="card-body row">
                            <div class="col-md-12">
                                @if ($pickups->count())
                                    @foreach ($pickups as $pickup)
                                        @php
                                            if (isset($pickup->arrival_date)) {
                                                $badgeClass = 'bg-success';
                                                $label = 'Selesai';
                                            } elseif ($pickup->start_time) {
                                                $badgeClass = 'bg-warning text-dark';
                                                $label = 'Dalam Penjemputan';
                                            } elseif ($pickup->pick_up_date) {
                                                $badgeClass = 'bg-warning text-dark';
                                                $label = 'Berhasil Diambil';
                                            } else {
                                                $badgeClass = 'bg-secondary';
                                                $label = 'Menunggu Pengambilan';
                                            }

                                        @endphp

                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-8 mb-2 mb-md-0">
                                                <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                                <div class="text-muted">
                                                    {{ \Carbon\Carbon::parse($pickup->order->date_time_request)->translatedFormat('l, d M Y') }}
                                                </div>
                                                <div class="text-success fw-semibold text-truncate "
                                                    style="max-width: 100%;">
                                                    Nama Pengguna: {{ $pickup->order->user->name }}
                                                </div>
                                                <div class="text-success fw-semibold text-truncate text-dark "
                                                    style="max-width: 100%;">
                                                    {{-- <p class="col user-address text-dark fs-5"> --}}
                                                    {{ $pickup?->order?->user?->info?->address ?? 'No address' }},
                                                    {{ $pickup?->order?->user?->info?->city ?? 'city' }},
                                                    {{ $pickup?->order?->user?->info?->province ?? 'province' }}
                                                    ,
                                                    {{ $pickup?->order?->user?->info?->postal_code ?? 'postal_code' }}
                                                    {{-- </p> --}}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 text-md-end mb-4">
                                                <a href="{{ route('driver.pickup.detail', $pickup->pick_up_id) }}"
                                                    class="btn btn-outline-success lihat-detail-btn w-100 w-md-auto mt-2 mt-md-0">
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted my-4">
                                        <p>Tidak ada penjemputan</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
