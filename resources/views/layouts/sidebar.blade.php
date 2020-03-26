<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-home"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ThiReMa</div>
    </a>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Generale
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <li class="nav-item">
        <a class="nav-link" href="{{ route('settings.edit') }}"><!-- route('settings.index') -->
            <i class="fas fa-fw fa-cog"></i>
            <span>Impostazioni</span></a>
    </li>
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Dati
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('devices.index') }}">
            <i class="fas fa-fw fa-microchip"></i>
            <span>Dispositivi e sensori</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#"><!-- route('views.index') -->
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Pagine view</span></a>
    </li>

    @canany(['isAdmin', 'isMod'])
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Centro di Controllo
    </div>
    @endcanany

    @can('isMod')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMod" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Moderazione</span>
        </a>
        <div id="collapseMod" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('users.index') }}"><i class="fas fa-users"></i> Utenti</a>
                <a class="collapse-item" href="{{ route('devices.index') }}"><i class="fas fa-microchip"></i> Gestione Dispositivi</a>
                <a class="collapse-item" href="#"><i class="fas fa-bell"></i> Gestione Alert</a>
            </div>
        </div>
    </li>
    @endcan


    @can('isAdmin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user-secret"></i>
            <span>Amministrazione</span>
        </a>
        <div id="collapseAdmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#"><i class="fas fa-bell"></i> Gestione Alert</a>
                <a class="collapse-item" href="{{ route('users.index') }}"><i class="fas fa-users"></i> Gestione Utenti</a>
                <a class="collapse-item" href="#"><i class="far fa-building"></i> Gestione Enti</a>
                <a class="collapse-item" href="{{ route('devices.index') }}"><i class="fas fa-microchip"></i> Gestione Dispositivi</a>
                <a class="collapse-item" href="{{ route('gateway.index') }}"><i class="fas fa-dungeon"></i> Gestione Gateway</a>
            </div>
        </div>
    </li>
    @endcan


    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

