<nav class="navbar navbar-expand-lg sticky-top" style="background-color: #F7FCF5">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- Left Side: Avatar + Name -->
        <div class="d-flex align-items-center">
            <a href="{{ route('driver.profile') }}"><img src={{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('assets/img/default-profile.webp') }} class="rounded-circle me-2"
                    alt="Avatar" width="50" height="50" style="object-fit: cover;" /></a>
            <a class="navbar-brand fw-bold mb-0" href="{{ route('driver.profile') }}">{{ Auth::user()->name }}</a>
        </div>

        <!-- Right Side: Hamburger Menu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>

    <!-- Collapsible Content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item mx-4">
                <a class="nav-link active fw-bold" aria-current="page"
                    href="{{ route('driver.dashboard') }}">Beranda</a>
            </li>
            <li class="nav-item mx-4">
                <a class="nav-link" href="#">Pesan</a>
            </li>
            <li class="nav-item mx-4">
                <a class="nav-link" href="{{ route('driver.histori.index') }}">Histori</a>
            </li>
            <li class="nav-item mx-4">
                <a class="nav-link" style="color: red" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>