@extends('pengguna.partials.pengguna')

@section('title', 'Ringkasan Pesanan')

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp

@section('content')
<main class="app-main container mt-4">
    <div class="mx-3" style="max-width: 1200px;">

        <!-- Judul dan step progress -->
        <div class="mb-4">
            <div class="d-flex justify-content-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-light px-3 py-1 border" style="border: 1px solid #005A32;">1</div>
                    <div class="border-top flex-grow-1" ></div>
                    <div class="rounded-circle bg-success text-white px-3 py-1" style="border: 1px solid #005A32;">2</div>
                </div>
            </div>
            <h2 class="mb-2">{{__('order_summary.title')}}</h2>
        </div>

        <!-- TABEL PESANAN -->

        <div class="table-responsive">
            <table class="table table-bordered table-sm text-white" style="background-color: #005A32; height:50px;">
                <thead>
                    <tr>
                        <th class="py-3 px-1 fs-6 text-center">No</th>
                        <th class="py-3 px-1 fs-6 text-center">{{__('order_summary.table.headers.trash_name')}}</th>
                        <th class="py-3 px-1 fs-6 text-center">{{__('order_summary.table.headers.quantity')}}</th>
                        <th class="py-3 px-1 fs-6 text-center">{{__('order_summary.table.headers.price')}}</th>
                        <th class="py-3 px-1 fs-6 text-center">{{__('order_summary.table.headers.total')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach ($data as $index => $item)
                        <tr>
                            <td class="py-3 px-1 fs-6 text-center">{{ $index + 1 }}</td>
                            <td class="py-3 px-1 fs-6 text-center">{{ $item['name'] }}</td>
                            <td class="py-3 px-1 fs-6 text-center">{{ $item['quantity'] }} kg</td>
                            <td class="py-3 fs-6 text-center">Rp {{ number_format($item['price'], 2, ',', '.') }}</td>
                            <td class="py-3 fs-6 text-center">Rp {{ number_format($item['total'], 2, ',', '.') }}</td>
                        </tr>
                        @php $grandTotal += $item['total']; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Estimasi total -->
        <div class="mt-1 py-2 px-3 text-white w-100 w-md-50" style="background-color: #005A32;">
            <h5 class="mb-0 px-4 text-center fs-5">{{__('order_summary.total')}}Rp {{ number_format($grandTotal, 2, ',', '.') }}</h5>
        </div>

        <!-- Form Upload & Waktu Penjemputan -->
        <form id="formJemput" action="{{ route('pengguna.ringkasan.jemput') }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf

            <!-- Waktu Penjemputan -->
            <div class="mb-3 w-50">
                <label for="pickup_time" class="form-label fw-bold">{{__('order_summary.form.pickup_time.label')}}</label>
               <select name="pickup_time" id="pickup_time" class="form-select" required style="border: 1px solid #005A32; border-radius: 0;">
                    <option value="">{{__('order_summary.form.pickup_time.placeholder')}}</option>
                    <option value="07:00 - 09.00 WIB">07.00 - 09.00 WIB</option>
                    <option value="12:00 - 14.00 WIB">12.00 - 14.00 WIB</option>
                    <option value="18:00 - 20.00 WIB">18.00 - 20.00 WIB</option>
                </select>
            </div>

            <!-- Upload Foto -->
            {{-- <div class="mb-4 w-50">
                <label for="photo" class="form-label fw-bold">Unggah Bukti Pesanan</label>

                <div class="input-group">
                    <input type="file" name="photo" id="photo" class="form-control" style="display: none;" required>

                    <label for="photo"
                        class="form-control d-flex align-items-center"
                        id="photo-label"
                        style="cursor: pointer; border: 1px solid #005A32; padding-left: 12px; padding-right: 1px; border-radius: 0; padding-bottom: 1px; padding-top: 1px;">

                        <span id="photo-text" class="flex-grow-1 mb-0">Pilih File</span>
                        <img src="{{ asset('assets/img/upload1.png') }}"
                            alt="Upload Icon"
                            style="height: 40px; width: 40px;" class="ms-auto">
                    </label>

                </div>
            </div> --}}
            <!-- Upload Foto -->
            <div class="mb-4 w-50">
                <label for="photo" class="form-label fw-bold">{{__('order_summary.form.photo.label')}}</label>

                <div class="input-group">
                    <input type="file" name="photo" id="photo" class="form-control" style="display: none;" required accept="image/*">

                    <label for="photo"
                        class="form-control d-flex align-items-center"
                        id="photo-label"
                        style="cursor: pointer; border: 1px solid #005A32; padding-left: 12px; padding-right: 1px; border-radius: 0; padding-bottom: 1px; padding-top: 1px;">
                        <span id="photo-text" class="flex-grow-1 mb-0">{{__('order_summary.form.photo.placeholder')}}</span>
                        <img src="{{ asset('assets/img/upload1.png') }}" alt="Upload Icon" style="height: 40px; width: 40px;" class="ms-auto">
                    </label>
                </div>

                <!-- Tampilkan pesan error validasi -->
                @error('photo')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
                
                <!-- Preview Gambar -->
                <div class="mt-2">
                    <img id="photo-preview" src="#" alt="Preview Gambar" style="display: none; max-height: 200px; border: 1px solid #ccc; padding: 4px;">
                </div>
            </div>


            <!-- Tombol Back dan Jemput -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('pengguna.tukar-sampah.index') }}" class="btn btn-secondary px-5" style="background-color: #de2742; border: 1px solid #de2742;">{{__('order_summary.form.buttons.back')}}</a>

                <!-- Tombol untuk memunculkan modal -->
                <button type="button" class="btn btn-success px-5" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">{{__('order_summary.form.buttons.confirm')}}</button>
            </div>

            <!-- Modal Konfirmasi -->
            <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="konfirmasiModalLabel">{{__('order_summary.modal.title')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        {{__('order_summary.modal.body')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('order_summary.modal.buttons.cancel')}}</button>
                        <!-- Tombol Submit dalam Modal -->
                        <button type="submit" class="btn btn-success" form="formJemput">{{__('order_summary.modal.buttons.confirm')}}</button>
                    </div>
                    </div>
                </div>
            </div>

        </form>

    </div>
</main>

<script>
    document.getElementById('photo').addEventListener('change', function (e) {
        const fileName = e.target.files[0]?.name || 'Pilih File';
        document.getElementById('photo-text').textContent = fileName;
    });

    document.getElementById('konfirmasiJemputBtn').addEventListener('click', function () {
        document.querySelector('form').submit(); // Submit form utama
    });
</script>

<script>
    const inputPhoto = document.getElementById('photo');
    const previewImage = document.getElementById('photo-preview');
    const photoText = document.getElementById('photo-text');

    inputPhoto.addEventListener('change', function (e) {
        const file = e.target.files[0];
        photoText.textContent = file?.name || 'Pilih File';

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewImage.style.display = 'none';
            previewImage.src = '#';
        }
    });
</script>

@endsection
