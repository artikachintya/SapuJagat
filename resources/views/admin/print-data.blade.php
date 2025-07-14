@extends('admin.partials.admin')

@section('content')
    <main class="app-main">
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-12">

                    <!-- Flash error -->
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filter Form -->
                    <div class="card p-4 mb-4">
                        <form method="POST" action="{{ route('admin.print-data.filter') }}">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3 col-sm-6">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ old('start_date', session('start_date')) }}">
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ old('end_date', session('end_date')) }}">
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="category" class="form-label">Kategori</label>
                                    <select name="category" id="category" class="form-select">
                                        <option disabled {{ request('category') ? '' : 'selected' }}>Pilih Kategori</option>
                                        <option value="order" {{ session('category') == 'order' ? 'selected' : '' }}>Sampah
                                        </option>
                                        <option value="withdraw" {{ session('category') == 'withdraw' ? 'selected' : '' }}>
                                            Withdraw</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-check-circle"></i> Tampilkan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Invoice -->
                    <div class="p-4 mb-4 bg-light rounded">
                        <div class="row border-bottom pb-2 mb-3">
                            <div class="col-6">
                                <h4><i class="fas fa-globe"></i> Sapu Jagat, Inc.</h4>
                            </div>
                            <div class="col-6 text-end">
                                <small>Date: {{ now()->format('d/m/Y') }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>From</strong>
                                <address>
                                    {{ $admin->name }}<br>
                                    Phone: {{ $admin->phone_num }}<br>
                                    Email: {{ $admin->email }}
                                </address>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table" style="background-color: #015730; color: white;">
                                <thead>
                                    <tr>
                                        @if ($category === 'order' || $category === 'withdraw')
                                            <th>No</th>
                                        @endif

                                        @if ($category === 'order')
                                            <th>Nama Sampah</th>
                                            <th>Type</th>
                                            <th>Total</th>
                                        @elseif ($category === 'withdraw')
                                            <th>Bank</th>
                                            <th>Total Withdraw</th>
                                        @else
                                            <th colspan="3" class="text-center">Silakan pilih kategori di atas</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $index => $item)
                                        <tr>
                                            @if ($category === 'order' || $category === 'withdraw')
                                                <td>{{ $index + 1 }}</td>
                                            @endif

                                            @if ($category === 'order')
                                                <td>{{ $item->trash_name }}</td>
                                                <td>{{ $item->type }}</td>
                                                <td>{{ number_format($item->total_weight, 0, ',', '.') }}</td>
                                            @elseif ($category === 'withdraw')
                                                <td>{{ $item->bank }}</td>
                                                <td>Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                                            @endif
                                        </tr>
                                    @empty
                                        @if ($category)
                                            <tr>
                                                <td colspan="4" class="text-center text-white">Tidak ada data pada periode ini.</td>
                                            </tr>
                                        @endif
                                    @endforelse

                                    @if ($data->isNotEmpty())
                                        <tr style="background-color: #015730; color: white;">
                                            @if ($category === 'order')
                                                <td colspan="3" class="text-end"><strong>Total Berat:</strong></td>
                                                <td><strong>{{ number_format($data->sum('total_weight'), 0, ',', '.') }}</strong>
                                                </td>
                                            @elseif ($category === 'withdraw')
                                                <td colspan="2" class="text-end"><strong>Total :</strong></td>
                                                <td><strong>Rp {{ number_format($data->sum('total_amount'), 0, ',', '.') }}</strong>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>


                        {{-- Tombol Generate PDF --}}
                        @if (session('category') && session('start_date') && session('end_date') && $data->isNotEmpty())
                            <div class="d-flex justify-content-end mt-3">
                                <form method="POST" action="{{ route('admin.print-data.pdf') }}" target="_blank">
                                    @csrf
                                    <input type="hidden" name="category" value="{{ session('category') }}">
                                    <input type="hidden" name="start_date" value="{{ session('start_date') }}">
                                    <input type="hidden" name="end_date" value="{{ session('end_date') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-download"></i> Generate PDF
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection