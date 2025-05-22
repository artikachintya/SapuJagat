<html lang="en">

<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('landingpage/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Sapu Jagat | Landing Page</title>
</head>
<script src="landingpage/js/script.js"></script>

<body>

    {{-- navbar section --}}
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand mx-3" href="/landing-page">
                <img class="logo" src="/landingpage/images/logo.png" alt="SapuJagat Logo" height="50">
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navitems">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navitems">
                <!-- LEFT SIDE -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="#feature-section">Fitur</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="#testimoni-section">Testimoni</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="#faq-section">FAQ</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="#footer-section">Kontak</a>
                    </li>
                </ul>

                <!-- RIGHT SIDE -->
                <div class="d-flex gap-2">
                    <button class="btn mx-2 w-100 px-4" type="button" id="login-btn">Masuk</button>
                    <button class="btn mx-2 w-100 px-4" type="button" id="register-btn">Daftar</button>
                </div>
            </div>
        </div>
    </nav>

    {{-- first section --}}
    <header id="header-landing-page">
        <div class="container-fluid px-0 mx-0">
            <div class ="row gx-0 align-items-center py-5">

                {{-- Text content --}}
                <div class="col-xxl-6 d-flex flex-column justify-content-center align-items-start px-5">
                    <!-- Mobile version -->
                    <h4 class="fw-bolder mb-3 tagline d-block d-lg-none fs-2 text-center">
                        Ubah Sampah Jadi Cuan dengan Cara yang Mudah!
                    </h4>

                    <!-- Desktop version -->
                    <h1 class="fw-bold mb-3 tagline d-none d-lg-block display-4">
                        Ubah Sampah Jadi Cuan dengan Cara yang Mudah!
                    </h1>
                    <!-- Mobile version: small, normal weight -->
                    <p class="desc-landing-page fw-normal d-block d-lg-none fs-6 text-center">
                        Kelola sampahmu langsung dari rumah, dapat poin, tukar hadiah, dan tarik saldo ke rekening.
                        Semua dalam satu platform digital: Sapu Jagat!
                    </p>

                    <!-- Desktop version: larger, normal weight -->
                    <p class="desc-landing-page fw-normal d-none d-lg-block fs-4">
                        Kelola sampahmu langsung dari rumah, dapat poin, tukar hadiah, dan tarik saldo ke rekening.
                        Semua dalam satu platform digital: Sapu Jagat!
                    </p>

                    <!-- Buttons -->
                    <div class="mt-3">
                        <a href="#feature-section" class="btn btn-outline-success me-3" id="feature-btn">Fitur Kami</a>
                        <a href="#testimoni-section" class="btn btn-outline-success" id="testimoni-btn">Testimoni</a>
                    </div>
                </div>
                {{-- image content --}}
                <div class="col-xxl-6 p-0 m-0 d-none d-lg-block">
                    <img src="landingpage/images/background_group_ver.png" alt="" class="img-fluid"
                        style="max-width: 100%; height: auto;">
                </div>
                <div class="col-xxl-6 p-0 m-0 d-block d-lg-none d-flex justify-content-center mt-2">
                    <img src="landingpage/images/background_mobile.png" alt="" class="img-fluid"
                        style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </header>

    {{-- feature section --}}
    <section id="feature-section" class="min-vh-100">
        <!-- Mobile version -->
        <h4 class="fw-bolder mt-3 mb-5 d-block d-lg-none fs-2 text-center">
            Fitur Kami
        </h4>

        <!-- Desktop version -->
        <h1 class="fw-bold my-5 d-none d-lg-block display-4 text-center">
            Fitur Kami
        </h1>

        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 g-4 justify-content-center">

                <div class="col">
                    <div class="feature-card text-center">
                        <img src="landingpage/images/trash-icon.png" class="icon-img mb-3" alt="Tukar Sampah Icon">
                        <button class="feature-button mb-3">Tukar Sampah</button>
                        <div class="chevron" onclick="toggleDesc(this)">⌄</div>
                        <div class="feature-desc collapse">
                            Pilih jenis sampahmu dan tukarkan dengan mudah. Satu langkah kecil untuk bumi, satu aksi
                            besar dari kamu!
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="feature-card text-center">
                        <img src="landingpage/images/history-icon.png" class="icon-img mb-3" alt="Tukar Sampah Icon">
                        <button class="feature-button mb-3">Histori</button>
                        <div class="chevron" onclick="toggleDesc(this)">⌄</div>
                        <div class="feature-desc collapse">
                            Lihat kembali semua aksi pedulimu. Riwayat penukaranmu tersimpan rapi,jadi kamu bisa pantau
                            progres hijau kamu!
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="feature-card text-center">
                        <img src="landingpage/images/tracking-icon.png" class="icon-img mb-3"
                            alt="Tukar Sampah Icon">
                        <button class="feature-button mb-3">Pelacakan</button>
                        <div class="chevron" onclick="toggleDesc(this)">⌄</div>
                        <div class="feature-desc collapse">
                            Driver on the way! Pantau perjalanan sampahmu dan pastikan semuanya aman sampai tujuan.
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="feature-card text-center">
                        <img src="landingpage/images/report-icon.png" class="icon-img mb-3" alt="Tukar Sampah Icon">
                        <button class="feature-button mb-3">Laporan</button>
                        <div class="chevron" onclick="toggleDesc(this)">⌄</div>
                        <div class="feature-desc collapse">
                            Driver telat? Fitur error? Sampaikan di sini — kami siap bantu atasi masalahmu dengan cepat
                            dan sigap!
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    {{-- testimoni section --}}
    <section id="testimoni-section" class="min-vh-100">
        <!-- Mobile version -->
        <h4 class="fw-bolder mt-3 mb-5 d-block d-lg-none fs-2 text-center">
            Testimoni
        </h4>

        <!-- Desktop version -->
        <h1 class="fw-bold my-5 d-none d-lg-block display-4 text-center">
            Testimoni
        </h1>

        <div class="container my-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-5">
                            <!-- Carousel wrapper -->
                            <div id="carouselDarkVariant" class="carousel slide carousel-dark"
                                data-bs-ride="carousel">
                                <!-- Indicators -->
                                <div class="carousel-indicators mb-0" style="bottom: -50px;">
                                    <button type="button" data-bs-target="#carouselDarkVariant" data-bs-slide-to="0"
                                        class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselDarkVariant" data-bs-slide-to="1"
                                        aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselDarkVariant" data-bs-slide-to="2"
                                        aria-label="Slide 3"></button>
                                </div>

                                <!-- Inner -->
                                <div class="carousel-inner py-2">
                                    <!-- Single item -->
                                    <div class="carousel-item active">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-lg-10 col-xl-8">
                                                <div class="row">
                                                    <div class="col-lg-4 d-flex justify-content-center">
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(1).webp"
                                                            class="rounded-circle shadow-1 mb-4 mb-lg-0"
                                                            alt="woman avatar" width="150" height="150" />
                                                    </div>
                                                    <div
                                                        class="col-9 col-md-9 col-lg-7 col-xl-8 text-center text-lg-start mx-auto mx-lg-0">
                                                        <h4 class="mb-4">Eine Rahmawati</h4>
                                                        <p class="mb-0 pb-3">
                                                            Baru tahu ternyata sampah bisa jadi duit! Pakai Sapu Jagat,
                                                            sampah di rumah dijemput langsung sama driver. Kita tinggal
                                                            pilah dan jadwalkan. Gak ribet dan bikin rumah makin bersih!
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Single item -->
                                    <div class="carousel-item">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-lg-10 col-xl-8">
                                                <div class="row">
                                                    <div class="col-lg-4 d-flex justify-content-center">
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(9).webp"
                                                            class="rounded-circle shadow-1 mb-4 mb-lg-0"
                                                            alt="woman avatar" width="150" height="150" />
                                                    </div>
                                                    <div
                                                        class="col-9 col-md-9 col-lg-7 col-xl-8 text-center text-lg-start mx-auto mx-lg-0">
                                                        <h4 class="mb-4">Budi Setiawan</h4>
                                                        <p class="mb-0 pb-3">
                                                            Layanan jemput sampahnya keren! Bikin kegiatan recycle jadi
                                                            gampang. Harga sampah transparan dan jelas. Semoga ke depan
                                                            cakupan area jemputnya makin luas.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Single item -->
                                    <div class="carousel-item">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-lg-10 col-xl-8">
                                                <div class="row">
                                                    <div class="col-lg-4 d-flex justify-content-center">
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(2).webp"
                                                            class="rounded-circle shadow-1 mb-4 mb-lg-0"
                                                            alt="woman avatar" width="150" height="150" />
                                                    </div>
                                                    <div
                                                        class="col-9 col-md-9 col-lg-7 col-xl-8 text-center text-lg-start mx-auto mx-lg-0">
                                                        <h4 class="mb-4">Tari</h4>
                                                        <p class="mb-0 pb-3">
                                                            Biasanya sampah kardus dan botol numpuk gak kepakai.
                                                            Sekarang tinggal order via Sapujagat, dijemput langsung.
                                                            Dapat uang juga. Anak-anak jadi ikut belajar pilah sampah.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Inner -->

                                <!-- Controls -->
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselDarkVariant" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselDarkVariant" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <!-- Carousel wrapper -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ section --}}
    <section id="faq-section" class="min-vh-100 d-flex flex-column justify-content-center">
        <div class="container">
            <div class="row gx-0 align-items-center py-5">
                {{-- Text content --}}
                <div class="col-lg-5 col-xxl-5 d-flex flex-column justify-content-center align-items-start">
                    <!-- Mobile version -->
                    <h4 class="fw-bolder tagline d-block d-lg-none fs-2 text-center mx-3 mb-3">
                        Ada pertanyaan? Tenang, kami siap membantu!
                    </h4>

                    <!-- Desktop version -->
                    <h1 class="fw-bold tagline d-none d-lg-block display-4 mx-5">
                        Ada pertanyaan? Tenang, kami siap membantu!
                    </h1>
                </div>

                <div class="col-lg-7 col-xxl-7 d-flex flex-column justify-content-center">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Apa itu Sapu Jagat?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Sapu Jagat adalah aplikasi penukaran sampah yang memungkinkan pengguna menukar
                                    sampah dengan imbalan tertentu. Sampah dijemput langsung oleh driver kami.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Bagaimana cara menggunakan Sapu Jagat?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Cukup daftar, input jenis dan berat sampah, lalu pilih jadwal penjemputan. Driver
                                    akan datang sesuai waktu yang dipilih.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    Apa saja jenis sampah yang bisa ditukar?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Kami menerima sampah organik dan anorganik seperti plastik, kertas, logam, daun,
                                    sisa makanan, dll.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    Bagaimana proses penukaran sampah dilakukan?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Setelah dijemput, sampah akan ditimbang dan diverifikasi di tempat penukaran sesuai
                                    data yang Anda input.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false"
                                    aria-controls="collapseFive">
                                    Apa keuntungan menukar sampah di Sapu Jagat?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Anda bisa mendapatkan imbalan berupa uang yang dapat ditarik ke rekening Anda, serta
                                    turut menjaga lingkungan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Di kota mana saja Sapu Jagat tersedia?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Saat ini kami beroperasi di beberapa kota besar. Cek aplikasi untuk info area
                                    layanan terbaru kami.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- footer section --}}
    <footer class="text-center text-lg-start" style="background-color: #E5F5E0" id="footer-section">
        <!-- Grid container -->
        <div class="container">
            <!-- Section: Links -->
            <section class="">
                <!--Grid row-->
                <div class="row">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">
                            Sapu Jagat
                        </h6>
                        <p>
                            Rumah Talenta BCA Jalan Pakuan no. 3, Sumur Batu, Babakan Madang, Sentul, Indonesia
                        </p>
                    </div>

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-5 col-xl-5 mx-auto mt-5 d-flex flex-column justify-content-center">
                        <div class="text-center">
                            ©
                            <a class="text-dark" href="https://mdbootstrap.com/">Sapu Jagat. Segala hak cipta
                                dilindungi | Web Programming</a>
                        </div>
                    </div>
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">Ikuti Kami</h6>

                        <!-- Facebook -->
                        <a class="btn btn-primary btn-floating m-1" style="background-color: #3b5998" href="#!"
                            role="button"><i class="fab fa-facebook-f"></i></a>

                        <!-- Twitter -->
                        <a class="btn btn-primary btn-floating m-1" style="background-color: #55acee" href="#!"
                            role="button"><i class="fab fa-twitter"></i></a>

                        <!-- Google -->
                        <a class="btn btn-primary btn-floating m-1" style="background-color: #dd4b39" href="#!"
                            role="button"><i class="fab fa-google"></i></a>

                        <!-- Instagram -->
                        <a class="btn btn-primary btn-floating m-1" style="background-color: #ac2bac" href="#!"
                            role="button"><i class="fab fa-instagram"></i></a>

                        <!-- Linkedin -->
                        <a class="btn btn-primary btn-floating m-1" style="background-color: #0082ca" href="#!"
                            role="button"><i class="fab fa-linkedin-in"></i></a>
                        <!-- Github -->
                        <a class="btn btn-primary btn-floating m-1" style="background-color: #333333" href="#!"
                            role="button"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <!--Grid row-->
            </section>
            <!-- Section: Links -->
        </div>
        <!-- Grid container -->
    </footer>
</body>

</html>
