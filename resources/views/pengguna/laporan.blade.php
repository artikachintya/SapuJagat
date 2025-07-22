@extends('pengguna.partials.pengguna')

@section('title', 'Daftar Laporan')

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/laporan.js') }}"></script>
@endpush

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp


@section('content')
<main class="app-main">
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row page-title">
        <div class="col-sm-6"><h3 class="mb-0"><b>{{__('reports_user.index.title')}}</b></h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('pengguna.laporan.create') }}" class="btn btn-report">{{__('reports_user.create.title')}}</a>
                    </li>
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
                <div class="card card-light mb-4">
                    <!--begin::Header-->
                    <div class="card-header">
                        <div class="card-title">
                            <b>
                                @if(session('success'))
                                    {{ session('success') }}
                                @else
                                    {{__('reports_user.create.form.title', ['name' => Auth::check() ? Auth::user()->name : 'Pengguna'])}}
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
                                @foreach ($laporanList as $laporan)
                                    <div class="mb-3 p-3 rounded" style="background-color: #f9fdf9; border: 1px solid #d4ecd4;">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge {{ $laporan->latestResponse ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $laporan->latestResponse ?  __('reports_user.index.status.responded') : __('reports_user.index.status.waiting') }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="text-muted">{{ \Carbon\Carbon::parse($laporan->date_time_report)->translatedFormat('l, d M Y') }}</div>
                                                <div class="text-success fw-semibold">
                                                    {{ Str::limit($laporan->report_message, 80, '..') }}
                                                </div>
                                            </div>
                                            <button class="btn btn-outline-success lihat-detail-btn"
                                                data-date="{{ \Carbon\Carbon::parse($laporan->date_time_report)->translatedFormat('l, d M Y') }}"
                                                data-laporan="{{ $laporan->report_message }}"
                                                data-response="{{ $laporan->latestResponse->response_message ?? __('reports_user.index.modal.no_response') }}"
                                                data-responsetime="{{ $laporan->latestResponse->date_time_response ?? '-' }}"
                                                data-photo="{{ asset('storage/' . $laporan->photo) }}"
                                                data-photos="{{ asset('storage/') }}"
                                                data-status="{{ $laporan->latestResponse ? __('reports_user.index.status.responded') : __('reports_user.index.status.waiting') }}"
                                                data-status-class="{{ $laporan->latestResponse ? 'bg-success' : 'bg-secondary' }}">
                                                {{ __('reports_user.detail') }}
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div id="laporanModal" class="modal-overlay" style="display: none;">
                                <div class="modal-content">
                                    <div cla ss="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <span class="badge bg-success mb-1" id="modal-status">Selesai</span><br>
                                            <strong>{{ __('reports_user.index.modal.date') }} <span id="modal-date"></span></strong>
                                        </div>
                                        <button class="close-btn btn btn-sm btn-light" style="font-size: 1.25rem; line-height: 1; padding: 0 10px;">&times;</button>
                                    </div>

                                    <div>
                                        <h6>{{ __('reports_user.index.modal.report_content') }}</h6>
                                        <div class="bg-light p-2 mb-2" id="modal-laporan"></div>
                                    </div>
                                    <div>
                                        <h6>{{ __('reports_user.index.modal.evidence_photo') }}</h6>
                                        <img id="modal-photo" src="" alt="Foto Bukti" class="img-fluid mb-2" />
                                        <div class="bg-light p-2" id="photo-none"></div>
                                    </div>
                                    <div>
                                        <h6>{{ __('reports_user.index.modal.admin_response') }} <b id="response-time"></b></h6>
                                        <div class="bg-light p-2" id="modal-response"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end::Body-->
                </div>

            </div>
        </div>
        <!-- Info boxes -->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->
</main>
@endsection
