@extends('admin.partials.admin')

@section('title', 'Respon Laporan')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endpush
@push('styles')
<style>
    #laporanTable {
        --bs-table-bg: #026733; /* hijau gelap */
        --bs-table-color: #ffffff; /* teks putih */
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
        color: #ffffff !important;  /* <- INI PENTING */
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
                    <h3>Daftar Laporan dari Pengguna</h3>
                    {{-- <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
                    </ol> --}}
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
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
                <h5 class="card-title">Tabel Laporan Pengguna</h5>
            </div>
            <div class="card-body">
                <table id="laporanTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">ID User</th>
                            <th class="text-center">Nama Pelapor</th>
                            <th class="text-center">Isi Laporan</th>
                            <th class="text-center">Tanggal Laporan</th>
                            <th class="text-center">Tanggal Direspon</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
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
                                    <h5 class="modal-title" id="modalLabel{{ $report->report_id }}">Detail Laporan #{{ $report->report_id }}</h5>
                                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-dark">
                                    <p><strong>ID User:</strong> {{ $report->user->user_id }}</p>
                                    <p><strong>Nama Pelapor:</strong> {{ $report->user->name }}</p>
                                    <p><strong>Isi Laporan:</strong> {{ $report->report_message }}</p>
                                    <p><strong>Tanggal Laporan:</strong> {{ $report->date_time_report }}</p>
                                    <p><strong>Tanggal Direspon:</strong> {{ $report->response->date_time_response ?? '-' }}</p>
                                    <p><strong>Status:</strong>
                                        @if ($report->response)
                                            <span class="badge bg-success">Sudah Direspon</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum Direspon</span>
                                        @endif
                                    </p>
                                    @if ($report->photo)
                                        <p><strong>Foto Bukti:</strong></p>
                                        <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto Bukti" class="img-fluid mb-3 rounded shadow" style="max-height: 300px;">
                                    @endif
                                    @if ($report->response)
                                        <hr>
                                        <p><strong>Isi Respon:</strong> {{ $report->response->response_message }}</p>
                                        <p><strong>Admin:</strong> {{ $report->response->user->name ?? '-' }}</p>
                                    @endif
                                </div>

                                {{-- baru --}}
                                @if (!$report->response)
                                    <hr>
                                    <form action="{{ route('admin.laporan.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="report_id" value="{{ $report->report_id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">

                                        <div class="mb-3 mx-3">
                                            <label for="response_message" class="form-label">Tulis Respon Admin:</label>
                                            <textarea name="response_message" class="form-control" rows="4" required></textarea>
                                        </div>

                                        <div class="d-flex justify-content-end mb-3 mx-3">
                                            <button type="submit" class="btn btn-success">Kirim Respon</button>
                                        </div>
                                    </form>
                                @endif

                                {{-- <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div> --}}
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
                                    <span class="badge text-dark" style="background-color: rgb(35, 223, 73)">Sudah Direspon</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Direspon</span>
                                @endif
                            </td>
                            <td>
                                {{-- <a href="{{ route('admin.laporan.show', $report->report_id) }}" class="btn btn-info btn-sm">Detail</a>--}}
                                <button type="button"
                                    class="btn btn-sm"
                                    style="background-color: #E5F5E0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $report->report_id }}">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

                <!-- Pagination (jika pakai paginate()) -->
                {{-- <div class="mt-3">
                    {{ $reports->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</main>
@endsection
