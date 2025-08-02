@extends('admin.partials.admin')

@section('title', __('user_list.title'))

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endpush

@php
    $currLang = session()->get('lang', 'id');
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

        #laporanTabledua {
            --bs-table-bg: #026733;
            --bs-table-color: #ffffff;
            --bs-table-striped-bg: #006837;
            --bs-table-striped-color: #ffffff;
            --bs-table-hover-bg: #075c31;
            --bs-table-hover-color: #ffffff;
            --bs-table-border-color: #01733d;
        }

        #laporanTabledua thead th {
            background-color: #02341c;
            color: #ffffff;
        }

        #laporanTabledua td {
            color: #ffffff !important;
        }

        #laporanTabletiga {
            --bs-table-bg: #026733;
            --bs-table-color: #ffffff;
            --bs-table-striped-bg: #006837;
            --bs-table-striped-color: #ffffff;
            --bs-table-hover-bg: #075c31;
            --bs-table-hover-color: #ffffff;
            --bs-table-border-color: #01733d;
        }

        #laporanTabletiga thead th {
            background-color: #02341c;
            color: #ffffff;
        }

        #laporanTabletiga td {
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
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new DataTable('#laporanTable');
            new DataTable('#laporanTabledua');
            new DataTable('#laporanTabletiga');
        });
    </script>
@endpush

@section('content')
    <main class="app-main">
        <div class="container-fluid">
            <div class="app-content-header">
                <div class="row page-title">
                    <div class="col-sm mt-3 mb-0">
                        <h3>{{ __('user_list.page_title') }}</h3>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ __('user_list.alerts.success', ['message' => session('success')]) }}
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
                    <h5 class="card-title">{{ __('user_list.user_lists') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="laporanTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('user_list.table_headers.id') }}</th>
                                    <th>{{ __('user_list.table_headers.name') }}</th>
                                    <th>{{ __('user_list.table_headers.phone_num') }}</th>
                                    <th>{{ __('user_list.table_headers.status') }}</th>
                                    <th>{{ __('user_list.table_headers.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="detailModal{{ $user->user_id }}" tabindex="-1"
                                            aria-labelledby="modalLabel{{ $user->user_id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title" id="modalLabel{{ $user->user_id }}">
                                                            {{ __('user_list.modal.title', ['id' => $user->user_id]) }}
                                                        </h5>
                                                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-dark">
                                                        <p><strong>{{ __('user_list.table_headers.id_user') }}:</strong> {{ $user->user_id }}</p>
                                                        <p><strong>{{ __('user_list.table_headers.name') }}:</strong> {{ $user->name }}</p>
                                                        <p><strong>{{ __('user_list.table_headers.number') }}:</strong> {{ $user->phone_num }}</p>
                                                        <p><strong>{{ __('user_list.table_headers.status') }}:</strong>
                                                            {{ $user->status == 0 ? __('user_list.status.active') : __('user_list.status.blocked') }}</p>
                                                        @if ($user->profile_pic)
                                                            <p><strong>{{ __('user_list.modal.fields.photo') }}:</strong></p>
                                                            <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="Foto Bukti"
                                                                class="img-fluid mb-3 rounded shadow" style="max-height: 300px;"
                                                                onerror="this.onerror=null; this.src='{{ asset('assets/img/default.png') }}';">
                                                        @endif
                                                    </div>
                                                    <form action="{{ route('admin.user-lists.update', $user->user_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status"
                                                            value="{{ $user->status == 0 ? 1 : 0 }}">
                                                        <button type="submit"
                                                            class="btn {{ $user->status == 0 ? 'btn-danger' : 'btn-success' }}">
                                                            {{ $user->status == 0 ? __('user_list.buttons.block') : __('user_list.buttons.unblock') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <td>{{ $user->user_id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone_num }}</td>
                                        <td>{{ $user->status == 0 ? __('user_list.status.active') : __('user_list.status.blocked') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm" style="background-color: #E5F5E0"
                                                data-bs-toggle="modal" data-bs-target="#detailModal{{ $user->user_id }}">
                                                {{ $user->status == 0 ? __('user_list.buttons.block') : __('user_list.buttons.unblock') }}
                                            </button>
                                            <a href="{{ route('admin.user.logs', ['id' => $user->user_id]) }}"
                                                class="btn btn-sm btn-info">
                                                {{ __('user_list.buttons.log') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-1">
                <div class="card-header text-white" style="background-color: #0e6b3b">
                    <h5 class="card-title">{{ __('user_list.driver_lists') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="laporanTabledua" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('user_list.table_headers.id') }}</th>
                                    <th>{{ __('user_list.table_headers.name') }}</th>
                                    <th>{{ __('user_list.table_headers.phone_num') }}</th>
                                    <th>{{ __('user_list.table_headers.status') }}</th>
                                    <th>{{ __('user_list.table_headers.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drivers as $driver)
                                    <tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="detailModal{{ $driver->user_id }}" tabindex="-1"
                                            aria-labelledby="modalLabel{{ $driver->user_id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title" id="modalLabel{{ $driver->user_id }}">
                                                            {{ __('user_list.modal.title', ['id' => $driver->user_id]) }}
                                                        </h5>
                                                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-dark">
                                                        <p><strong>{{ __('user_list.table_headers.id_user') }}:</strong> {{ $driver->user_id }}</p>
                                                        <p><strong>{{ __('user_list.table_headers.name') }}:</strong> {{ $driver->name }}</p>
                                                        <p><strong>{{ __('user_list.table_headers.number') }}:</strong> {{ $driver->phone_num }}</p>
                                                        <p><strong>{{ __('user_list.table_headers.status') }}:</strong>
                                                            {{ $driver->status == 0 ? __('user_list.status.active') : __('user_list.status.blocked') }}</p>
                                                        @if ($driver->profile_pic)
                                                            <p><strong>{{ __('user_list.modal.fields.photo') }}:</strong></p>
                                                            <img src="{{ asset('storage/' . $driver->profile_pic) }}"
                                                                alt="Foto Bukti" class="img-fluid mb-3 rounded shadow"
                                                                style="max-height: 300px;"
                                                                onerror="this.onerror=null; this.src='{{ asset('assets/img/default.png') }}';">
                                                        @endif
                                                    </div>
                                                    <form action="{{ route('admin.user-lists.update', $driver->user_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status"
                                                            value="{{ $driver->status == 0 ? 1 : 0 }}">
                                                        <button type="submit"
                                                            class="btn {{ $driver->status == 0 ? 'btn-danger' : 'btn-success' }}">
                                                            {{ $driver->status == 0 ? __('user_list.buttons.block') : __('user_list.buttons.unblock') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <td>{{ $driver->user_id }}</td>
                                        <td>{{ $driver->name }}</td>
                                        <td>{{ $driver->phone_num }}</td>
                                        <td>{{ $driver->status == 0 ? __('user_list.status.active') : __('user_list.status.blocked') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm" style="background-color: #E5F5E0"
                                                data-bs-toggle="modal" data-bs-target="#detailModal{{ $driver->user_id }}">
                                                {{ $driver->status == 0 ? __('user_list.buttons.block') : __('user_list.buttons.unblock') }}
                                            </button>
                                            <a href="{{ route('admin.user.logs', ['id' => $driver->user_id]) }}"
                                                class="btn btn-sm btn-info">
                                                {{ __('user_list.buttons.log') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-1">
                <div class="card-header text-white" style="background-color: #0e6b3b">
                    <h5 class="card-title">{{ __('user_list.admin_lists') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="laporanTabletiga" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('user_list.table_headers.id') }}</th>
                                    <th>{{ __('user_list.table_headers.name') }}</th>
                                    <th>{{ __('user_list.table_headers.phone_num') }}</th>
                                    <th>{{ __('user_list.table_headers.status') }}</th>
                                    <th>{{ __('user_list.table_headers.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="detailModal{{ $admin->user_id }}" tabindex="-1"
                                            aria-labelledby="modalLabel{{ $admin->user_id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title" id="modalLabel{{ $admin->user_id }}">
                                                            {{ __('user_list.modal.title', ['id' => $admin->user_id]) }}
                                                        </h5>
                                                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-dark">
                                                        <p><strong>{{ __('user_list.table_headers.id_user') }}:</strong> {{ $admin->user_id }}</p>
                                                        <p><strong>{{ __('user_list.table_headers.name') }}:</strong> {{ $admin->name }}</p>
                                                        <p><strong>{{ __('user_list.table_headers.number') }}:</strong> {{ $admin->phone_num }}</p>
                                                        <p><strong>{{ __('user_list.table_headers.status') }}:</strong>
                                                            {{ $admin->status == 0 ? __('user_list.status.active') : __('user_list.status.blocked') }}</p>
                                                        @if ($admin->profile_pic)
                                                            <p><strong>{{ __('user_list.modal.fields.photo') }}:</strong></p>
                                                            <img src="{{ asset('storage/' . $admin->profile_pic) }}"
                                                                alt="Foto Bukti" class="img-fluid mb-3 rounded shadow"
                                                                style="max-height: 300px;"
                                                                onerror="this.onerror=null; this.src='{{ asset('assets/img/default.png') }}';">
                                                        @endif
                                                    </div>
                                                    <form action="{{ route('admin.user-lists.update', $admin->user_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status"
                                                            value="{{ $admin->status == 0 ? 1 : 0 }}">
                                                        <button type="submit"
                                                            class="btn {{ $admin->status == 0 ? 'btn-danger' : 'btn-success' }}">
                                                            {{ $admin->status == 0 ? __('user_list.buttons.block') : __('user_list.buttons.unblock') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <td>{{ $admin->user_id }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->phone_num }}</td>
                                        <td>{{ $admin->status == 0 ? __('user_list.status.active') : __('user_list.status.blocked') }}</td>
                                        <td>
                                            <a href="{{ route('admin.user.logs', ['id' => $admin->user_id]) }}"
                                                class="btn btn-sm btn-info">
                                                {{ __('user_list.buttons.log') }}
                                            </a>
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
