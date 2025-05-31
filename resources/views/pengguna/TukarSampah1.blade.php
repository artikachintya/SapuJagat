@extends('pengguna.partials.pengguna')

@section('title', 'Dashboard')

@section('content')
    <!-- Link ke file CSS khusus Tukar Sampah -->
    <link rel="stylesheet" href="{{ asset('tukarsampah.css') }}">

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
                    {{-- <div class="border-top flex-grow-1"></div>
                    <div class="rounded-circle bg-light px-3 py-1 border">3</div> --}}
                </div>
            </div>
        <h2 class="text-hijau-kecil mb-4" style="padding-left: 8px;">Pilih Sampah yang Ingin Ditukar</h2>

        @if ($errors->any())
            <div class="alert alert-danger mx-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

                                    {{-- <div>
                                        <input type="number" name="trash[{{ $item->trash_id }}][quantity]" id="qty-{{ $item->trash_id }}" value="0" min="0" max="{{ $item->max_weight }}"  class="form-control mx-3 text-center input-centered custom-input-green" readonly>
                                    </div> --}}

                                    <div class="input-wrapper mx-3">
                                        <input type="text"
                                            name="trash[{{ $item->trash_id }}][quantity]"
                                            id="qty-{{ $item->trash_id }}"
                                            value="0"
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

                                    {{-- <div>
                                        <input type="number" name="trash[{{ $item->trash_id }}][quantity]" id="qty-{{ $item->trash_id }}" value="0" min="0" max="{{ $item->max_weight }}"  class="form-control mx-3 text-center input-centered custom-input-green" readonly>
                                    </div> --}}
                                    <div class="input-wrapper mx-3">
                                        <input type="text"
                                            name="trash[{{ $item->trash_id }}][quantity]"
                                            id="qty-{{ $item->trash_id }}"
                                            value="0"
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
                <button type="submit" class="btn btn-success" style="width: 150px;">Lanjut</button>
            </div>
        </form>
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

 {{-- <script>
        function updateQuantity(id, change) {
            const qtyInput = document.getElementById('qty-' + id);
            let qty = parseInt(qtyInput.value) + change;
            qty = qty < 0 ? 0 : qty;
            qtyInput.value = qty;
        }

        document.querySelector('form').addEventListener('submit', function (e) {
            let totalQty = 0;
            const maxQty = 10;
            let hasExceeded = false;

            document.querySelectorAll('input[type="number"]').forEach(input => {
                const qty = parseInt(input.value);
                if (qty > maxQty) {
                    hasExceeded = true;
                }
                totalQty += qty;
            });

            if (totalQty === 0) {
                e.preventDefault();
                alert("Maaf sayang, kamu belum memilih jenis sampah dan berat apapun:(");
            } else if (hasExceeded) {
                e.preventDefault();
                alert("Maaf sayang, setiap jenis sampah maksimal 10kg yaa, jangan lebih huhu:( ");
            }
        });
    </script> --}}
 {{-- ini pop up <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            let totalQty = 0;

            // Loop semua input quantity
            document.querySelectorAll('input[name^="trash"][name$="[quantity]"]').forEach(input => {
                const qty = parseInt(input.value) || 0;
                totalQty += qty;
            });

            if (totalQty < 3) {
                e.preventDefault();
                alert("Minimal total sampah yang bisa ditukar adalah 3 kg yaa :)");
            }
        });
    </script> --}}
