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
    <title>Sapu Jagat | Landing Page</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand mx-3" href="/landing-page">
                <img class="logo" src="/landingpage/images/logo.png" alt="SapuJagat Logo" height="50">
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navitems">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse fs-6 fs-sm-6 fs-md-5 fs-lg-2" id="navitems">
                <!-- LEFT SIDE -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="/landing-page/fitur">Fitur</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="/landing-page/about">Testimoni</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="/landing-page/faq">FAQ</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="/landing-page/contact">Kontak</a>
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
                        <a href="#fitur" class="btn btn-outline-success me-3" id="feature-btn">Fitur Kami</a>
                        <a href="#testimoni" class="btn btn-outline-success" id="testimoni-btn">Testimoni</a>
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

    <section id="feature-section" class="min-vh-100 d-flex flex-column justify-content-center">
        <!-- Mobile version -->
        <h4 class="fw-bolder my-3 d-block d-lg-none fs-2 text-center">
            Fitur Kami
        </h4>

        <!-- Desktop version -->
        <h1 class="fw-bold my-5 d-none d-lg-block display-4 text-center">
            Fitur Kami
        </h1>

        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 g-4 justify-content-center">
                <div class="col">
                    <div class="card h-100">
                        <img src="landingpage/images/trash-icon.png" class="icon-img mx-auto d-block mt-4"
                            alt="Tukar Sampah Icon">
                        <div class="card-body text-center">
                            <h5 class="card-title">Tukar Sampah</h5>
                            <p class="card-text">Pilih jenis sampahmu dan tukarkan dengan mudah. Satu langkah kecil
                                untuk bumi, satu aksi besar dari kamu!</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="landingpage/images/history-icon.png" class="icon-img mx-auto d-block mt-4"
                            alt="Histori Icon">
                        <div class="card-body text-center">
                            <h5 class="card-title">Histori</h5>
                            <p class="card-text">Lihat kembali semua aksi pedulimu. Riwayat penukaranmu tersimpan rapi,
                                jadi kamu bisa pantau progres hijau kamu!</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="landingpage/images/tracking-icon.png" class="icon-img mx-auto d-block mt-4"
                            alt="Pelacakan Icon">
                        <div class="card-body text-center">
                            <h5 class="card-title">Pelacakan</h5>
                            <p class="card-text">Driver on the way! Pantau perjalanan sampahmu dan pastikan semuanya
                                aman sampai tujuan.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="landingpage/images/report-icon.png" class="icon-img mx-auto d-block mt-4"
                            alt="Laporan Icon">
                        <div class="card-body text-center">
                            <h5 class="card-title">Laporan</h5>
                            <p class="card-text">Driver telat? Fitur error? Sampaikan di sini — kami siap bantu atasi
                                masalahmu dengan cepat dan sigap!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
