<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
<!--begin::Container-->
<div class="container-fluid">
    <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
        <i class="bi bi-list"></i>
        </a>
    </li>
    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
    </ul>
    <!--end::Start Navbar Links-->
    <!--begin::End Navbar Links-->
    <ul class="navbar-nav ms-auto">
    
    <!--begin::Language Menu Dropdown-->
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link">
        <img
            src="{{ asset('dashboard-assets/assets/img/indonesia.png')}}"
            class="user-image rounded-circle shadow"
            alt="User Image"
        />
        </a>
    </li>
    <!--end::User Menu Dropdown-->
    <!--begin::Notifications Dropdown Menu-->
    <li class="nav-item dropdown">
        <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi bi-bell-fill"></i>
        <span class="navbar-badge badge text-bg-warning">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="bi bi-envelope me-2"></i> 4 new messages
            <span class="float-end text-secondary fs-7">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="bi bi-people-fill me-2"></i> 8 friend requests
            <span class="float-end text-secondary fs-7">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
            <span class="float-end text-secondary fs-7">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
        </div>
    </li>
    <!--end::Notifications Dropdown Menu-->
    <!--begin::User Menu Dropdown-->
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        <img
            src="{{ asset('dashboard-assets/assets/img/user2-160x160.jpg')}}"
            class="user-image rounded-circle shadow"
            alt="User Image"
        />
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <!--begin::Menu Footer-->
        <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
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
    <img
        src="{{ asset('dashboard-assets/assets/img/SJ_logo.png')}}"
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow"
    />
    <!--end::Brand Image-->
    <!--begin::Brand Text-->
    <span class="brand-text fw-light">Sapu Jagat</span>
    <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
</div>
<!--end::Sidebar Brand-->
<!--begin::Sidebar Wrapper-->
<div class="sidebar-wrapper">
    <nav class="mt-2">
    <!--begin::Sidebar Menu-->
    <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false"
    >
        <li class="nav-header">
        <a href="#" class="nav-link">
            <img
            src="{{ asset('dashboard-assets/assets/img/SJ_logo.png')}}"
            class="user-image rounded-circle shadow profile-img"
            alt="User Image"
            />
            <span class="d-none d-md-inline">Nama User</span>
        </a>
        </li>
        <hr/>
        <li class="nav-item">
        <a href="./docs/introduction.html" class="nav-link navigationbuttonactive">
            <i class="nav-icon bi bi-house"></i>
            <p>Dashboard</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="./docs/layout.html" class="nav-link navigationbutton">
            <i class="nav-icon bi bi-trash"></i>
            <p>Jenis Sampah</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="./docs/color-mode.html" class="nav-link navigationbutton">
            <i class="nav-icon bi bi-clock-history"></i>
            <p>Histori</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="./docs/color-mode.html" class="nav-link navigationbutton">
            <i class="nav-icon bi bi-check2-circle"></i>
            <p>Persetujuan</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="./docs/color-mode.html" class="nav-link navigationbutton">
            <i class="nav-icon bi bi-exclamation-diamond"></i>
            <p>Laporan</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="./docs/color-mode.html" class="nav-link navigationbutton">
            <i class="nav-icon bi bi-printer"></i>
            <p>Print Data</p>
        </a>
        </li>
    </ul>
    <!--end::Sidebar Menu-->
    </nav>
</div>
<!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->