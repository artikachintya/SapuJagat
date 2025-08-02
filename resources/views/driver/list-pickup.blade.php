@extends('driver.partials.driver')

@section('title', __('dashboard_driver.title'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('pickup-driver/style.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('pickup-driver/script.js') }}"></script>
@endpush

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp


@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <style>
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
                <h3 class="mb-0"><b>{{ __('dashboard_driver.header.title') }}</b></h3>
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
                                        {{ __('dashboard_driver.header.greeting', ['name' => Auth::check() ? Auth::user()->name : 'Pengemudi']) }}
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
                                                $label = __('dashboard_driver.status.completed');
                                            } elseif ($pickup->start_time) {
                                                $badgeClass = 'bg-warning text-dark';
                                                $label = __('dashboard_driver.status.in_progress');
                                            } elseif ($pickup->pick_up_date) {
                                                $badgeClass = 'bg-warning text-dark';
                                                $label = __('dashboard_driver.status.picked_up');
                                            } else {
                                                $badgeClass = 'bg-secondary';
                                                $label = __('dashboard_driver.status.waiting');
                                            }
                                        @endphp

                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-8 mb-2 mb-md-0">
                                                <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                                <div class="text-muted">
                                                    {{ \Carbon\Carbon::parse($pickup->order->date_time_request)->translatedFormat(__('dashboard_driver.date_format')) }}
                                                </div>
                                                <div class="text-success fw-semibold text-truncate"
                                                    style="max-width: 100%;">
                                                   {{ $pickup->order->user->name }}
                                                </div>
                                                <div class="text-success fw-semibold text-truncate text-dark"
                                                    style="max-width: 100%;">
                                                    {{ $pickup?->order?->user?->info?->address ?? 'No address' }},
                                                    {{ $pickup?->order?->user?->info?->city ?? 'city' }},
                                                    {{ $pickup?->order?->user?->info?->province ?? 'province' }},
                                                    {{ $pickup?->order?->user?->info?->postal_code ?? 'postal_code' }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 text-md-end mb-4">
                                                <a href="{{ route('driver.pickup.detail', $pickup->pick_up_id) }}"
                                                    class="btn btn-outline-success lihat-detail-btn w-100 w-md-auto mt-2 mt-md-0">
                                                    {{ __('dashboard_driver.labels.view_details') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted my-4">
                                        <p>{{ __('dashboard_driver.labels.no_pickups') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
