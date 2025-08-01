@extends('admin.partials.admin')

@section('title', __('log.title'))

@php
    $currLang = session()->get('lang', 'id');
    app()->setLocale($currLang);
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
    <style>
        #logTable {
            --bs-table-bg: #026733;
            --bs-table-color: #ffffff;
            --bs-table-striped-bg: #006837;
            --bs-table-striped-color: #ffffff;
            --bs-table-hover-bg: #075c31;
            --bs-table-hover-color: #ffffff;
            --bs-table-border-color: #01733d;
        }

        #logTable thead th {
            background-color: #02341c;
            color: #ffffff;
        }

        #logTable tbody tr {
            background-color: #026733 !important;
            color: #ffffff !important;
        }

        #logTable tbody tr:nth-child(even) {
            background-color: #006837 !important;
        }

        #logTable td {
            color: #ffffff !important;
        }

        #logTable pre {
            background-color: transparent;
            border: none;
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
            const logTable = document.querySelector('#logTable');
            const hasRows = logTable.querySelectorAll('tbody tr').length > 1 ||
                (logTable.querySelector('tbody tr td') &&
                 !logTable.querySelector('tbody tr td').classList.contains('text-center'));

            if (hasRows) {
                new DataTable('#logTable');
            }
        });
    </script>
@endpush

@section('content')
    <main class="app-main">
        <div class="container-fluid">
            <div class="app-content-header">
                <div class="row page-title">
                    <div class="col-sm mt-3 mb-0">
                        <h3>{{ __('log.page_title') }}{{ $user->name ? ' - ' . $user->name : '' }}</h3>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ __('log.success_message', ['message' => session('success')]) }}
                </div>
            @endif

            <div class="card mt-3">
                <div class="card-body">
                    {{-- Back Button --}}
                    <a href="{{ route('admin.user-lists.index') }}" class="btn btn-success mb-3">
                        <i class="bi bi-arrow-left-circle"></i> {{ __('log.back_button') }}
                    </a>

                    {{-- Log Table --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-white" id="logTable">
                            <thead>
                                <tr>
                                    <th>{{ __('log.table_headers.date') }}</th>
                                    <th>{{ __('log.table_headers.log_name') }}</th>
                                    <th>{{ __('log.table_headers.description') }}</th>
                                    <th>{{ __('log.table_headers.properties') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i') }}</td>
                                        <td>{{ $log->log_name }}</td>
                                        <td>{{ $log->description }}</td>
                                        <td>
                                            <pre class="text-white" style="white-space: pre-wrap; word-break: break-word;">
{{ json_encode($log->properties?->toArray(), JSON_PRETTY_PRINT) }}
                                            </pre>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-white">{{ __('log.no_logs') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
