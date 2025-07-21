@extends('pengguna.partials.pengguna')

@section('title', 'Buat Laporan')

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
        <div class="col-sm-6"><h3 class="mb-0"><b>{{__('reports_user.create.title')}}</b></h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                        <a href="{{ route('pengguna.laporan.index') }}" class="btn btn-report">{{__('reports_user.create.breadcrumb')}}</a>
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
                <div class="card card-report mb-4">
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
                        <!-- Left: Form -->
                        <div class="col-md-8">
                        <form method="POST" action="{{ route('pengguna.laporan.store') }}" enctype="multipart/form-data">
                            @csrf

                            <input name="name" type="hidden" value="{{Auth::check() ? Auth::user()->user_id : '0'}}">
                            <div class="mb-3">
                                <label class="form-label">{{__('reports_user.create.form.report_label')}}</label>
                                <textarea name="laporan" rows="8" class="form-control" aria-label="Laporan" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="inputGroupFile02" class="form-label">{{__('reports_user.create.form.upload_label')}}</label>
                                <input name="gambar" type="file" class="form-control" id="inputGroupFile02" />
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-report">{{__('reports_user.create.form.submit_button')}}</button>
                            </div>
                            <div class="mt-3" id="imagePreviewContainer" style="display: none;">
                                <p class="mb-1 fw-bold">{{__('reports_user.create.form.image_preview')}}</p>
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded border" style="max-width: 100%; height: auto;">
                            </div>
                        </form>

                        </div>

                        <!-- Right: Image -->
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('dashboard-assets/assets/img/Laporan-Quotes.png') }}" alt="Laporan Quotes" style="max-width: 100%;">
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
