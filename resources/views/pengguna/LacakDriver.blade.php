@extends('pengguna.partials.pengguna')

@section('title', 'Pelacakan')


@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

@section('content')
<main class="app-main container mt-4">

    {{-- ✅ Flash Notification --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong> {{ __('tracking_driver.alerts.success') }} </strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ __('tracking_driver.alerts.success') }} </strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ✅ Konten utama pelacakan --}}
    @if (!$order)
        <div class="card-body text-center py-5 " style="background-color: #E5F5E0; border-radius: 20px">
            <i class="bi bi-exclamation-octagon-fill text-danger" style="font-size: 200px;"></i>
            <h3 class="fw-bold" style="font-family:'Inria Sans', sans-serif;">{{ __('tracking_driver.no_order.title') }} </h3>
            <p style="font-family: 'Inria Sans', sans-serif;">{{ __('tracking_driver.no_order.message') }} </p>
        </div>
    @elseif (!$order->sudah_dapat_driver)
        <div class="card loading-card text-center">
            <div class="loading-spinner-wrapper">
                <div class="spinner-border text-success loading-spinner" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <img src="{{ asset('LacakDriver/assets/Driver-icon.png') }}" alt="Driver" class="driver-icon">
            </div>
            <h3 class="loading-title">{{ __('tracking_driver.searching_driver.title') }} </h3>
            <p class="loading-text">{{ __('tracking_driver.searching_driver.message') }} </p>
        </div>
    @else
        <div class="card p-4 shadow-sm" style="background-color:#f5fcf7;">
            <div class="tracking-container">
                <div class="driver-info">
                    <img src="{{ asset('LacakDriver/assets/Driver-Face.jpeg') }}" alt="Driver" class="driver-photo" />
                    <div class="driver-details">
                        <h2>{{ $order->pickup?->user?->name ?? 'Nama Driver Tidak Diketahui' }}</h2>
                        <p>{{ $order->pickup?->user?->license?->license_plate ?? 'Plat Nomor Tidak Diketahui' }}</p>
                        {{-- <button class="contact-button">Hubungi Driver</button> --}}
                        @if ($chat)
                            <a href="{{ route('pengguna.chat', $chat->chat_id) }}" class="contact-button">
                                {{ __('tracking_driver.driver_info.contact_button') }}
                            </a>
                        @endif
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
                                <strong>{{ __('tracking_driver.timeline.pickup') }} </strong>
                                <p>{{ $order->formattedDateTime('pickup', 'start_time') }}</p>
                            </div>
                        </div>
                        <div class="timeline-line"></div>

                        <!-- Item 2: Pengambilan Sampah -->
                        <div class="timeline-item
                            {{ $order->pickup?->arrival_date ? 'completed' : ($order->pickup?->pick_up_date ? 'current' : '') }}">
                            <img src="{{ asset('LacakDriver/assets/pickUp.png') }}" alt="Pengambilan Sampah" class="timeline-icon" />
                            <div class="timeline-text">
                                <strong>{{ __('tracking_driver.timeline.collection') }} </strong>
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
                                <strong>{{ __('tracking_driver.timeline.checking') }} </strong>
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
                                        @switch($approval->approval_status)
                                            @case(0)
                                                {{ __('tracking_driver.timeline.approval.rejected') }}
                                                @break
                                            @case(1)
                                                {{ __('tracking_driver.timeline.approval.approved') }}
                                                @break
                                            @case(2)
                                                {{ __('tracking_driver.timeline.approval.waiting') }}
                                                @break
                                            @default
                                                {{ __('tracking_driver.timeline.approval.default') }}
                                        @endswitch
                                    @else
                                           {{ __('tracking_driver.timeline.approval.default') }}
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
