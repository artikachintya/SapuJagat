<html lang="en">

<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
        integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield('title', 'Driver Dashboard')</title>
    <style>
        .card-report {
            /* background-image: url("../assets/img/Card-Background.jpg"); */
            /* background-image: asset("/assets/img/Card-Background.jpg"); */
            background-image: url('{{ asset('assets/img/Card-Background.jpg') }}');
            background-size: cover;
            /* Make image cover entire area */
            background-repeat: no-repeat;
            /* Prevent repeating */
            background-position: center;
            /* Center the image */
        }
    </style>
</head>


<body>
    @include('driver.partials.navbar') <!-- Navbar -->
    @yield('content') <!-- Main content -->
    @stack('styles')

</body>
@stack('scripts')

</html>
