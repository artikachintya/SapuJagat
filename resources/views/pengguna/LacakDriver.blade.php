@extends('pengguna.partials.pengguna')

@section('title', 'Pelacakan')

@section('content')
<main class="app-main container mt-4">
    @if (!$order)
        <div class="card-body text-center py-5 " style="background-color: #E5F5E0; border-radius: 20px">
            <i class="bi bi-exclamation-octagon-fill text-danger" style="font-size: 200px;"></i>
            <h3 class="fw-bold" style="font-family:'Inria Sans', sans-serif;">Belum ada Pesanan</h3>
            <p style="font-family: 'Inria Sans', sans-serif;">Silahkan buat pesanan terlebih dahulu untuk melacak prosesnya</p>
        </div>
    @elseif ($order->status == 0)
        <div class="card loading-card text-center">
            <div class="loading-spinner-wrapper">
                <div class="spinner-border text-success loading-spinner" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <img src="{{ asset('LacakDriver/assets/Driver-icon.png') }}" alt="Driver" class="driver-icon">
            </div>
            <h3 class="loading-title">Mencari Driver</h3>
            <p class="loading-text">Tunggu ya admin segera mencarikan kamu driver...</p>
        </div>
    @else
        <div class="card p-4 shadow-sm" style="background-color:#f5fcf7;">
            <div class="tracking-container">
                <div class="driver-info">
                    <img src="{{ asset('LacakDriver/assets/Driver-Face.jpeg') }}" alt="Driver" class="driver-photo" />
                    <div class="driver-details">
                        <h2>{{ $order->pickup?->user?->name ?? 'Nama Driver Tidak Diketahui' }}</h2>
                        <p>{{ $order->pickup?->user?->license?->license_plate ?? 'Plat Nomor Tidak Diketahui' }}</p>
                        <button class="contact-button">Hubungi Driver</button>
                    </div>
                </div>

                <div class="timeline-grid">
                    <!-- LEFT SIDE -->
                    <div class="timeline-side">
                        <!-- Item 1: Dalam Penjemputan -->
                        <div class="timeline-item 
                            {{ $order->pickup?->pick_up_date ? 'completed' : ($order->pickup?->start_time ? 'current' : '') }}">
                            <img src="{{ asset('LacakDriver/assets/otwJemput.png') }}" alt="Dalam Penjemputan" class="timeline-icon" />
                            <div class="timeline-text">
                                <strong>Dalam Penjemputan</strong>
                                <p>{{ $order->formattedDateTime('pickup', 'start_time') }}</p>
                            </div>
                        </div>
                        <div class="timeline-line"></div>

                        <!-- Item 2: Pengambilan Sampah -->
                        <div class="timeline-item 
                            {{ $order->pickup?->arrival_date ? 'completed' : ($order->pickup?->pick_up_date ? 'current' : '') }}">
                            <img src="{{ asset('LacakDriver/assets/pickUp.png') }}" alt="Pengambilan Sampah" class="timeline-icon" />
                            <div class="timeline-text">
                                <strong>Pengambilan Sampah</strong>
                                <p>{{ $order->formattedDateTime('pickup', 'pick_up_date') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="timeline-side">
                        <!-- Item 3: Pengecekan Sampah -->
                        <div class="timeline-item 
                            {{ $approval ? 'completed' : ($order->pickup?->arrival_date ? 'current' : '') }}">
                            <img src="{{ asset('LacakDriver/assets/checkingProcess.png') }}" alt="Pengecekan Sampah" class="timeline-icon" />
                            <div class="timeline-text">
                                <strong>Pengecekan Sampah</strong>
                                <p>{{ $order->formattedDateTime('pickup', 'arrival_date') }}</p>
                            </div>
                        </div>
                        <div class="timeline-line"></div>

                        <!-- Item 4: Status Persetujuan -->
                        <div class="timeline-item {{ $approval ? 'current' : '' }}">
                            <img src="{{ asset('LacakDriver/assets/'. $approval_icon) }}" alt="Status Icon" class="timeline-icon" />
                            <div class="timeline-text">
                                <strong>
                                    @if($approval)
                                        @if($approval->approval_status == 0)
                                            Menunggu Konfirmasi Admin
                                        @elseif($approval->approval_status == 1)
                                            Penukaran Berhasil
                                        @elseif($approval->approval_status == 2)
                                            Penukaran Ditolak
                                        @endif
                                    @else
                                        Menunggu Konfirmasi Admin
                                    @endif
                                </strong>
                                <p>{{ $order->formattedDateTime('approval', 'date_time') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</main>
@endsection
