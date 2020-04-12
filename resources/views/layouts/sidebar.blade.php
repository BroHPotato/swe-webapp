<!-- Sidebar -->
<!-- Classe toggled to set the closed sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-project-diagram"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ThiReMa</div>
    </a>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Generale
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt text-info"></i>
            <span>Dashboard</span>
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link" href="{{ route('settings.edit') }}">
            <i class="fas fa-fw fa-cog text-info"></i>
            <span>Impostazioni</span>
        </a>
    </li>
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Dati
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('devices.index') }}">
            <i class="fas fa-fw fa-microchip"></i>
            <span>Dispositivi e sensori</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('views.index') }}">
            <i class="fas fa-fw fa-chart-bar"> </i>
            <span>Pagine view</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('alerts.index') }}">
            <i class="fas fa-fw fa-bell"> </i>
            <span>Alerts</span>
        </a>
    </li>

    @can('isMod')
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Mod
    </div>

    <li class="nav-item">
        <a href="#" data-toggle="collapse" data-target="#collapseMod" aria-expanded="false" aria-controls="collapseMod" class="nav-link collapsed">
            <i class="fas fa-fw fa-user-tie text-success"></i>
            <span>Moderazione</span>
        </a>
        <div id="collapseMod" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('users.index') }}"><i class="fas fa-users"></i> Gestione utenti</a>
                <a class="collapse-item" href="{{ route('logs.index') }}"><i class="fas fa-receipt"></i> Logs</a>
            </div>
        </div>
    </li>
    @endcan


    @can('isAdmin')

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Admin
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin">
            <i class="fas fa-fw fa-user-tie text-danger"></i>
            <span>Amministrazione</span>
        </a>
        <div id="collapseAdmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('users.index') }}"><i class="fas fa-users"></i> Gestione utenti</a>
                <a class="collapse-item" href="{{ route('entities.index') }}"><i class="far fa-building"></i> Gestione enti</a>
                <a class="collapse-item" href="{{ route('devices.index') }}"><i class="fas fa-microchip"></i> Gestione dispositivi</a>
                <a class="collapse-item" href="{{ route('gateways.index') }}"><i class="fas fa-dungeon"></i> Gestione gateways</a>
                <a class="collapse-item" href="{{ route('logs.index') }}"><i class="fas fa-receipt"></i> Logs</a>
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

