<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <img src="{{ secure_asset('assets/logo-unpak.png') }}" width="50" height="50" alt="">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen Data
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->is('criteria') ? 'active' : '' }}">
        <a class="nav-link" href="/criteria">
            <i class="fas fa-fw fa-table"></i>
            <span>Kriteria</span></a>
    </li>
    <li class="nav-item {{ request()->is('criteria-comparisons') ? 'active' : '' }}">
        <a class="nav-link" href="/criteria-comparisons">
            <i class="fas fa-fw fa-table"></i>
            <span>Perbandingan Kriteria</span></a>
    </li>
    <li class="nav-item {{ request()->is('alternatives') ? 'active' : '' }}">
        <a class="nav-link" href="/alternatives">
            <i class="fas fa-fw fa-table"></i>
            <span>Alternative</span></a>
    </li>
    <li class="nav-item {{ request()->is('alternatives-comparisons') ? 'active' : '' }}">
        <a class="nav-link" href="/alternatives-comparisons">
            <i class="fas fa-fw fa-table"></i>
            <span>Perbandingan Alternative Perkriteria</span></a>
    </li>
    <li class="nav-item {{ request()->is('perhitungan-ahp') ? 'active' : '' }}">
        <a class="nav-link" href="/perhitungan-ahp">
            <i class="fas fa-fw fa-table"></i>
            <span>Perhitungan AHP</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="d-none d-md-inline text-center">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
