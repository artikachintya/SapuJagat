@extends('pengguna.partials.pengguna')

@section('title', 'Dashboard')

@section('content')
    <!-- Link ke file CSS khusus Tukar Sampah -->
    <link rel="stylesheet" href="{{ asset('tukarsampah.css') }}">

    <main class="app-main container mt-4">
    <!--begin::App Content Header-->
        <!-- Jika stepper pakai float, tambahkan clearfix -->
        <div class="clearfix"></div>

        <h2 class="text-hijau-kecil mb-4" style="padding-left: 8px;">
            Pilih Sampah yang Ingin Ditukar
        </h2>

        <form action="{{ route('tukar-sampah.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <h4 class="text-hijau-kecil-kecil mb-3" style="padding-left: 20px;"><u>Organik</u></h4>
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

                                    <div>
                                        <input type="number" name="trash[{{ $item->trash_id }}][quantity]" id="qty-{{ $item->trash_id }}" value="0" min="0" max="{{ $item->max_weight }}"  class="form-control mx-3 text-center input-centered custom-input-green" readonly>
                                    </div>

                                    <button type="button" class="btn btn-outline-green btn-lg px-3" onclick="updateQuantity({{ $item->trash_id }}, 1)">+</button>
                                </div>

                                <input type="hidden" name="trash[{{ $item->trash_id }}][trash_id]" value="{{ $item->trash_id }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <h4 class="text-hijau-kecil-kecil mb-3" style="padding-left: 20px;"><u>Anorganik</u></h4>
                @foreach ($sampahAnorganik as $item)
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

                                    <div>
                                        <input type="number" name="trash[{{ $item->trash_id }}][quantity]" id="qty-{{ $item->trash_id }}" value="0" min="0" max="{{ $item->max_weight }}"  class="form-control mx-3 text-center input-centered custom-input-green" readonly>
                                    </div>

                                    <button type="button" class="btn btn-outline-green btn-lg px-3" onclick="updateQuantity({{ $item->trash_id }}, 1)">+</button>
                                </div>

                                <input type="hidden" name="trash[{{ $item->trash_id }}][trash_id]" value="{{ $item->trash_id }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-end mt-3 mb-3">
                <button type="submit" class="btn btn-success" style="width: 150px;">Lanjut</button>
            </div>
        </form>
    </main>
@endsection

{{-- function updateQuantity(id, change) {
    const hiddenInput = document.getElementById('qty-hidden-' + id);
    const displayBox = document.getElementById('qty-' + id);

    let current = parseInt(hiddenInput.value);
    current = isNaN(current) ? 0 : current;
    let updated = Math.max(current + change, 0); // jangan negatif

    hiddenInput.value = updated;
    displayBox.textContent = updated;
} --}}
