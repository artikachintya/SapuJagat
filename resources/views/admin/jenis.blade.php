@extends('admin.partials.admin')

@section('title', 'Dashboard')

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp


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

            /* ----------------- CREATE modal ----------------- */
            const createModal = document.getElementById('createTrashModal');

            createModal.addEventListener('show.bs.modal', () => {
                const form = createModal.querySelector('#createTrashForm');
                const photoInput = document.getElementById('createPhotoInput');
                const photoPreview = document.getElementById('createPhotoPreview');

                // reset the whole form every time it opens
                form.reset();
                photoPreview.src = '';
                photoPreview.style.display = 'none';
                photoInput.value = '';

                // live preview for newly chosen file
                photoInput.onchange = (e) => {
                    const [file] = e.target.files;
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (ev) => {
                            photoPreview.src = ev.target.result;
                            photoPreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                };
            });

            const editModal = document.getElementById('editTrashModal');
            editModal.addEventListener('show.bs.modal', (event) => {
                const btn = event.relatedTarget;
                const id = btn.dataset.id;
                // Blade generates the URL with a sentinel value “0”
                let routeTemplate = "{{ route('admin.jenis-sampah.update', 0) }}";
                // swap “0” with the real id
                routeTemplate = routeTemplate.replace(/0$/, id);

                const form = editModal.querySelector('#editTrashForm');
                form.action = routeTemplate;

                // Fill inputs
                form.name.value = btn.dataset.name;
                form.price_per_kg.value = btn.dataset.price_per_kg;
                form.max_weight.value = btn.dataset.max_weight;
                form.type.value = btn.dataset.type;

                const photoPreview = document.getElementById('photoPreview');
                const filename = btn.dataset.photo;

                if (filename) {
                    photoPreview.src = `{{ asset('assets/img') }}/${filename}`;
                    photoPreview.style.display = 'block';
                } else {
                    photoPreview.src = '';
                    photoPreview.style.display = 'none';
                }

                const fileInput = document.getElementById('photoInput');
                fileInput.value = ''; // reset previous selection
                fileInput.onchange = (e) => {
                    const [file] = e.target.files;
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (ev) => {
                            photoPreview.src = ev.target.result; // DataURL
                            photoPreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                };
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
                            <li class="breadcrumb-item"><a href="#">{{ __('trash_management.breadcrumb.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('trash_management.breadcrumb.dashboard') }}</a></li>
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
                                <h5 class="card-title">{{ __('trash_management.card.title') }}</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#createTrashModal">
                                        {{ __('trash_management.card.buttons.create') }}
                                    </button>

                                    <a href="{{ route('admin.jenis-sampah.arsip') }}" class="btn btn-warning btn-sm">
                                        {{ __('trash_management.card.buttons.archive') }}
                                    </a>
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
                                                <th>{{ __('trash_management.table.headers.id') }}</th>
                                                <th>{{ __('trash_management.table.headers.image') }}</th>
                                                <th>{{ __('trash_management.table.headers.name') }}</th>
                                                <th>{{ __('trash_management.table.headers.type') }}</th>
                                                <th>{{ __('trash_management.table.headers.price') }}</th>
                                                <th>{{ __('trash_management.table.headers.max_weight') }}</th>
                                                <th>{{ __('trash_management.table.headers.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($trashes as $trash)
                                                <tr>
                                                    <td>{{ $trash->trash_id }}</td>
                                                    <td><img src="{{ asset('assets/img/' . $trash->photos) }}"
                                                            alt="Foto Sampah" class="img-fluid" style="max-height: 150px;">
                                                    </td>
                                                    <td>{{ $trash->name }}</td>
                                                    <td>{{ $trash->type }}</td>
                                                    <td>{{ $trash->price_per_kg }}</td>
                                                    <td>{{ $trash->max_weight }} kg</td>
                                                    <td>
                                                        <div class="d-flex flex-column gap-2 align-items-center">
                                                            {{-- EDIT button – opens edit modal --}}
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm w-75 btn-edit"
                                                                data-bs-toggle="modal" data-bs-target="#editTrashModal"
                                                                data-id="{{ $trash->trash_id }}"
                                                                data-name="{{ $trash->name }}"
                                                                data-price_per_kg="{{ $trash->price_per_kg }}"
                                                                data-max_weight="{{ $trash->max_weight }}"
                                                                data-type="{{ $trash->type }}"
                                                                data-photo="{{ $trash->photos }}">
                                                                {{ __('trash_management.table.buttons.update') }}
                                                            </button>

                                                            {{-- DELETE button – opens delete modal --}}
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm w-75 btn-delete"
                                                                data-id="{{ $trash->trash_id }}"
                                                                data-action="{{ route('admin.jenis-sampah.destroy', $trash->trash_id) }}"
                                                                data-bs-toggle="modal" data-bs-target="#deleteTrashModal">
                                                                {{ __('trash_management.table.buttons.delete') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <!-- EDIT MODAL -->
                                                    <div class="modal fade" id="editTrashModal" tabindex="-1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content text-white"
                                                                style="background:#34a853;">
                                                                <div class="modal-header border-0">
                                                                    <h2 class="modal-title fw-bold w-100 text-center">
                                                                        {{ __('trash_management.modals.edit.title') }}</h2>
                                                                    <button type="button" class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>

                                                                <form id="editTrashForm" method="POST"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT') {{-- will remain for update --}}
                                                                    <div class="modal-body">

                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('trash_management.modals.create.fields.name') }}</label>
                                                                            <input type="text" name="name"
                                                                                class="form-control" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('trash_management.modals.create.fields.image') }}</label>

                                                                            {{-- give the input an ID --}}
                                                                            <input type="file" id="photoInput"
                                                                                name="photos" class="form-control"
                                                                                accept="image/*">

                                                                            {{-- the preview image --}}
                                                                            <img id="photoPreview" src=""
                                                                                alt="Foto Sampah" class="img-fluid mt-2"
                                                                                style="max-height:150px;display:none;">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('trash_management.modals.create.fields.type') }}</label>
                                                                            <input type="text" name="type"
                                                                                class="form-control" required>
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('trash_management.modals.create.fields.price') }}</label>
                                                                            <input type="number" name="price_per_kg"
                                                                                class="form-control" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('trash_management.modals.create.fields.max_weight') }}</label>
                                                                            <input type="number" name="max_weight"
                                                                                class="form-control">
                                                                        </div>

                                                                    </div>

                                                                    <div class="modal-footer border-0">
                                                                        <button type="submit"
                                                                            class="btn btn-light w-100 fw-bold">{{ __('trash_management.modals.edit.submit') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- CREATE MODAL -->
                                                    <div class="modal fade" id="createTrashModal" tabindex="-1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content text-white"
                                                                style="background:#34a853;">
                                                                <div class="modal-header border-0">
                                                                    <h2 class="modal-title w-100 text-center fw-bold">
                                                                        {{ __('trash_management.modals.create.title') }}
                                                                    </h2>
                                                                    <button type="button"
                                                                        class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>

                                                                <form id="createTrashForm"
                                                                    action="{{ route('admin.jenis-sampah.store') }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf

                                                                    <div class="modal-body">

                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('trash_management.modals.create.fields.name') }}</label>
                                                                            <input type="text" name="name"
                                                                                class="form-control" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('trash_management.modals.create.fields.image') }}</label>
                                                                            <input type="file" id="createPhotoInput"
                                                                                name="photos" class="form-control"
                                                                                accept="image/*">
                                                                            <img id="createPhotoPreview" src=""
                                                                                alt="Preview Gambar"
                                                                                class="img-fluid mt-2"
                                                                                style="max-height:150px;display:none;">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('trash_management.modals.create.fields.type') }}</label>
                                                                            <input type="text" name="type"
                                                                                class="form-control" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('trash_management.modals.create.fields.price') }}</label>
                                                                            <input type="number" name="price_per_kg"
                                                                                class="form-control" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('trash_management.modals.create.fields.max_weight') }}</label>
                                                                            <input type="number" name="max_weight"
                                                                                class="form-control">
                                                                        </div>

                                                                    </div>

                                                                    <div class="modal-footer border-0">
                                                                        <button type="submit"
                                                                            class="btn btn-light w-100 fw-bold">{{ __('trash_management.modals.create.submit') }}</button>
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
                                                                        {{ __('trash_management.modals.delete.title') }}
                                                                    </h2>
                                                                    <p>{{ __('trash_management.modals.delete.message') }}
                                                                    </p>

                                                                    <div class="d-flex justify-content-center gap-3">
                                                                        <button class="btn btn-light btn-lg px-5"
                                                                            data-bs-dismiss="modal">
                                                                            {{ __('trash_management.modals.delete.buttons.cancel') }}
                                                                        </button>

                                                                        <form id="deleteTrashForm" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-lg px-5">
                                                                                {{ __('trash_management.modals.delete.buttons.confirm') }}
                                                                            </button>
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
