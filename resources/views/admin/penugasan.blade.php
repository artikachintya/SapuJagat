@extends('admin.partials.admin')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
    <style>
        /* ---- Dark‑green DataTable palette ---- */
        #jenis-sampah.dataTable {
            /* table background & text */
            --bs-table-bg: #004d25;
            /* base green */
            --bs-table-color: #ffffff;
            /* text colour */
            /* striped rows */
            --bs-table-striped-bg: #006837;
            --bs-table-striped-color: #ffffff;
            /* hover */
            --bs-table-hover-bg: #075c31;
            --bs-table-hover-color: #ffffff;
            /* borders (optional) */
            --bs-table-border-color: #01733d;
        }

        /* Header */
        #jenis-sampah thead th {
            background: #022615;
            color: #ffffff;
            border-color: #01733d;
        }

        /* Length & search labels */
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            color: #004d25;
            font-weight: 600;
        }

        .modal-backdrop.show {
            background: #000;
            opacity: .7;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('#jenis-sampah');
            if (table) {
                new DataTable('#jenis-sampah', {
                    responsive: true
                });
            }

            const createModal = document.getElementById('createPenugasanModal');

            createModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget; // tombol yang diklik
                const orderId = button.getAttribute('data-order-id');

                // 2) kalau pakai hidden input
                const orderInput = createModal.querySelector('#orderIdInput');
                if (orderInput) orderInput.value = orderId;
            });

            // DELETE
            const deleteModal = document.getElementById('deleteTrashModal');

            deleteModal.addEventListener('show.bs.modal', event => {
                const btn = event.relatedTarget;
                const form = deleteModal.querySelector('#deleteTrashForm');

                form.action = btn.dataset.action; // ← uses the route() URL passed from Blade
            });
        });
    </script>
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
                    <div class="col-sm">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('penugasan_driver.dashboard') }}
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
                <!-- Info boxes -->
                <!-- /.row -->
                <!--begin::Row-->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                        <div class="card mb-4 recap">
                            <div class="card-header">
                                <h5 class="card-title">{{ __('penugasan_driver.assignments') }}</h5>
                                <div class="card-tools">
                                    <a href="{{ route('admin.penugasan.archive') }}" class="btn btn-warning btn-sm">
                                        {{ __('penugasan_driver.archive') }}
                                    </a>

                                    {{-- <a href="{{route('admin.jenis-sampah.create')}}" class="btn btn-success">Buat Sampah</a> --}}
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                    </button>

                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!--begin::Row-->
                                <div class="row d-flex align-items-stretch">
                                    <table id="jenis-sampah" class="table table-striped align-middle"
                                        style="background-color:black;">

                                        <thead>
                                            <tr>
                                                <th>{{ __('penugasan_driver.order_photo') }}</th>
                                                <th>{{ __('penugasan_driver.order_id') }}</th>
                                                <th>{{ __('penugasan_driver.user_name') }}</th>
                                                <th>{{ __('penugasan_driver.time_info') }}</th>
                                                <th>{{ __('penugasan_driver.driver') }}</th>
                                                <th>{{ __('penugasan_driver.assignment_status') }}</th>
                                                <th>{{ __('penugasan_driver.actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($penugasans as $penugasan)
                                                <tr>
                                                    <td><img src="{{ asset('storage/' . $penugasan->photo) }}"
                                                            alt="Foto Sampah" class="img-fluid" style="max-height: 150px;">
                                                    </td>
                                                    <td>{{ $penugasan->order_id }}</td>
                                                    <td>{{ $penugasan->user->name }}</td>
                                                    <td> {{ __('penugasan_driver.made_at', ['time' => $penugasan->date_time_request]) }}<br>
                                                        {{ __('penugasan_driver.requested_at', ['time' => $penugasan->pickup_time]) }}
                                                    </td>
                                                    <td>
                                                        @forelse ($penugasan->penugasan as $item)
                                                            {{ __('penugasan_driver.task') }}:&nbsp;{{ $item->user->name }}<br>
                                                        @empty
                                                            {{ __('penugasan_driver.no_driver_assigned') }}
                                                        @endforelse
                                                    </td>
                                                    <td>
                                                        @forelse ($penugasan->penugasan as $item)
                                                            {{-- Contoh output: Penugasan id 3: belum selesai --}}
                                                            {{ __('penugasan_driver.task') }}&nbsp;ID&nbsp;{{ $item->penugasan_id }}:&nbsp;
                                                            {{ match ($item->status) {
                                                                1 => __('penugasan_driver.completed'),
                                                                0 => __('penugasan_driver.not_completed'),
                                                                null => __('penugasan_driver.no_status'),
                                                                default => __('penugasan_driver.unknown_status'),
                                                            } }}<br>
                                                        @empty
                                                            {{ __('penugasan_driver.no_status') }}
                                                        @endforelse
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column gap-2 align-items-center mb-1">
                                                            @forelse ($penugasan->penugasan as $item)
                                                                {{-- Tombol Hapus – memicu modal konfirmasi --}}
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm w-75 btn-delete"
                                                                    data-id="{{ $item->penugasan_id }}"
                                                                    data-action="{{ route('admin.penugasan.destroy', $item->penugasan_id) }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteTrashModal">
                                                                    {{ __('penugasan_driver.delete_assignment_btn') }}&nbsp;{{ $item->penugasan_id }}
                                                                </button>
                                                            @empty
                                                                <span>{{ __('penugasan_driver.not_available') }}</span>
                                                            @endforelse
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#createPenugasanModal"
                                                                data-order-id="{{ $penugasan->order_id }}">
                                                                {{ __('penugasan_driver.create_assignment_btn') }}
                                                            </button>
                                                        </div>
                                                    </td>

                                                    <!-- CREATE MODAL -->
                                                    <div class="modal fade" id="createPenugasanModal" tabindex="-1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content text-white"
                                                                style="background:#34a853;">
                                                                <div class="modal-header border-0">
                                                                    <h2 class="modal-title w-100 text-center fw-bold">
                                                                        {{ __('penugasan_driver.create_assignment') }}</h2>
                                                                    <button type="button" class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>

                                                                <form id="createAssignmentForm"
                                                                    action="{{ route('admin.penugasan.store') }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf

                                                                    <div class="modal-body">

                                                                        {{-- ORDER ID – pilih dari data $penugasans / $orders --}}
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('penugasan_driver.order_id') }}</label>
                                                                            <input type="number" name="order_id"
                                                                                id="orderIdInput" class="form-control"
                                                                                readonly> {{-- Hanya baca, tetap ikut POST --}}
                                                                        </div>


                                                                        {{-- DRIVER – pilih dari data $drivers --}}
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('penugasan_driver.driver') }}</label>
                                                                            <select name="user_id" class="form-select"
                                                                                required>
                                                                                <option value="" disabled selected>
                                                                                    {{ __('penugasan_driver.select_driver') }}
                                                                                </option>
                                                                                @foreach ($drivers as $driver)
                                                                                    <option value="{{ $driver->user_id }}">
                                                                                        {{ $driver->name ?? 'User ' . $driver->user_id }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer border-0">
                                                                        <button type="submit"
                                                                            class="btn btn-success w-100 fw-bold">
                                                                            {{ __('penugasan_driver.save_assignment') }}
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- DELETE MODAL -->
                                                    <div class="modal fade" id="deleteTrashModal" tabindex="-1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content text-center text-white"
                                                                style="background:#34a853;">
                                                                <div class="modal-body">
                                                                    <i
                                                                        class="bi bi-exclamation-triangle-fill display-3 text-danger"></i>
                                                                    <h2 class="fw-bold mt-2">
                                                                        {{ __('penugasan_driver.delete_data') }}</h2>
                                                                    <p>{!! __('penugasan_driver.confirm_delete') !!}</p>

                                                                    <div class="d-flex justify-content-center gap-3">
                                                                        <button class="btn btn-light btn-lg px-5"
                                                                            data-bs-dismiss="modal">{{ __('penugasan_driver.cancel') }}</button>

                                                                        <form id="deleteTrashForm" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-lg px-5">{{ __('penugasan_driver.confirm') }}</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!-- ./card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
        <!--end::App Content-->
    </main>
@endsection
