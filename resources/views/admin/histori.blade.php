@extends('admin.partials.admin')

@section('title', 'Histori Transaksi')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
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
        document.addEventListener('DOMContentLoaded', function() {
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
                        <h3>Histori Penukaran Pengguna</h3>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card mt-1">
                <div class="card-body">
                    <table id="laporanTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ID Order</th>
                                <th class="text-center">ID User</th>
                                <th class="text-center">Jenis Sampah</th>
                                <th class="text-center">Kuantiti</th>
                                <th class="text-center">Biaya</th>
                                <th class="text-center">Tanggal Selesai</th>
                                <th class="text-center">Tanggal Disetujui</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->order_id }}</td>
                                    <td class="text-center">{{ $order->user_id }}</td>
                                    <td class="text-center">{{ $order->details->pluck('trash.name')->join(', ') }}</td>
                                    <td class="text-center">{{ $order->details->sum('quantity') }} Kg</td>
                                    <td class="text-center">
                                        Rp{{ number_format(
                                            $order->details->sum(fn($detail) => $detail->quantity * ($detail->trash->price_per_kg ?? 0)),
                                            0,
                                            ',',
                                            '.',
                                        ) }}
                                    </td>
                                    <td class="text-center">{{ $order->pickup->arrival_date ?? '-' }}</td>
                                    <td class="text-center">{{ $order->approval->date_time ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($order->approval)
                                            @if ($order->approval->status === 1)
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($order->approval->status === 0)
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Dalam Proses</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Belum Ada Persetujuan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $order->order_id }}">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Detail Modals --}}
            @foreach ($orders as $order)
                <div class="modal fade" id="detailModal{{ $order->order_id }}" tabindex="-1"
                    aria-labelledby="modalLabel{{ $order->order_id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="modalLabel{{ $order->order_id }}">Detail Order
                                    #{{ $order->order_id }}</h5>
                                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-dark">
                                <p><strong>ID User:</strong> {{ $order->user->user_id ?? '-' }}</p>
                                <p><strong>Nama Pelanggan:</strong> {{ $order->user->name ?? '-' }}</p>
                                <p><strong>Tanggal/Waktu Permintaan:</strong> {{ $order->date_time_request }}</p>
                                <p><strong>Tanggal/Waktu Penjemputan:</strong> {{ $order->pickup->pick_up_date ?? '-' }}
                                </p>
                                <p><strong>Tanggal/Waktu Selesai Penjemputan:</strong>
                                    {{ $order->pickup->arrival_date ?? '-' }}
                                </p>
                                <p><strong>Tanggal Pengecekan:</strong>
                                    @if ($order->approval && $order->approval->status != 2)
                                        {{ $order->approval->date_time }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p><strong>Status:</strong>
                                    @if ($order->approval)
                                        @if ($order->approval->status === 1)
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($order->approval->status === 0)
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Dalam Proses</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Belum Ada Persetujuan</span>
                                    @endif
                                </p>

                                {{-- Summary Table --}}
                                @php
                                    $htmlSummary = '<table class="table table-bordered text-sm"><thead><tr>
                                    <th>No</th><th>Nama Sampah</th><th>Kuantitas</th><th>Harga/kg</th><th>Total</th>
                                </tr></thead><tbody>';
                                    $total = 0;
                                    foreach ($order->details as $index => $detail) {
                                        $qty = $detail->quantity;
                                        $price = $detail->trash->price_per_kg ?? 0;
                                        $subtotal = $qty * $price;
                                        $total += $subtotal;
                                        $htmlSummary .=
                                            "<tr>
                                        <td>" .
                                            ($index + 1) .
                                            "</td>
                                        <td>{$detail->trash->name}</td>
                                        <td>{$qty}</td>
                                        <td>Rp. " .
                                            number_format($price, 0, ',', '.') .
                                            "</td>
                                        <td>Rp. " .
                                            number_format($subtotal, 0, ',', '.') .
                                            "</td>
                                    </tr>";
                                    }
                                    $htmlSummary .=
                                        "<tr><td colspan='4'><b>Total yang Diperoleh</b></td>
                                    <td><b>Rp. " .
                                        number_format($total, 0, ',', '.') .
                                        '</b></td></tr>';
                                    $htmlSummary .= '</tbody></table>';
                                @endphp

                                {!! $htmlSummary !!}

                                <div style="display: flex; gap: 20px;">
                                    <div>
                                        <p><strong>Bukti Pengguna:</strong></p>
                                        <img src="{{ asset('storage/' . $order->photo) }}" alt="Bukti Pengguna"
                                            style="width: 350px; height: auto;">
                                    </div>

                                    <div>
                                        <p><strong>Bukti Pengantaran Driver:</strong></p>
                                        @if (!empty($order->pickup->photos))
                                            <img src="{{ asset('storage/' . $order->pickup->photos) }}"
                                                alt="Bukti Pengantaran" style="width: 350px; height: auto;">
                                        @else
                                            <p>Tidak ada foto.</p>
                                        @endif
                                    </div>
                                </div>

                                <div style="display: flex; gap: 20px;">
                                    <div class="mt-3"style="flex: 1;">
                                        <p><strong>Respon Admin:</strong><br>
                                            {{ $order->approval->notes ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="mt-3" style="flex: 1;">
                                        <p><strong>Catatan Driver:</strong><br>
                                            {{ $order->pickup->notes ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- <a class="btn btn-warning" role="button" aria-disabled="true">Arsipkan</a> --}}

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
