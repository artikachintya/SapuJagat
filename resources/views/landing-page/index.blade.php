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

    <nav class="navbar navbar-expand-lg" style="background-color: #eaf9e5;">
        <div class="container-fluid">
            <a class="navbar-brand mx-3" href="/landing-page">
                <img class="logo" src="/landingpage/images/logo.png" alt="SapuJagat Logo" height="50">
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navitems">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse fs-6 fs-sm-6 fs-md-5 fs-lg-3" id="navitems">
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

    <header class="py-5">
        <div class="container px-5 pb-5">
            <div class="row gx-5 align-items-center">
                <div class="col-xxl-5">
                    <!-- Header text content-->
                    <div class="text-center">
                        <h4 class="display-3 fw-bold mb-5"><span class="text-gradient d-inline">Ubah Sampah Jadi Cuan dengan Cara yang Mudah</span></h4>
                        <p class="desc-landing-page">Kelola sampahmu langsung dari rumah, dapat poin, tukar hadiah, dan tarik saldo ke rekening. Semua dalam satu platform digital: Sapu Jagat!</p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xxl-start mb-3">
                            <a class="btn btn-primary btn-lg px-5 py-3 me-sm-3 fs-6 fw-bolder" href="landing-page.feature">Fitur Kami</a>
                            <a class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder" href="landing-page.testimoni">testimoni</a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7">
                    <!-- Header profile picture-->
                    <div class="d-flex justify-content-center mt-5 mt-xxl-0">
                        <div class="profile bg-gradient-primary-to-secondary">
                            <!-- TIP: For best results, use a photo with a transparent background like the demo example below-->
                            <!-- Watch a tutorial on how to do this on YouTube (link)-->
                            <img class="profile-img" src="public/landingpage/images/background_group_ver.png" alt="..." />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

</body>

</html>
