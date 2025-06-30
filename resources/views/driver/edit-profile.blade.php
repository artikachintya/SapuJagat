@extends('driver.partials.driver')

@section('title', 'Profile Pengemudi')

@push('styles')
    <link href="{{ asset('assets/css/laporan.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/edit-profile.css') }}" rel="stylesheet">
    {{-- <style>
        .card-report {
            background-image: url(../assets/img/Card-Background.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style> --}}
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

@push('scripts')
    <script>
        function showError(input, message) {
            const errorSpan = input.parentElement.querySelector('.text-danger');
            errorSpan.textContent = message;
        }

        function clearError(input) {
            const errorSpan = input.parentElement.querySelector('.text-danger');
            errorSpan.textContent = '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.querySelector('input[name="name"]');
            const emailInput = document.querySelector('input[name="email"]');
            const passwordInput = document.querySelector('input[name="password"]');
            const phoneInput = document.querySelector('input[name="phone_num"]');
            const plateInput = document.querySelector('input[name="license_plate"]');

            nameInput.addEventListener('input', () => {
                nameInput.value.trim().length < 1 ?
                    showError(nameInput, 'Nama wajib diisi.') :
                    clearError(nameInput);
            });

            plateInput.addEventListener('input', () => {
                plateInput.value.trim().length < 1 ?
                    showError(plateInput, 'Plat Kendaraan wajib diisi.') :
                    clearError(plateInput);
            });

            emailInput.addEventListener('input', () => {
                const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                !pattern.test(emailInput.value) ?
                    showError(emailInput, 'Format email tidak valid.') :
                    clearError(emailInput);
            });

            passwordInput.addEventListener('input', () => {
                const val = passwordInput.value;
                const valid = val.length >= 8 && /[A-Z]/.test(val) && /[!@#$%^&*(),.?":{}|<>]/.test(val);
                (!val || valid) ?
                clearError(passwordInput): showError(passwordInput,
                    'Minimal 8 karakter, 1 huruf besar & 1 simbol.');
            });

            phoneInput.addEventListener('input', () => {
                const val = phoneInput.value;
                const isValid = /^\d{8,15}$/.test(val);
                isValid
                    ?
                    clearError(phoneInput) :
                    showError(phoneInput, 'No. telepon harus 8-15 digit.');
            });
        });

        document.getElementById('confirmSaveButton').addEventListener('click', function() {
            let isValid = true;

            // Inputs
            const name = document.querySelector('input[name="name"]');
            const email = document.querySelector('input[name="email"]');
            const password = document.querySelector('input[name="password"]');
            const phone = document.querySelector('input[name="phone_num"]');
              const plate = document.querySelector('input[name="license_plate"]');

            // Validate again before saving
            if (!name.value.trim()) {
                showError(name, 'Nama wajib diisi.');
                isValid = false;
            }

              if (!plate.value.trim()) {
                showError(plate, 'Plat Kendaraan wajib diisi.');
                isValid = false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email.value)) {
                showError(email, 'Format email tidak valid.');
                isValid = false;
            }

            const passVal = password.value;
            const passValid = passVal.length >= 8 && /[A-Z]/.test(passVal) && /[!@#$%^&*(),.?":{}|<>]/.test(
                passVal);
            if (passVal && !passValid) {
                showError(password, 'Minimal 8 karakter, 1 huruf besar & 1 simbol.');
                isValid = false;
            }

            if (!/^\d{8,15}$/.test(phone.value)) {
                showError(phone, 'No. telepon harus 8-15 digit.');
                isValid = false;
            }

            if (isValid) {
                document.getElementById('bautai').submit();
            }
        });
    </script>
@endpush



@section('content')
    <main class="app-main">
        <!-- Header Section -->
        {{-- <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0"><b>Profile Saya</b></h3>
                    </div>
                </div>
            </div>
        </div> --}}

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
                            <form action="{{ route('driver.profile.save') }}" id="bautai" method="POST" enctype="multipart/form-data">
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
                                                value="{{ $user->NIK }}">
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
                                                value="********">
                                            <small class="text-danger">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </small>
                                        </div>

                                        <strong>Nomor Telepon</strong><br>
                                        <div class="info-card">
                                            <input type="text" name="phone_num" class="form-control border-0 p-2"
                                                value="{{ $user->phone_num }}">
                                                 <small class="text-danger">
                                                        @error('address')
                                                            {{ $message }}
                                                        @enderror
                                                    </small>
                                        </div>

                                        <strong>Plat Kendaraan</strong><br>
                                        <div class="info-card">
                                            <input type="text" name="license_plate" class="form-control border-0 p-2"
                                                value="{{ $user->license->license_plate }}">
                                                 <small class="text-danger">
                                                        @error('license_plate')
                                                            {{ $message }}
                                                        @enderror
                                                    </small>
                                        </div>

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
                                                onclick="window.location.href='{{ route('driver.profile') }}'">Batal</button>
                                              <button type="button" class="btn btn-success" id="confirmSaveButton">
                                                Ya, Simpan
                                            </button>
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
