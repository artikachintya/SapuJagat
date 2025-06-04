@extends('pengguna.partials.pengguna')

@section('title', 'Dashboard')

@push('scripts')
    <script src="{{ asset('assets/js/tarik-saldo.js') }}"></script>
@endpush
<script>
    
    const assetBasePath = "{{ asset('dashboard-assets/assets/img') }}";
</script>
@section('content')
<main class="app-main">
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row page-title">
        <div class="col-sm-6"><h3 class="mb-0"><b>Tarik Saldo Pengguna</b></h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tarik Saldo</li>
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
            <div class="col-12 col-sm-6 col-md-6 mx-auto">
                <div class="info-box card border-0 rounded-4 text-white overflow-hidden"
                    style="background: linear-gradient(90deg, #006837, #A8E6A1);">
                    <div class="card-body position-relative p-4">
                        <h5 class="fw-semibold">Saldo</h5>
                        <img src="{{ asset('dashboard-assets/assets/img/LogoLong.png') }}"
                            alt="Logo" class="position-absolute"
                            style="top: 1rem; right: 1rem; height: 40px;">
                        <h3 class="fw-bold mt-4">Rp{{$totalBalance}}</h3>
                        <p class="fw-semibold mb-0">{{ Auth::check() ? Auth::user()->name : 'User' }}'s Balance</p>
                        <img src="{{ asset('dashboard-assets/assets/img/trees.png') }}" 
                            alt="Trees" class="position-absolute bottom-0 end-0" 
                            style="height: 70px; opacity: 0.9;">
                    </div>
                </div>
            <!-- /.info-box -->
            </div>

            <!-- /.col -->
        </div>

        <div class="row">
            <div class="container my-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('pengguna.tarik-saldo.store') }}" method="POST">
                    @csrf
                    <div class="card border-0 rounded-4 overflow-hidden" style="background: linear-gradient(90deg, #D5F5DC, #A9DFBF);">
                        <div class="p-4">
                        <div class="row g-4">
                            <!-- Nominal Penarikan -->
                            <div class="col-md-6">
                            <h5 class="text-center fw-bold text-success">Nominal Penarikan</h5>
                            <input type="text" name="amount" class="form-control border border-success" placeholder="RpMinimum 100.000" value="{{ old('amount') }}" required>
                            <div class="alert alert-success d-flex align-items-center mt-3 p-2" role="alert" style="background-color: #D5F5DC;">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <small class="m-0">Dana dari penjualan sampah akan masuk ke rekening maksimal dalam 3 hari kerja.</small>
                            </div>
                            </div>

                            <!-- Transfer ke -->
                            <div class="col-md-6">
                            <h5 class="text-center fw-bold text-success">Transfer ke</h5>
                            <div class="border border-success rounded p-3 d-flex align-items-center"
                                data-bs-toggle="modal" data-bs-target="#bankModal" style="cursor: pointer;">
                                <img id="bankLogo"  src="{{ asset('dashboard-assets/assets/img/bca.png') }}" alt="BCA" style="height: 50px;" class="me-3">
                                <div>
                                <div>Bank: <strong id="displayBankName">Nama Bank</strong></div>
                                <div>Nomor Rekening: <b id="displayAccountNumber">xxxxxxxx</b></div>
                                </div>
                            </div>
                            </div>

                            <input type="hidden" name="bank" id="inputBankName" value="{{ old('bank') }}">
                            <input type="hidden" name="number" id="inputAccountNumber" value="{{ old(key: 'number') }}">

                        </div>
                        </div>

                        <div class="text-center mt-4 mb-4">
                        <button type="submit" class="btn btn-success px-5 py-2 rounded-pill fw-bold">Tarik Dana</button>
                        </div>
                    </div>
                </form>
            </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="bankModal" tabindex="-1" aria-labelledby="bankModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content rounded-4">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bankModalLabel">Edit Informasi Bank</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                            <label for="bankName" class="form-label">Nama Bank</label>
                            <input type="text" class="form-control" id="bankName" placeholder="BCA/BRI/MANDIRI">
                            </div>
                            <div class="mb-3">
                            <label for="accountNumber" class="form-label">Nomor Rekening</label>
                            <input type="text" class="form-control" id="accountNumber" placeholder="Contoh: 1234567890">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success" onclick="saveBankInfo()">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

        <!-- /.row -->
    <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->
</main>
@endsection
