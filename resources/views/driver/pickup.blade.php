@extends('driver.partials.driver')

@section('title', 'Pick Up Detail')

@push('styles')
    <link rel="stylesheet" href="{{ asset('pickup-driver/style.css') }}">
    <style>
        button:disabled {
            background-color: #cccccc !important;
            border-color: #cccccc !important;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')
@if ($pickup)
    <main class="app-main">
        <div id="map" style="height:400px">
            <img class="img-fluid w-100 h-100" src="{{ asset('assets/img/map.jpeg') }}" alt="">
        </div>

        <div class="user-info container px-3">
            <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <img src='{{ $pickup->order->user->profile_pic ? asset('storage/' . $pickup->order->user->profile_pic) : asset('assets/img/default-profile.webp') }}'
                        class="rounded-circle" alt="Avatar" width="60" height="60" style="object-fit: cover;" />
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $pickup->order->user->name ?? 'Nama Pelanggan' }}</h4>
                    </div>
                </div>
                <div>
                    <button class="btn btn-success rounded-circle" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-comments fa-xl"></i>
                    </button>
                </div>
            </div>

            <div class="row user-address flex-nowrap">
                <i class="col-auto fa-solid fa-location-dot py-3 me-0 ms-2 px-0 fa-lg"></i>
                <p class="col user-address text-dark fs-5">
                    {{ $pickup?->order?->user?->info?->address ?? 'No address' }},
                    {{ $pickup?->order?->user?->info?->city ?? 'city' }},
                    {{ $pickup?->order?->user?->info?->province ?? 'province' }},
                    {{ $pickup?->order?->user?->info?->postal_code ?? 'postal_code' }}
                </p>
            </div>

            <div class="user-notes">
                <h5 class="fw-bold">Bukti foto</h5>
                <img class="img-fluid rounded-3"
                    src="{{ asset('storage/' . $pickup->order->photo) ?? 'https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(1).webp' }}"
                    alt="Bukti Foto" />
            </div>

            <div class="btn-section sticky-bottom">
                <div class="btn-update-status">
                    @if (!$pickup->start_time)
                        <!-- Start Jemput -->
                        <form method="POST" action="{{ route('driver.pickup.update-status', $pickup->pick_up_id) }}">
                            @csrf
                            <input type="hidden" name="status" value="start_jemput">
                            <button type="submit" class="btn btn-success w-100 fw-bold fs-2 rounded-pill">
                                Mulai Menjemput
                            </button>
                        </form>
                    @elseif (!$pickup->pick_up_date)
                        <!-- Sampah Diambil -->
                        <form method="POST" action="{{ route('driver.pickup.update-status', $pickup->pick_up_id) }}">
                            @csrf
                            <input type="hidden" name="status" value="pick_up">
                            <button type="submit" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3">
                                Sampah Diambil
                            </button>
                        </form>
                    @else
                        <!-- Penjemputan Selesai -->
                        <form method="POST" action="{{ route('driver.pickup.update-status', $pickup->pick_up_id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="status" value="arrival">

                            <div id="upload-section">
                                <h5 class="fw-bold mt-4">Upload Bukti Pengantaran</h5>
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                                </div>
                                <div class="text-center mb-3">
                                    <img id="photo-preview" src="#" class="img-fluid rounded-3 d-none" alt="Preview"
                                        style="max-height: 200px;">
                                </div>
                            </div>

                            <button type="submit" id="submit-arrival" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3" disabled>
                                Penjemputan Selesai
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endif

@if (session('finished'))
    <div id="finished-popup" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4 text-center">
                <h4 class="text-success">🎉 Yeay! Kamu telah menyelesaikan order!</h4>
                <p class="mb-0">Terima kasih telah menjemput sampah pelanggan.<br>
                Kamu akan diarahkan ke daftar pickup dalam 5 detik...</p>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function () {
            window.location.href = "{{ route('driver.dashboard') }}";
        }, 5000);
    </script>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const photoInput = document.getElementById('photo');
        const submitButton = document.getElementById('submit-arrival');

        if (photoInput && submitButton) {
            photoInput.addEventListener('change', function () {
                if (photoInput.files.length > 0) {
                    submitButton.disabled = false;
                } else {
                    submitButton.disabled = true;
                }
            });
        }

        // Preview foto tetap jalan
        photoInput?.addEventListener("change", function (event) {
            const preview = document.getElementById("photo-preview");
            const file = event.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove("d-none");
            }
        });
    });
</script>
@endpush
