@extends('admin.partials.admin')

@section('title', 'Data Terhapus')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-sm">
                    <a href="{{ route('admin.jenis-sampah.index') }}" class="btn btn-danger">Kembali</a>
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sampah Terhapus</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Sampah yang Dihapus</h5>
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
                            <col style="width: 5%;">    {{-- ID --}}
                            <col style="width: 20%;">   {{-- Nama --}}
                            <col style="width: 15%;">   {{-- Jenis --}}
                            <col style="width: 15%;">   {{-- Harga --}}
                            <col style="width: 15%;">   {{-- Maksimal --}}
                            <col style="width: 30%;">   {{-- Aksi --}}
                        </colgroup>

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Harga</th>
                                <th>Maksimal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($trashes as $trash)
                                <tr>
                                    <td>{{ $trash->trash_id }}</td>
                                    <td>{{ $trash->name }}</td>
                                    <td>{{ $trash->type }}</td>
                                    <td>{{ $trash->price_per_kg }}</td>
                                    <td >{{ $trash->max_weight }} kg</td>
                                    <td style="width: 1%; white-space: nowrap;">
                                        <div class="d-flex gap-2">
                                            <form method="POST" action="{{ route('admin.jenis-sampah.restore', $trash->trash_id) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-arrow-clockwise"></i> Pulihkan
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.jenis-sampah.force-delete', $trash->trash_id) }}" onsubmit="return confirm('Yakin hapus permanen?')" style="display: inline;">
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
                                    <td colspan="6" class="text-center text-muted">Tidak ada data terhapus</td>
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
