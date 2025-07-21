<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item marginzero">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block marginzero"><a href="#" class="nav-link">{{__('navbar.common.dashboard')}}</a></li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">

            <!--begin::Language Menu Dropdown-->
            <li class="nav-item dropdown user-menu marginzero">
                <a href="#" class="nav-link">
                    <img src="{{ asset('dashboard-assets/assets/img/indonesia.png') }}"
                        class="user-image rounded-circle shadow" alt="User Image" />
                </a>
            </li>

             <form action="/lang" method="POST">
                @csrf
                <select name="lang" id="lang" onchange="this.form.submit()">
                    <option value="en" {{-- jika app punya local english maka akan di selected, app akan secara default mengarah ke option english --}} @if (app()->getLocale() === 'en') selected @endif>
                        English</option>
                    <option value="id" @if (app()->getLocale() === 'id') selected @endif>Indonesia</option>
                </select>
            </form>
            <!--end::User Menu Dropdown-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu marginzero">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src={{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('assets/img/default-profile.webp') }} class="user-image rounded-circle shadow"
                        alt="User Image" style="object-fit: cover;" />
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">{{__('navbar.common.profile')}}</a>
                        <a href="{{ route('logout') }}" class="btn btn-danger btn-flat float-end"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{__('navbar.common.sign_out')}}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--end::Header-->

<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('landingpage/images/logo.png') }}" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            {{-- <span class="brand-text fw-light">Sapu Jagat</span> --}}
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-header" style="padding:0;">
                    <a href="{{ route('admin.profile') }}" class="nav-link">
                        <img src={{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('assets/img/default-profile.webp') }} class="user-image rounded-circle shadow"
                            alt="User Image" style="width: 30px; height: 30px;" />
                        <span class="ps-3 d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                </li>
                <hr />
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Route::is('admin.dashboard') ? 'navigationbuttonactive' : 'navigationbutton' }}">
                        <i class="nav-icon bi bi-house"></i>
                        <p>{{__('navbar.common.dashboard')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.jenis-sampah.index') }}"
                        class="nav-link {{ Route::is('admin.jenis-sampah.*') ? 'navigationbuttonactive' : 'navigationbutton' }}">
                        <i class="nav-icon bi bi-trash"></i>
                        <p>{{__('navbar.admin.waste_types')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.histori.index') }}"
                        class="nav-link {{ Route::is('admin.histori.*') ? 'navigationbuttonactive' : 'navigationbutton' }}">
                        <i class="nav-icon bi bi-clock-history"></i>
                        <p>{{__('navbar.common.history')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.persetujuan.index') }}"
                        class="nav-link {{ Route::is('admin.persetujuan.*') ? 'navigationbuttonactive' : 'navigationbutton' }}">
                        <i class="nav-icon bi bi-check2-circle"></i>
                        <p>{{__('navbar.admin.approval')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.penugasan.index') }}"
                        class="nav-link {{ Route::is('admin.penugasan.*') ? 'navigationbuttonactive' : 'navigationbutton' }}">
                        <i class="nav-icon bi bi-check2-circle"></i>
                        <p>{{__('navbar.admin.assignment')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.laporan.index') }}"
                        class="nav-link {{ Route::is('admin.laporan.*') ? 'navigationbuttonactive' : 'navigationbutton' }}">
                        <i class="nav-icon bi bi-exclamation-diamond"></i>
                        <p>{{__('navbar.common.reports')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.print-data.index') }}"
                        class="nav-link {{ Route::is('admin.print-data.*') ? 'navigationbuttonactive' : 'navigationbutton' }}">
                        <i class="nav-icon bi bi-printer"></i>
                        <p>{{__('navbar.admin.print_data')}}</p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
