@extends('admin.partials.admin')

@section('title', __('persetujuan.approval'))

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

        //function setApprovalStatus(status) {
        //   document.getElementById('approval_status').value = status;
        //}
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
                            <li class="breadcrumb-item active" aria-current="page">{{ __('persetujuan.dashboard') }}</li>
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
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary shadow-sm">
                                <i class="bi bi-cash"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('persetujuan.approved_transactions') }}</span>
                                <span class="info-box-number">
                                    {{ $transaksidisetujui }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- fix for small devices only -->
                    <!-- <div class="clearfix hidden-md-up"></div> -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary shadow-sm">
                                <i class="bi bi-recycle"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('persetujuan.rejected_transactions') }}</span>
                                <span class="info-box-number">
                                    {{ $transaksiditolak }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary shadow-sm">
                                <i class="bi bi-arrow-left-right"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ __('persetujuan.today_exchanges') }}</span>
                                <span class="info-box-number">
                                    {{ $transaksihariini }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
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
                                <h5 class="card-title">{{__('persetujuan.transaction_list')}}</h5>
                                <div class="card-tools">
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
                                                <th>{{ __('persetujuan.status') }}</th>
                                                <th>{{ __('persetujuan.date_time') }}</th>
                                                <th>{{ __('persetujuan.order_id') }}</th>
                                                <th>{{ __('persetujuan.user') }}</th>
                                                <th>{{ __('persetujuan.collector') }}</th>
                                                <th>{{ __('persetujuan.trash') }}</th>
                                                <th>{{ __('persetujuan.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ optional($order->approval)->approval_status == 2
                                                        ? __('persetujuan.pending')
                                                        : __('persetujuan.not_approved') }}
                                                    </td>
                                                    <td>
                                                        {{ __('persetujuan.user_request') }}:
                                                        {{ $order->date_time_request }}<br>
                                                        {{ __('persetujuan.pickup_schedule') }}:
                                                        {{ $order->pickup_time }}<br>
                                                        {{ __('persetujuan.collector_start') }}:
                                                        {{ $order->pickup->start_time ?? __('persetujuan.not_yet') }}<br>
                                                        {{ __('persetujuan.trash_collected') }}:
                                                        {{ $order->pickup->pick_up_date ?? __('persetujuan.not_yet') }}<br>
                                                        {{ __('persetujuan.trash_arrived') }}:
                                                        {{ $order->pickup->arrival_date ?? __('persetujuan.not_yet') }}<br>
                                                    </td>
                                                    </td>

                                                    <td>{{ $order->order_id }}</td>

                                                    <td>{{ $order->user->name ?? '-' }}</td>

                                                    <td>{{ $order->pickup->user->name ?? '-' }}</td>

                                                    <td>
                                                        @foreach ($order->details as $detail)
                                                            {{ $detail->trash->name ?? 'Jenis Tidak Diketahui' }}:
                                                            {{ $detail->quantity }} kg<br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column gap-2 align-items-center">
                                                            <button type="button" class="btn btn-sm"
                                                                style="background-color: #E5F5E0" data-bs-toggle="modal"
                                                                data-bs-target="#detailModal{{ $order->order_id }}">
                                                                {{__('persetujuan.respond')}}
                                                            </button>
                                                        </div>
                                                    </td>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="detailModal{{ $order->order_id }}"
                                                        tabindex="-1" aria-labelledby="modalLabel{{ $order->order_id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                            <div class="modal-content rounded-4">
                                                                <div
                                                                    class="modal-header bg-success text-white rounded-top-4">
                                                                    <h5 class="modal-title"
                                                                        id="modalLabel{{ $order->order_id }}">Detail Order
                                                                        #{{ $order->order_id }}</h5>
                                                                    <button type="button" class="btn-close bg-white"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body text-dark bg-light">

                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <p><strong>{{ __('persetujuan.order_id') }}:</strong>
                                                                                {{ $order->order_id }}</p>
                                                                            <p><strong>{{ __('persetujuan.admin') }}:</strong>
                                                                                {{ $order->approval->user->name ?? '-' }}
                                                                            </p>
                                                                            <p><strong>{{ __('persetujuan.user') }}:</strong>
                                                                                {{ $order->user->name }}</p>
                                                                            <p><strong>{{ __('persetujuan.collector') }}:</strong>
                                                                                {{ $order->pickup->user->name }}</p>
                                                                            <p><strong>{{ __('persetujuan.request_date') }}</strong>
                                                                                {{ $order->pickup->start_time ?? '-' }},
                                                                                {{ $order->pickup->pick_up_date ?? '-' }}
                                                                            </p>
                                                                            <p><strong>{{ __('persetujuan.pickup_date') }}:</strong>
                                                                                {{ $order->pickup->pick_up_date ?? '-' }}
                                                                            </p>
                                                                            <p><strong>{{ __('persetujuan.completion_date') }}:</strong>
                                                                                {{ $order->pickup->arrival_date ?? '-' }}
                                                                            </p>
                                                                            <p><strong>{{ __('persetujuan.latest_admin_response') }}:</strong>
                                                                                {{ $order->approval->date_time ?? '-' }}
                                                                            </p>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <p><strong>{{ __('persetujuan.trash_types') }}:</strong>
                                                                                @foreach ($order->details as $detail)
                                                                                    {{ $detail->trash->name }}:
                                                                                    {{ $detail->quantity }} KG<br>
                                                                                @endforeach
                                                                            </p>
                                                                            @php $total = 0; @endphp
                                                                            @foreach ($order->details as $detail)
                                                                                @php $total += $detail->trash->price_per_kg * $detail->quantity; @endphp
                                                                            @endforeach
                                                                            <p><strong>{{ __('persetujuan.trash_weight') }}:</strong>
                                                                                {{ $order->details->sum('quantity') }} KG
                                                                            </p>
                                                                            <p><strong>{{ __('persetujuan.total_price') }}:</strong>
                                                                                Rp
                                                                                {{ number_format($total, 0, ',', '.') }}
                                                                            </p>
                                                                            <p><strong>{{ __('persetujuan.collector_notes') }}:</strong>
                                                                            </p>
                                                                            <div
                                                                                class="bg-success-subtle text-dark p-2 rounded">
                                                                                {{ $order->pickup->notes ?? '-' }}</div>
                                                                            <p class="mt-3"><strong>Status:</strong></p>
                                                                            @php
                                                                                $statusText = __(
                                                                                    'persetujuan.no_response',
                                                                                );
                                                                                $statusColor = 'bg-secondary-subtle';

                                                                                if ($order->approval) {
                                                                                    switch (
                                                                                        $order->approval
                                                                                            ->approval_status
                                                                                    ) {
                                                                                        case 0:
                                                                                            $statusText = __(
                                                                                                'persetujuan.rejected',
                                                                                            );
                                                                                            $statusColor =
                                                                                                'bg-danger-subtle text-danger';
                                                                                            break;
                                                                                        case 1:
                                                                                            $statusText = __(
                                                                                                'persetujuan.approved',
                                                                                            );
                                                                                            $statusColor =
                                                                                                'bg-success-subtle text-success';
                                                                                            break;
                                                                                        case 2:
                                                                                            $statusText = __(
                                                                                                'persetujuan.waiting',
                                                                                            );
                                                                                            $statusColor =
                                                                                                'bg-warning-subtle text-warning';
                                                                                            break;
                                                                                    }
                                                                                }
                                                                            @endphp

                                                                            <div
                                                                                class="p-2 rounded fw-bold {{ $statusColor }}">
                                                                                {{ $statusText }}
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-4 text-center">
                                                                        <div class="col-md-6">
                                                                            <p class="fw-bold">
                                                                                {{ __('persetujuan.user_evidence') }}</p>
                                                                            @if ($order->photo)
                                                                                <img src="{{ asset('storage/' . $order->photo) }}"
                                                                                    class="img-fluid rounded shadow"
                                                                                    style="max-height: 200px;">
                                                                            @else
                                                                                <p>{{ __('persetujuan.no_photo') }}</p>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="fw-bold">
                                                                                {{ __('persetujuan.collector_evidence') }}
                                                                            </p>
                                                                            @if ($order->pickup_photos)
                                                                                <img src="{{ asset('storage/' . $order->pickup_photos) }}"
                                                                                    class="img-fluid rounded shadow"
                                                                                    style="max-height: 200px;">
                                                                            @else
                                                                                <p>{{ __('persetujuan.no_photo') }}</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    @if ($order->approval)
                                                                        <hr>
                                                                        <p><strong>{{ __('persetujuan.previous_admin_response') }}</strong>
                                                                        </p>
                                                                        <div class="bg-light border p-2 rounded">
                                                                            {{ $order->approval->notes }}
                                                                        </div>
                                                                    @endif

                                                                    <hr>

                                                                    <form action="{{ route('admin.persetujuan.store') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="order_id"
                                                                            value="{{ $order->order_id }}">
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ auth()->user()->user_id }}">
                                                                        <input type="hidden" name="approval_status"
                                                                            id="approval_status" value="">

                                                                        <div class="mb-3">
                                                                            <label for="notes"
                                                                                class="form-label fw-bold">{{ __('persetujuan.write_admin_response') }}</label>
                                                                            <textarea name="notes" class="form-control bg-success-subtle" rows="4"
                                                                                placeholder="{{ __('persetujuan.response_placeholder') }}" required></textarea>
                                                                        </div>

                                                                        <div class="d-flex justify-content-around">
                                                                            <button type="submit" class="btn px-4"
                                                                                style="background-color: #006B4F; color: white;"
                                                                                name="approval_status"
                                                                                value="1">{{ __('persetujuan.approve') }}</button>
                                                                            <button type="submit" class="btn px-4"
                                                                                style="background-color: #5C2E00; color: white;"
                                                                                name="approval_status"
                                                                                value="0">{{ __('persetujuan.reject') }}</button>
                                                                            <button type="submit" class="btn px-4"
                                                                                style="background-color: #777000; color: white;"
                                                                                name="approval_status"
                                                                                value="2">{{ __('persetujuan.pending_action') }}</button>
                                                                        </div>
                                                                    </form>

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
