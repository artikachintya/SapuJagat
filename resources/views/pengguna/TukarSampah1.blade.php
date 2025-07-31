@extends('pengguna.partials.pengguna')

@section('title', 'Dashboard')

@section('content')

{{-- localization --}}
@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp


@php
    $sessionData = collect(session('data_tukar_sampah', []))
        ->keyBy('trash_id')
        ->toArray();
@endphp

    <!-- Link ke file CSS khusus Tukar Sampah -->
    <link rel="stylesheet" href="{{ asset('assets/css/tukarsampah.css') }}">

    <main class="app-main container mt-4">
    <!--begin::App Content Header-->
        <!-- Jika stepper pakai float, tambahkan clearfix -->
        <div class="clearfix"></div>
        <!-- Progress step -->
            <div class="d-flex justify-content-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-success text-white px-3 py-1" style="border: 1px solid #005A32;">1</div>
                    <div class="border-top flex-grow-1"></div>
                    <div class="rounded-circle bg-light px-3 py-1 border" style="border: 1px solid #005A32;">2</div>
                </div>
            </div>
        <h2 class="text-hijau-kecil mb-4" style="padding-left: 8px;">{{__('trash_exchange.labels.select_trash')}}</h2>
        {{-- error message --}}
        @if ($errors->any())
            <div class="alert alert-danger mx-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengguna.tukar-sampah.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <h4 class="text-hijau-kecil-kecil mb-3" style="padding-left: 20px;"><u>{{__('trash_exchange.headers.organic')}}</u></h4>
                @foreach ($sampahOrganik as $item)
                    <div class="col-md-4 mb-3" style="padding-left: 20px;">
                        <div class="card text-center border custom-green-border">
                            <div class="card-body">
                                <!-- Gambar sampah -->
                                <img src="{{ asset('assets/img/' . $item->photos) }}" alt="{{ $item->name }}" class="img-fluid mb-2" style="height: 150px; object-fit: contain;">

                                <!-- Nama dan harga -->
                                <h5>{{ $item->name }}</h5>
                                <p>Rp. {{ number_format($item->price_per_kg, 2, ',', '.') }}/kg</p>

                                <!-- Quantity -->
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-outline-green btn-lg px-3" onclick="updateQuantity({{ $item->trash_id }}, -1)">-</button>

                                    <div class="input-wrapper mx-3">
                                        <input type="text"
                                            name="trash[{{ $item->trash_id }}][quantity]"
                                            id="qty-{{ $item->trash_id }}"
                                            value="{{ $sessionData[$item->trash_id]['quantity'] ?? 0 }}"
                                            class="form-control text-center input-compact custom-input-green"
                                            readonly>
                                        <span class="unit-label">kg</span>
                                    </div>

                                    {{-- <button type="button" class="btn btn-outline-green btn-lg px-3" onclick="updateQuantity({{ $item->trash_id }}, 1)">+</button> --}}
                                    <button type="button" class="btn btn-outline-green btn-lg px-3 plus-button" onclick="updateQuantity({{ $item->trash_id }}, 1)">+</button>

                                </div>

                                <input type="hidden" name="trash[{{ $item->trash_id }}][trash_id]" value="{{ $item->trash_id }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <h4 class="text-hijau-kecil-kecil mb-3" style="padding-left: 20px;"><u>{{__('trash_exchange.headers.inorganic')}}</u></h4>
                @foreach ($sampahAnorganik as $item)
                    <div class="col-md-4 mb-3" style="padding-left: 20px;">
                        <div class="card text-center border custom-green-border">
                            <div class="card-body">
                                <!-- Gambar sampah -->
                                {{-- <img src="{{ asset('assets/img/' . $item->photos) }}" alt="{{ $item->name }}" class="img-fluid mb-2" style="height: 150px; object-fit: contain;"> --}}
                                <img src="{{ asset('assets/img/' . ($item->photos === '-' ? 'lainnya.jpg' : $item->photos)) }}"
                                alt="{{ $item->name }}"
                                class="img-fluid mb-2"
                                style="height: 150px; object-fit: contain;">


                                <!-- Nama dan harga -->
                                <h5>{{ $item->name }}</h5>
                                <p>Rp. {{ number_format($item->price_per_kg, 2, ',', '.') }}/kg</p>

                                <!-- Quantity -->
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-outline-green btn-lg px-3" onclick="updateQuantity({{ $item->trash_id }}, -1)">-</button>

                                    {{-- <div>
                                        <input type="number" name="trash[{{ $item->trash_id }}][quantity]" id="qty-{{ $item->trash_id }}" value="0" min="0" max="{{ $item->max_weight }}"  class="form-control mx-3 text-center input-centered custom-input-green" readonly>
                                    </div> --}}
                                    <div class="input-wrapper mx-3">
                                        <input type="text"
                                            name="trash[{{ $item->trash_id }}][quantity]"
                                            id="qty-{{ $item->trash_id }}"
                                            value="{{ $sessionData[$item->trash_id]['quantity'] ?? 0 }}"
                                            class="form-control text-center input-compact custom-input-green"
                                            readonly>
                                        <span class="unit-label">kg</span>
                                    </div>

                                    {{-- <button type="button" class="btn btn-outline-green btn-lg px-3" onclick="updateQuantity({{ $item->trash_id }}, 1)">+</button> --}}
                                    <button type="button" class="btn btn-outline-green btn-lg px-3 plus-button" onclick="updateQuantity({{ $item->trash_id }}, 1)">+</button>
                                </div>

                                <input type="hidden" name="trash[{{ $item->trash_id }}][trash_id]" value="{{ $item->trash_id }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-end mt-3 mb-3">
                <button type="submit" class="btn btn-success" style="width: 150px;">{{__('trash_exchange.labels.next_button')}}</button>
            </div>
        </form>

        {{-- Modal popup untuk alamat belum lengkap --}}
        @if(session('incomplete_address'))
        <script>
            window.onload = function () {
                var myModal = new bootstrap.Modal(document.getElementById('alamatModal'));
                myModal.show();
            };
        </script>

        <!-- Modal untuk alamat belum lengkap -->
        <div class="modal fade" id="alamatModal" tabindex="-1" aria-labelledby="alamatModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
              <div class="modal-header">
                <h5 class="modal-title" id="alamatModalLabel">{{__('trash_exchange.address_modal.title')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
              </div>
              <div class="modal-body">
                {{__('trash_exchange.address_modal.message')}}
              </div>
              <div class="modal-footer justify-content-center">
                <a href="{{ route('pengguna.profile.edit') }}" class="btn btn-success">{{__('trash_exchange.address_modal.button')}}</a>
              </div>
            </div>
          </div>
        </div>
        @endif
    </main>

    <script>
        function updateQuantity(id, change) {
            const qtyInput = document.getElementById('qty-' + id);
            const plusButton = qtyInput.parentElement.querySelector('button[onclick*="+1"]');

            let qty = parseInt(qtyInput.value) + change;

            // Batas bawah nol
            qty = Math.max(0, qty);

            // Batas atas 10
            if (qty > 10) {
                qty = 10;
            }

            qtyInput.value = qty;

            // Tambah class warning jika 10kg
            if (qty === 10) {
                qtyInput.classList.add('input-limit-reached');
                plusButton.classList.add('btn-limit-reached');
            } else {
                qtyInput.classList.remove('input-limit-reached');
                plusButton.classList.remove('btn-limit-reached');
            }
        }

    </script>

@endsection
