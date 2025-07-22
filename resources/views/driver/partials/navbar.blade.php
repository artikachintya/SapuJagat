@php
    $currLang = session()->get('lang', 'id');
    app()->setLocale($currLang);
@endphp

<nav class="navbar navbar-expand-lg sticky-top shadow-sm" style="background-color: #F7FCF5;">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- Kiri: Avatar dan Nama -->
        <div class="d-flex align-items-center">
            <a href="{{ route('driver.profile') }}">
                <img src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('assets/img/default-profile.webp') }}"
                     class="rounded-circle me-2" alt="Avatar" width="50" height="50" style="object-fit: cover;" />
            </a>
            <a class="navbar-brand fw-bold mb-0" href="{{ route('driver.profile') }}">{{ Auth::user()->name }}</a>
        </div>

        <!-- Kanan: Toggle + Dropdown Bahasa -->
        <div class="d-flex align-items-center">

            <!-- Dropdown Bahasa -->
            <div class="dropdown me-3">
                <a href="#" class="nav-link dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset(app()->getLocale() === 'en' ? 'assets/img/uk.png' : 'assets/img/indonesia.png') }}"
                         class="rounded-circle shadow border" alt="Language Flag" width="32" height="32">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <form action="/lang" method="POST">
                            @csrf
                            <button type="submit" name="lang" value="en" class="dropdown-item d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/img/uk.png') }}" width="20" height="20"> English
                            </button>
                        </form>
                    </li>
                    <li>
                        <form action="/lang" method="POST">
                            @csrf
                            <button type="submit" name="lang" value="id" class="dropdown-item d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/img/indonesia.png') }}" width="20" height="20"> Indonesia
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </div>

    <!-- Collapsible Content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-3 mb-2 mb-lg-0 flex-column">
            <li class="nav-item my-2">
                <a class="nav-link {{ request()->routeIs('driver.dashboard') ? 'active fw-bold' : '' }}"
                   href="{{ route('driver.dashboard') }}">{{ __('navbar.common.dashboard') }}</a>
            </li>

            <li class="nav-item my-2">
                <a class="nav-link {{ request()->routeIs('driver.chat.list') ? 'active fw-bold' : '' }}"
                   href="{{ route('driver.chat.list') }}">{{ __('navbar.driver.messages') }}</a>
            </li>

            <li class="nav-item my-2">
                <a class="nav-link {{ request()->routeIs('driver.histori.index') ? 'active fw-bold' : '' }}"
                   href="{{ route('driver.histori.index') }}">{{ __('navbar.common.history') }}</a>
            </li>

            <li class="nav-item my-2">
                <a class="nav-link text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   {{ __('navbar.common.sign_out') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
