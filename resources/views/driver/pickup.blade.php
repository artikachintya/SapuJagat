@extends('driver.partials.driver')

@section('title', 'Driver Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('pickup-driver/style.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('pickup-driver/script.js') }}"></script>
@endpush

@section('content')
    @if ($pickup)
        <!-- SHOW DRIVER INFO, PICKUP STATUS, BUTTONS -->
        <main class="app-main">

            <div id="map" style="height:400px">
                <img class="img-fluid w-100 h-100" src="{{ asset('assets/img/map.jpeg') }}" alt="">
            </div>

            <div class="user-info container px-3">
                <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                    <!-- Profile Picture -->
                    <div class="d-flex align-items-center gap-2">
                        <img src='{{ $pickup->order->user->profile_pic ? asset('storage/' . $pickup->order->user->profile_pic) : asset('assets/img/default-profile.webp') }}'
                            class="rounded-circle" alt="Avatar" width="60" height="60"
                            style="object-fit: cover;" />

                        <!-- Name -->
                        <div>
                            <h4 class="mb-0 fw-bold">{{ $pickup->order->user->name ?? 'Nama Pelanggan' }}</h4>
                        </div>
                    </div>

                    <!-- Chat Button -->
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
                <!-- Step 3: Combined Arrival and Photo Upload -->
                @if ($pickup->pick_up_date)
                    <input type="hidden" name="status" value="arrival">

                    <div id="upload-section">
                        <h5 class="fw-bold mt-4">Upload Bukti Pengantaran</h5>
                        <div class="mb-3">
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*"
                                required>
                        </div>
                        <div class="text-center mb-3">
                            <img id="photo-preview" src="#" class="img-fluid rounded-3 d-none" alt="Preview"
                                style="max-height: 200px;">
                        </div>
                    </div>
                @endif

                <!-- Upload Section -->

                <div class="btn-section sticky-bottom">
                    <div class="btn-update-status">
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
                                {{-- <!-- Step 3: Combined Arrival and Photo Upload -->
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
                            </div> --}}

                                <button type="submit" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3">
                                    Penjemputan Selesai
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </main>
    @else
        <!-- SHOW EMPTY STATE -->
        <main class="app-main d-flex justify-content-center align-items-center text-center" style="height: 100vh;">
            <div>
                <img src="{{ asset('assets/img/resting-driver.png') }}" alt="No Order" class="img-fluid mb-4"
                    style="max-height: 200px;">
                <h2 class="fw-bold">Belum ada order penjemputan</h2>
                <p class="fs-5">Saatnya istirahat sejenak, kami akan beri tahu jika ada pesanan baru 😌</p>
            </div>
        </main>
    @endif
@endsection
