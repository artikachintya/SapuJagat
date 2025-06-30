@extends('pengguna.partials.pengguna')

@section('title', 'Profile Pengguna')

@push('styles')
    @push('styles')
        <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/edit-profile.css') }}" rel="stylesheet">

    @endpush

    @push('scripts')
        <script>
            document.getElementById('profile_pic_upload').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('preview-image');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
        <script src="{{ asset('Auth/js/kota.js') }}"></script>
    @endpush




    @section('content')
        <main class="app-main">
            <!-- Header Section -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0"><b>Profile Saya</b></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-report p-4">
                                <!-- Card Title -->
                                <div class="card-title mb-4">
                                    <h5><b>Edit Profil</b></h5>
                                </div>

                                <!-- Content Body -->
                                <form action="{{ route('pengguna.profile.save') }}" id="bautai" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- Left: Profile Info -->
                                        <div class="col-md-8">
                                            <!-- Foto Profile + Edit Icon -->
                                            <div class="profile-pic mb-3 d-flex justify-content-center">
                                                <div class="profile-pic d-flex justify-content-center">
                                                    <img id="preview-image"
                                                        src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('assets/img/default-profile.webp') }}"
                                                        alt="Profile Picture" class="profile-picture">

                                                    <!-- Icon Kamera Edit -->
                                                    <label for="profile_pic_upload" class="edit-icon">
                                                        <i class="fas fa-camera"></i>
                                                    </label>

                                                    <input type="file" name="profile_pic" id="profile_pic_upload"
                                                        class="d-none">
                                                </div>
                                            </div>


                                            <!-- Form Fields -->
                                            <br><strong>Nama Lengkap</strong><br>
                                            <div class="info-card">
                                                <input type="text" name="name" class="form-control border-0 p-0"
                                                    value="{{ $user->name }}">
                                            </div>

                                            <strong>NIK</strong><br>
                                            <div class="info-card">
                                                <input type="text" name="NIK" class="form-control border-0 p-0"
                                                    value="{{ $user->NIK }}" disabled>
                                            </div>

                                            <strong>Email</strong><br>
                                            <div class="info-card">
                                                <input type="email" name="email" class="form-control border-0 p-0"
                                                    value="{{ $user->email }}">
                                            </div>

                                             <strong>Password</strong><br>
                                            <div class="info-card">
                                                <input type="password" name="password" class="form-control border-0 p-0"
                                                    value="********">
                                            </div>


                                            <div class="row">
                                                <div class="col-md-8">
                                                    <strong>Alamat</strong><br>
                                                    <div class="info-card">
                                                        <input type="text" name="address" class="form-control border-0 p-0"
                                                            value="{{ $user->info->address ?? '-' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Kode Pos</strong><br>
                                                    <div class="info-card">
                                                        <input type="text" name="postal_code"
                                                            class="form-control border-0 p-0"
                                                            value="{{ $user->info->postal_code ?? '-' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <strong>Provinsi</strong><br>
                                                    <div class="info-card">
                                                        <select name="province" id="province" class="form-select" required>
                                                            <option value="{{ $user->info->province ?? '' }}">
                                                                {{ $user->info->province ?? 'Pilih Provinsi' }}</option>
                                                            {{-- Option akan diisi oleh JS --}}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong>Kota</strong><br>
                                                    <div class="info-card">
                                                        <select name="city" id="city" class="form-select" required>
                                                            <option value="{{ $user->info->city ?? '' }}">
                                                                {{ $user->info->city ?? 'Pilih Kota' }}</option>
                                                            {{-- Option akan diisi oleh JS --}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <strong>Nomor Telepon</strong><br>
                                            <div class="info-card">
                                                <input type="text" name="phone_num" class="form-control border-0 p-0"
                                                    value="{{ $user->phone_num }}">
                                            </div>

                                            {{-- <button type="button" class="btn btn-success mt-3">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button> --}}

                                            {{-- <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal"> --}}
                                            <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal">
                                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                                            </button>

                                        </div>

                                        <!-- Right: Quotes Image -->
                                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('dashboard-assets/assets/img/Laporan-Quotes.png') }}"
                                                alt="Laporan Quotes" style="max-width: 100%;">
                                        </div>
                                    </div>
                                </form>

                                <!-- Modal Konfirmasi -->
                                <div class="modal fade my-auto mx-auto" id="confirmModal" tabindex="-1"
                                    aria-labelledby="confirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Simpan Perubahan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menyimpan perubahan ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn" style="border-color:black"
                                                    onclick="window.location.href='{{ route('pengguna.profile') }}'">Batal</button>
                                                <button type="button" class="btn btn-success"
                                                    onclick="document.getElementById('bautai').submit()">Ya, Simpan</button>
                                                {{-- <button type="button" class="btn btn-success">Ya, Simpan</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </main>
    @endsection
