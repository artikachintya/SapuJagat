
@extends('driver.partials.driver')

@section('title', 'Driver Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('pickup-driver/style.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('pickup-driver/script.js') }}"></script>
    <script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSyl20415rP3pIoG1-Y8TpZGqvbV3fEp6ONj&callback=initMap" async
        defer></script>
    {{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = {{ !$pickup->pick_up_date ? 1 : (!$pickup->arrival_date ? 2 : 3) }};
            const statusButton = document.querySelector('.btn-update-status button');
            const uploadForm = document.getElementById('upload-form');
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photo-preview');

            statusButton.addEventListener('click', async function() {
                if (currentStep === 3) {
                    if (photoInput.files.length === 0) {
                        alert('Harap unggah foto bukti terlebih dahulu');
                        return;
                    }
                    uploadForm.submit();
                    return;
                }

                try {
                    const response = await fetch("{{ route('driver.pickup.update-status', ['pickup' => $pickup->pick_up_id]) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            step: currentStep
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        currentStep++;
                        updateButtonText();

                        if (currentStep === 3) {
                            document.getElementById('upload-section').classList.remove('d-none');
                        }

                        // Optional: Reload the page to ensure sync with backend
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal memperbarui status');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui status');
                }
            });

            photoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                        photoPreview.classList.remove('d-none');
                    }
                    reader.readAsDataURL(file);
                }
            });

            function updateButtonText() {
                const texts = [
                    'Mulai Menjemput',
                    'Sampah Diambil',
                    'Sampah Tiba'
                ];
                statusButton.textContent = texts[currentStep - 1];
            }

            updateButtonText();
        });
    </script> --}}
@endpush

@section('content')
    <main class="app-main">
        <div id="map"></div>

        <div class="user-info container px-3">
            <!-- User info section remains the same -->
            <div class="row align-items-center flex-nowrap my-3 ">
                <div class="col-auto user-profile-icon px-0 mx-3">
                    <img src='https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(1).webp' class="rounded-circle" alt="Avatar"
                        width="60" height="60" style="object-fit: cover;" />
                </div>
                <div class="col user-details px-0">
                    <h4 class="mb-0 fw-bold">{{ $pickup->order->user->name ?? 'Nama Pelanggan' }}</h4>
                </div>
            </div>
            <div class="row user-address flex-nowrap">
                <i class="col-auto fa-solid fa-location-dot py-3 me-0 ms-2 px-0 fa-lg"></i>
                <p class="col user-address text-dark">
                    {{ $pickup?->order?->user?->info?->address ?? 'No address' }},
                    {{ $pickup?->order?->user?->info?->city ?? 'city' }},
                    {{ $pickup?->order?->user?->info?->province ?? 'province' }}
                    , {{ $pickup?->order?->user?->info?->postal_code ?? 'postal_code' }}
                </p>
            </div>
            <div class="user-notes">
                <h5 class="fw-bold">Bukti foto</h5>
                <img class="img-fluid rounded-3"
                    src="{{ asset('storage/' . $pickup->order->photo) ?? 'https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(1).webp' }}"
                    alt="Bukti Foto" />
                {{-- src="{{ optional($pickup->order)->photo ? asset('storage/' . $pickup->order->photo) : 'https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(1).webp' }}"
                    alt="Bukti Foto" /> --}}
            </div>

            <!-- Upload Section -->

            <div class="btn-section sticky-bottom">
                <div class="button-container d-flex justify-content-center align-items-center gap-4 mt-3">
                    <button class="btn btn-success rounded-circle p-4">
                        <i class="fa-solid fa-phone fa-2xl"></i>
                    </button>
                    <button class="btn btn-success rounded-circle p-4">
                        <i class="fa-solid fa-comments fa-2xl"></i>
                    </button>
                    <button class="btn btn-success rounded-circle p-4">
                        <i class="fa-solid fa-receipt fa-2xl"></i>
                    </button>
                </div>

                <div class="btn-update-status">
                    {{-- <button class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3" style="white-space:nowrap">
                        @if ($pickup->pick_up_date)
                            Sampah Telah Diterima
                        @elseif($pickup->start_time)
                            Sampah Diambil
                        @else
                            Mulai Menjemput
                        @endif
                    </button> --}}
                    <!-- Status update form -->
                    {{-- <form class="btn-update-status" method="POST"
                        action="{{ route('driver.pickup.update-status', $pickup->pick_up_id) }}">
                        @csrf
                        @if (!$pickup->start_time)
                            <!-- Step 1: Start Jemput -->
                            <input type="hidden" name="status" value="start_jemput">
                            <button type="submit" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3">
                                Mulai Menjemput
                            </button>
                        @elseif(!$pickup->pick_up_date)
                            <!-- Step 2: Sampah Diambil -->
                            <input type="hidden" name="status" value="pick_up">
                            <button type="submit" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3">
                                Sampah Diambil
                            </button>
                        @else
                            <div id="upload-section" class="{{ $pickup->pick_up_date ? '' : 'd-none' }}">
                                <h5 class="fw-bold mt-4">Upload Bukti Pengantaran</h5>
                                <form id="upload-form"
                                    action="{{ route('driver.pickup.upload-proof', $pickup->pick_up_id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="file" class="form-control" id="photo" name="photo"
                                            accept="image/*" required>
                                    </div>
                                    <div class="text-center mb-3">
                                        <img id="photo-preview" src="#" class="img-fluid rounded-3 d-none"
                                            alt="Preview" style="max-height: 200px;">
                                    </div>
                                </form>
                            </div>
                            <!-- Step 3: Pesanan Selesai -->
                            <input type="hidden" name="status" value="arrival">
                            <button type="submit" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3">
                                Pesanan Selesai
                            </button>
                            {{-- @else
                            <!-- Final State -->
                            <button type="button" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3"
                                disabled>
                                Selesai
                            </button> --}}
                        {{-- @endif
                    </form>--}}

                    <form class="btn-update-status" method="POST"
                        action="{{ route('driver.pickup.update-status', $pickup->pick_up_id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (!$pickup->start_time)
                            <!-- Step 1: Start Jemput -->
                            <input type="hidden" name="status" value="start_jemput">
                            <button type="submit" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3">
                                Mulai Menjemput
                            </button>
                        @elseif(!$pickup->pick_up_date)
                            <!-- Step 2: Sampah Diambil -->
                            <input type="hidden" name="status" value="pick_up">
                            <button type="submit" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3">
                                Sampah Diambil
                            </button>
                        @else
                            <!-- Step 3: Combined Arrival and Photo Upload -->
                            <input type="hidden" name="status" value="arrival">

                            <div id="upload-section">
                                <h5 class="fw-bold mt-4">Upload Bukti Pengantaran</h5>
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="photo" name="photo"
                                        accept="image/*" required>
                                </div>
                                <div class="text-center mb-3">
                                    <img id="photo-preview" src="#" class="img-fluid rounded-3 d-none" alt="Preview"
                                        style="max-height: 200px;">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3">
                                Penjemputan Selesai
                            </button>
                        @endif
                    </form>

                    <!-- Show upload form only after arrival_time is set -->
                    {{-- @if (!$pickup->arrival_date)
                        <div id="upload-section">
                            <h5 class="fw-bold mt-4">Upload Bukti Pengantaran</h5>
                            <form action="{{ route('driver.pickup.upload-proof', $pickup->pick_up_id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="photo" name="photo"
                                        accept="image/*" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Upload Bukti</button>
                            </form>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </main>
@endsection
