@extends('pengguna.partials.pengguna')

@section('title', 'Pelacakan')

@section('content')
    <main class="app-main container mt-4">
        <div class="card p-4 shadow-sm" style="background-color:#f5fcf7;">
            <!-- Tracking Timeline Section -->
            <div class="tracking-container">
                <div class="driver-info">
                    <img src="{{ asset('LacakDriver/assets/Driver-Face.jpeg') }}" alt="Driver" class="driver-photo" />
                    <div class="driver-details">
                        <h2>Nama Driver</h2>
                        <p>B 1234 GCR</p>
                        <button class="contact-button">Hubungi Driver</button>
                    </div>
                </div>

                <div class="timeline-grid">
                    <!-- LEFT SIDE -->
                    <div class="timeline-side">
                        <!-- Item 1 -->
                        <div class="timeline-item completed">
                            <img  src="{{ asset('LacakDriver/assets/otwJemput.png') }}" alt="Dalam Penjemputan" class="timeline-icon" />
                            <div class="timeline-text">
                                <strong>Dalam Penjemputan</strong>
                                <p>09 May 2025 - 10.05 WIB</p>
                            </div>
                        </div>
                        <!-- Line -->
                        <div class="timeline-line"></div>
                        <!-- Item 2 -->
                        <div class="timeline-item completed">
                            <img src="{{ asset('LacakDriver/assets/pickUp.png') }}" alt="Pengambilan Sampah" class="timeline-icon" />
                            <div class="timeline-text">
                                <strong>Pengambilan Sampah</strong>
                                <p>09 May 2025 - 10.40 WIB</p>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="timeline-side">
                        <!-- Item 3 -->
                        <div class="timeline-item">
                            <img src="{{ asset('LacakDriver/assets/checkingProcess.png') }}" alt="Pengecekan Sampah" class="timeline-icon" />
                            <div class="timeline-text">
                                <strong>Pengecekan Sampah</strong>
                                <p>09 May 2025 - 11.30 WIB</p>
                            </div>
                        </div>
                        <!-- Line -->
                        <div class="timeline-line"></div>
                        <!-- Item 4 -->
                        <div class="timeline-item">
                            <img src="{{ asset('LacakDriver/assets/successCheck.png') }}" alt="Penukaran Berhasil" class="timeline-icon" />
                            <div class="timeline-text">
                                <strong>Penukaran Berhasil</strong>
                                <p>09 May 2025 - 13.00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </main>
@endsection