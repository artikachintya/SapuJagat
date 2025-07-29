@extends('admin.partials.admin')

@section('title', __('response_admin.title'))

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endpush

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

@push('styles')
<style>
    #laporanTable {
        --bs-table-bg: #026733;
        --bs-table-color: #ffffff;
        --bs-table-striped-bg: #006837;
        --bs-table-striped-color: #ffffff;
        --bs-table-hover-bg: #075c31;
        --bs-table-hover-color: #ffffff;
        --bs-table-border-color: #01733d;
    }

    #laporanTable thead th {
        background-color: #02341c;
        color: #ffffff;
    }

    #laporanTable td {
        color: #ffffff !important;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        color: #004d25;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#laporanTable');
    });
</script>
@endpush

@section('content')
<main class="app-main">
    <div class="container-fluid">
        <div class="app-content-header">
            <div class="row page-title">
                <div class="col-sm mt-3 mb-0">
                    <h3>{{ __('response_admin.page_title') }}</h3>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ __('response_admin.alerts.success', ['message' => session('success')]) }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mt-1">
            <div class="card-header text-white" style="background-color: #0e6b3b">
                <h5 class="card-title">{{ __('response_admin.table_title') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="laporanTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">{{ __('response_admin.table.headers.id') }}</th>
                                <th class="text-center">{{ __('response_admin.table.headers.user_id') }}</th>
                                <th class="text-center">{{ __('response_admin.table.headers.reporter_name') }}</th>
                                <th class="text-center">{{ __('response_admin.table.headers.report_content') }}</th>
                                <th class="text-center">{{ __('response_admin.table.headers.report_date') }}</th>
                                <th class="text-center">{{ __('response_admin.table.headers.response_date') }}</th>
                                <th class="text-center">{{ __('response_admin.table.headers.status') }}</th>
                                <th class="text-center">{{ __('response_admin.table.headers.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                            <tr>
                                <!-- Modal -->
                                <div class="modal fade" id="detailModal{{ $report->report_id }}" tabindex="-1" aria-labelledby="modalLabel{{ $report->report_id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title" id="modalLabel{{ $report->report_id }}">
                                                    {{ __('response_admin.modal.title', ['id' => $report->report_id]) }}
                                                </h5>
                                                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-dark">
                                                <p><strong>{{ __('response_admin.modal.fields.user_id') }}:</strong> {{ $report->user->user_id }}</p>
                                                <p><strong>{{ __('response_admin.modal.fields.reporter_name') }}:</strong> {{ $report->user->name }}</p>
                                                <p><strong>{{ __('response_admin.modal.fields.report_content') }}:</strong> {{ $report->report_message }}</p>
                                                <p><strong>{{ __('response_admin.modal.fields.report_date') }}:</strong> {{ $report->date_time_report }}</p>
                                                <p><strong>{{ __('response_admin.modal.fields.response_date') }}:</strong> {{ $report->response->date_time_response ?? '-' }}</p>
                                                <p><strong>{{ __('response_admin.modal.fields.status') }}:</strong>
                                                    @if ($report->response)
                                                        <span class="badge bg-success">{{ __('response_admin.table.status.responded') }}</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">{{ __('response_admin.table.status.pending') }}</span>
                                                    @endif
                                                </p>
                                                @if ($report->photo)
                                                    <p><strong>{{ __('response_admin.modal.fields.photo') }}:</strong></p>
                                                    <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto Bukti" class="img-fluid mb-3 rounded shadow" style="max-height: 300px;"
                                                        onerror="this.onerror=null; this.src='{{ asset('assets/img/default.png') }}';">
                                                @endif
                                                @if ($report->response)
                                                    <hr>
                                                    <p><strong>{{ __('response_admin.modal.fields.response_content') }}:</strong> {{ $report->response->response_message }}</p>
                                                    <p><strong>{{ __('response_admin.modal.fields.admin') }}:</strong> {{ $report->response->user->name ?? '-' }}</p>
                                                @endif
                                            </div>

                                            @if (!$report->response)
                                                <hr>
                                                <form action="{{ route('admin.laporan.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="report_id" value="{{ $report->report_id }}">
                                                    <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">

                                                    <div class="mb-3 mx-3">
                                                        <label for="response_message" class="form-label">
                                                            {{ __('response_admin.modal.response_form.label') }}
                                                        </label>
                                                        <textarea name="response_message" class="form-control" rows="4" required></textarea>
                                                    </div>

                                                    <div class="d-flex justify-content-end mb-3 mx-3">
                                                        <button type="submit" class="btn btn-success">
                                                            {{ __('response_admin.modal.response_form.submit') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <td>{{ $report->report_id }}</td>
                                <td class="text-center">{{ $report->user->user_id }}</td>
                                <td>{{ $report->user->name }}</td>
                                <td>{{ Str::limit($report->report_message, 40) }}</td>
                                <td class="text-center">{{ $report->date_time_report }}</td>
                                <td class="text-center">{{ $report->response->date_time_response ?? '-' }}</td>
                                <td>
                                    @if ($report->response)
                                        <span class="badge text-dark" style="background-color: rgb(35, 223, 73)">
                                            {{ __('response_admin.table.status.responded') }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            {{ __('response_admin.table.status.pending') }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button"
                                        class="btn btn-sm"
                                        style="background-color: #E5F5E0"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $report->report_id }}">
                                        {{ __('response_admin.table.action_button') }}
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
