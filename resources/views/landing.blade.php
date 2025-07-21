<html lang="en">

@php
    $currLang = session()->get('lang', 'id'); //ini yang en itu klo ga ada parameter lang, diganti default en
    app()->setLocale($currLang);
@endphp


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
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand mx-3" href="/">
                <img class="logo" src="/landingpage/images/logo.png" alt="SapuJagat Logo" height="50">
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navitems">
                <span class="navbar-toggler-icon"></span>
            </button>

            <form action="/lang" method="POST">
                @csrf
                <select name="lang" id="lang" onchange="this.form.submit()">
                    <option value="en" {{-- jika app punya local english maka akan di selected, app akan secara default mengarah ke option english --}} @if (app()->getLocale() === 'en') selected @endif>
                        English</option>
                    <option value="id" @if (app()->getLocale() === 'id') selected @endif>Indonesia</option>
                </select>
            </form>

            <div class="collapse navbar-collapse" id="navitems">
                <!-- LEFT SIDE -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="#feature-section">{{ __('landing.fitur') }}</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="#testimoni-section">{{ __('landing.testimoni') }}</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="#faq-section">{{ __('landing.faq') }}</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="#footer-section">{{ __('landing.kontak') }}</a>
                    </li>
                </ul>

                <!-- RIGHT SIDE -->
                <div class="d-flex gap-2">
                    <button class="btn mx-2 w-100 px-4" type="button" id="login-btn"
                        onclick="window.location='{{ route('login') }}'">{{ __('landing.masuk') }}</button>
                    <button class="btn mx-2 w-100 px-4" type="button" id="register-btn"
                        onclick="window.location='{{ route('register') }}'">{{ __('landing.daftar') }}</button>
                </div>
            </div>
        </div>
    </nav>

    {{-- first section --}}
    <header id="header-landing-page">
        <div class="container-fluid px-0 mx-0">
            <div class ="row gx-0 align-items-center py-5">

                {{-- Text content --}}
                <div class="col-xxl-6 d-flex flex-column justify-content-center px-5">
                    <!-- Mobile version -->
                    <h4 class="fw-bolder mb-3 tagline d-block d-lg-none fs-2 text-center">
                        {{ __('landing.judul') }}
                    </h4>

                    <!-- Desktop version -->
                    <h1 class="fw-bold mb-3 tagline d-none d-lg-block display-4">
                        {{ __('landing.judul') }}
                    </h1>
                    <!-- Mobile version: small, normal weight -->
                    <p class="desc-landing-page fw-normal d-block d-lg-none fs-6 text-center">
                        {{ __('landing.subjudul') }}
                         <br>
                        {{ __('landing.subjudul2') }}
                    </p>

                    <!-- Desktop version: larger, normal weight -->
                    <p class="desc-landing-page fw-normal d-none d-lg-block fs-4">
                        {{ __('landing.subjudul') }}
                        <br>
                        {{ __('landing.subjudul2') }}
                    </p>

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
            {{ __('landing.fiturkami') }}
        </h4>

        <!-- Desktop version -->
        <h1 class="fw-bold my-5 d-none d-lg-block display-4 text-center">
            {{ __('landing.fiturkami') }}
        </h1>

        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 g-4 justify-content-center">
                @include('feature-card', [
                    'icon' => 'fa-solid fa-trash-can fa-7x',
                    'title' => __('landing.fitur_tukar_sampah_judul'),
                    'description' => __('landing.fitur_tukar_sampah_desc') ,
                ])
                @include('feature-card', [
                    'icon' => 'fa-solid fa-clock-rotate-left fa-7x',
                    'title' => __('landing.fitur_histori_judul'),
                    'description' => __('landing.fitur_histori_desc') ,
                ])

                @include('feature-card', [
                    'icon' => 'fa-solid fa-circle-check fa-7x',
                    'title' => __('landing.fitur_pelacakan_judul'),
                    'description' => __('landing.fitur_pelacakan_desc') ,
                ])

                @include('feature-card', [
                    'icon' => 'fa-solid fa-circle-exclamation fa-7x',
                    'title' => __('landing.fitur_laporan_judul'),
                    'description' => __('landing.fitur_laporan_desc') ,
                ])
            </div>
        </div>

    </section>

    {{-- testimoni section --}}
    <section id="testimoni-section" class="min-vh-100">
        <!-- Mobile version -->
        <h4 class="fw-bolder mt-3 mb-5 d-block d-lg-none fs-2 text-center">
            {{ __('landing.testimoni') }}
        </h4>

        <!-- Desktop version -->
        <h1 class="fw-bold my-5 d-none d-lg-block display-4 text-center">
            {{ __('landing.testimoni') }}
        </h1>

        <div class="container my-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-5">
                            <!-- Carousel wrapper -->
                            <div id="carouselDarkVariant" class="carousel slide carousel-dark" data-bs-ride="carousel">
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
                                    @include('testimonial-item', [
                                        'active' => 'active',
                                        'image_url' =>
                                            'https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(1).webp',
                                        'name' => 'Eine Rahmawati',
                                        'testimonial_text' =>
                                            __('landing.testi_1_teks'),
                                    ])

                                    @include('testimonial-item', [
                                        'active' => '',
                                        'image_url' =>
                                            'https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(9).webp',
                                        'name' => 'Budi Santoso',
                                        'testimonial_text' =>
                                            __('landing.testi_2_teks'),
                                    ])

                                    @include('testimonial-item', [
                                        'active' => '',
                                        'image_url' =>
                                            'https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(2).webp',
                                        'name' => 'Evelina Sari',
                                        'testimonial_text' =>
                                             __('landing.testi_3_teks'),
                                    ])
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
                        {{ __('landing.teks_FAQ') }}
                    </h4>

                    <!-- Desktop version -->
                    <h1 class="fw-bold tagline d-none d-lg-block display-4 mx-5">
                        {{ __('landing.teks_FAQ') }}
                    </h1>
                </div>

                <div class="col-lg-7 col-xxl-7 d-flex flex-column justify-content-center">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion" id="accordionExample">
                            @include('faq-section', [
                                'expanded' => true,
                                'target' => 'collapseOne',
                                'title' => __('landing.faq_1_q'),
                                'content' => __('landing.faq_1_a'),
                                'parent' => 'accordionExample',
                            ])

                            @include('faq-section', [
                                'expanded' => false,
                                'target' => 'collapseTwo',
                                'title' => __('landing.faq_2_q'),
                                'content' => __('landing.faq_2_a'),
                                'parent' => 'accordionExample',
                            ])

                            @include('faq-section', [
                                'expanded' => false,
                                'target' => 'collapseThree',
                                'title' => __('landing.faq_3_q'),
                                'content' => __('landing.faq_3_a'),
                                'parent' => 'accordionExample',
                            ])

                            @include('faq-section', [
                                'expanded' => false,
                                'target' => 'collapseFour',
                                'title' => __('landing.faq_4_q'),
                                'content' => __('landing.faq_4_a'),
                                'parent' => 'accordionExample',
                            ])

                            @include('faq-section', [
                                'expanded' => false,
                                'target' => 'collapseFive',
                                'title' => __('landing.faq_5_q'),
                                'content' => __('landing.faq_5_a'),
                                'parent' => 'accordionExample',
                            ])

                            @include('faq-section', [
                                'expanded' => false,
                                'target' => 'collapseSix',
                                'title' => __('landing.faq_6_q'),
                                'content' => __('landing.faq_6_a'),
                                'parent' => 'accordionExample',
                            ])
                        </div>
                    </div>
                </div>
            </div>
    </section>

    {{-- footer section --}}
    <footer class="text-center text-lg-start" style="background-color: #E5F5E0" id="footer-section">
        <!-- Grid container -->
        <div class="container">
            <!--Grid row-->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <img src="/landingpage/images/logo.png" height="50">
                    <p>
                        <i class="fa-solid fa-location-dot"></i>
                        Rumah Talenta BCA Jalan Pakuan no. 3, Sumur Batu, Babakan Madang, Sentul, Indonesia
                    </p>
                </div>

                <!-- Grid column -->
                <div class="col-md-4 col-lg-5 col-xl-5 mx-auto my-auto d-flex flex-column justify-content-center">
                    <div class="text-center">
                        ©
                        <p class="text-dark">{{__('landing.copyright')}}</p>
                    </div>
                </div>
                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto my-auto">
                    <h6 class="text-uppercase fw-bold">{{__('landing.follow_us')}}</h6>

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
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
