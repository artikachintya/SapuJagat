@extends('pengguna.partials.pengguna')

@section('title', 'Profile Pengguna')

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/edit-profile.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script src="{{ asset('Auth/js/kota.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Image preview    
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

    // Form validation
    const nameInput = document.querySelector('input[name="name"]');
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.getElementById('password');
    const addressInput = document.querySelector('input[name="address"]');
    const postalInput = document.querySelector('input[name="postal_code"]');
    const phoneInput = document.querySelector('input[name="phone_num"]');

    let passwordChanged = false;

    function showError(input, message) {
        const errorSpan = input.parentElement.querySelector('.text-danger');
        errorSpan.textContent = message;
    }

    function clearError(input) {
        const errorSpan = input.parentElement.querySelector('.text-danger');
        errorSpan.textContent = '';
    }

    nameInput.addEventListener('input', () => {
        nameInput.value.trim().length < 1 ?
            showError(nameInput, 'Nama wajib diisi.') :
            clearError(nameInput);
    });

    addressInput.addEventListener('input', () => {
        addressInput.value.trim().length < 1 ?
            showError(addressInput, 'Alamat wajib diisi.') :
            clearError(addressInput);
    });

    emailInput.addEventListener('input', () => {
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        !pattern.test(emailInput.value) ?
            showError(emailInput, 'Format email tidak valid.') :
            clearError(emailInput);
    });

    passwordInput.addEventListener('input', () => {
        passwordChanged = true;
        const val = passwordInput.value;
        const valid = val.length >= 8 && /[A-Z]/.test(val) && /[!@#$%^&*(),.?":{}|<>]/.test(val);
        (!val || valid) ?
            clearError(passwordInput) :
            showError(passwordInput, 'Minimal 8 karakter, 1 huruf besar & 1 simbol.');
    });

    postalInput.addEventListener('input', () => {
        const val = postalInput.value;
        const isValid = /^\d{4,6}$/.test(val);
        isValid ? clearError(postalInput) : showError(postalInput, 'Kode pos harus 4-6 digit.');
    });

    phoneInput.addEventListener('input', () => {
        const val = phoneInput.value;
        const isValid = /^\d{8,15}$/.test(val);
        isValid ? clearError(phoneInput) : showError(phoneInput, 'No. telepon harus 8-15 digit.');
    });

    // Confirm Save button inside modal
    document.getElementById('confirmSaveButton').addEventListener('click', function () {
        let isValid = true;

        // Revalidate all fields before submission
        if (!nameInput.value.trim()) {
            showError(nameInput, 'Nama wajib diisi.');
            isValid = false;
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            showError(emailInput, 'Format email tidak valid.');
            isValid = false;
        }

        const passVal = passwordInput.value;
        if (passwordChanged && passVal) {
            const passValid = passVal.length >= 8 && /[A-Z]/.test(passVal) && /[!@#$%^&*(),.?":{}|<>]/.test(passVal);
            if (!passValid) {
                showError(passwordInput, 'Minimal 8 karakter, 1 huruf besar & 1 simbol.');
                isValid = false;
            }
        }

        if (!addressInput.value.trim()) {
            showError(addressInput, 'Alamat wajib diisi.');
            isValid = false;
        }

        if (!/^\d{4,6}$/.test(postalInput.value)) {
            showError(postalInput, 'Kode pos harus 4-6 digit.');
            isValid = false;
        }

        if (!/^\d{8,15}$/.test(phoneInput.value)) {
            showError(phoneInput, 'No. telepon harus 8-15 digit.');
            isValid = false;
        }

        if (isValid) {
            document.getElementById('bautai').submit();
        }
    });
});
</script>
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
                                            <input type="text" name="name" class="form-control border-0 p-2"
                                                value="{{ $user->name }}">
                                            <small class="text-danger">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </small>
                                        </div>

                                        <strong>NIK</strong><br>
                                        <div class="info-card">
                                            <input type="text" name="NIK" class="form-control border-0 p-2"
                                                value="{{ $user->NIK }}" disabled>

                                        </div>

                                        <strong>Email</strong><br>
                                        <div class="info-card">
                                            <input type="email" name="email" class="form-control border-0 p-2"
                                                value="{{ $user->email }}">
                                            <small class="text-danger">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </small>
                                        </div>

                                        <strong>Password</strong><br>
                                        <div class="info-card">
                                            <input type="password" name="password" class="form-control border-0 p-2"
                                                id="password" placeholder="********">
                                            <small class="text-danger">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </small>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong>Alamat</strong><br>
                                                <div class="info-card">
                                                    <input type="text" name="address" class="form-control border-0 p-2"
                                                        value="{{ $user->info->address ?? '-' }}">
                                                    <small class="text-danger">
                                                        @error('address')
                                                            {{ $message }}
                                                        @enderror
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Kode Pos</strong><br>
                                                <div class="info-card">
                                                    <input type="text" name="postal_code"
                                                        class="form-control border-0 p-2"
                                                        value="{{ $user->info->postal_code ?? '-' }}">
                                                    <small class="text-danger">
                                                        @error('postal_code')
                                                            {{ $message }}
                                                        @enderror
                                                    </small>
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
                                            <input type="text" name="phone_num" class="form-control border-0 p-2"
                                                value="{{ $user->phone_num }}">
                                            <small class="text-danger">
                                                @error('phone_num')
                                                    {{ $message }}
                                                @enderror
                                            </small>
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
                                        {{-- <button type="submit" class="btn btn-success mt-3">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button> --}}

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
                                            <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Simpan Perubahan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menyimpan perubahan ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn" style="border-color:black"
                                                onclick="window.location.href='{{ route('pengguna.profile') }}'">Batal</button>
                                            {{-- <button type="button" class="btn btn-success"
                                                    onclick="document.getElementById('bautai').submit()">Ya, Simpan</button> --}}
                                            {{-- <button type="button" class="btn btn-success"
                                                onclick="event.preventDefault(); document.getElementById('bautai').submit();">
                                                Ya, Simpan
                                            </button> --}}
                                            <button type="button" class="btn btn-success" id="confirmSaveButton">
                                                Ya, Simpan
                                            </button>

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
