@extends('admin.partials.admin')

@section('title', 'Data Terhapus')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-sm">
                    <a href="{{ route('admin.penugasan.index') }}" class="btn btn-danger">Kembali</a>
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Penugasan Terhapus</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Penugasan yang Dihapus</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <table class="table table-striped align-middle">
                        <colgroup>
                            <col style="width: 5%;">    {{-- No --}}
                            <col style="width: 30%;">   {{-- Judul --}}
                            <col style="width: 25%;">   {{-- Lokasi --}}
                            <col style="width: 20%;">   {{-- Waktu --}}
                            <col style="width: 20%;">   {{-- Aksi --}}
                        </colgroup>

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Order ID</th>
                                <th>Nama Pengguna</th>
                                <th>Driver</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penugasans as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>#{{ $item->order->order_id ?? '-' }}</td>
                                    <td>{{ $item->order->user->name ?? '-' }}</td>
                                    <td>{{ $item->user->name ?? '-' }}</td>
                                    <td style="width: 1%; white-space: nowrap;">
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('admin.penugasan.restore', $item->penugasan_id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-arrow-clockwise"></i> Pulihkan
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.penugasan.forceDelete', $item->penugasan_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus permanen data ini?')" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash3"></i> Hapus Permanen
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-white">Tidak ada data terhapus</td>
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
