@extends('driver.partials.driver')

@section('title', __('pickup_detail.title'))

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

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

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
                       <h4 class="mb-0 fw-bold">
  {{ $pickup->order->user->name ?? __('pickup_detail.customer.default_name') }}
</h4>
                    </div>
                </div>
                <div>
                    {{-- <button class="btn btn-success rounded-circle" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-comments fa-xl"></i>
                    </button> --}}
                    @if ($chat)
                        {{-- <a href="{{ route('driver.chat', $chat->chat_id) }}" --}}
                        {{-- <a href="{{ route('driver.chat', ['chat_id' => $chat->chat_id, 'pickup_id' => $pickup->pick_up_id]) }}"
                        class="btn btn-success rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 60px; height: 60px; position: relative; z-index: 999;"
                        title="Buka Chat">
                            <i class="fa-solid fa-comments fa-xl text-white"></i>
                        </a> --}}

                        <a href="{{ URL::signedRoute('driver.chat', ['chat_id' => $chat->chat_id, 'pickup_id' => $pickup->pick_up_id]) }}"
                        class="btn btn-success rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 60px; height: 60px; position: relative; z-index: 999;"
                        title="Buka Chat">
                            <i class="fa-solid fa-comments fa-xl text-white"></i>
                        </a>
                    @endif
                </div>
            </div>

            <div class="row user-address flex-nowrap">
                <i class="col-auto fa-solid fa-location-dot py-3 me-0 ms-2 px-0 fa-lg"></i>
               <p class="col user-address text-dark fs-5">
  {{ $pickup?->order?->user?->info?->address ?? __('pickup_detail.customer.default_address') }},
  {{ $pickup?->order?->user?->info?->city ?? __('pickup_detail.customer.default_city') }},
  {{ $pickup?->order?->user?->info?->province ?? __('pickup_detail.customer.default_province') }},
  {{ $pickup?->order?->user?->info?->postal_code ?? __('pickup_detail.customer.default_postal') }}
</p>
            </div>

            <div class="user-notes">
                <h5 class="fw-bold">{{ __('pickup_detail.elements.photo_evidence') }}</h5>
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
                                {{ __('pickup_detail.buttons.start_pickup') }}
                            </button>
                        </form>
                    @elseif (!$pickup->pick_up_date)
                        <!-- Sampah Diambil -->
                        <form method="POST" action="{{ route('driver.pickup.update-status', $pickup->pick_up_id) }}">
                            @csrf
                            <input type="hidden" name="status" value="pick_up">
                            <button type="submit" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3">
                                {{ __('pickup_detail.buttons.waste_picked') }}
                            </button>
                        </form>
                    @else
                        <!-- Penjemputan Selesai -->
                        <form method="POST" action="{{ route('driver.pickup.update-status', $pickup->pick_up_id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="status" value="arrival">

                            <div id="upload-section">
                                <h5 class="fw-bold mt-4">{{ __('pickup_detail.elements.upload_section.title') }}</h5>
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                                </div>
                                <div class="text-center mb-3">
                                    <img id="photo-preview" src="#" class="img-fluid rounded-3 d-none" alt="Preview"
                                        style="max-height: 200px;">
                                </div>
                            </div>

                            <button type="submit" id="submit-arrival" class="btn btn-success w-100 fw-bold fs-2 py-2 rounded-pill my-3" disabled>
                                {{ __('pickup_detail.buttons.complete_pickup') }}
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
                <h4 class="text-success">{{ __('pickup_detail.success_popup.title') }}</h4>
        <p class="mb-0">{!! __('pickup_detail.success_popup.message') !!}</p>
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
