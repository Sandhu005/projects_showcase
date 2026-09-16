<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adminHMD professional admin dashboard template">
    <title>@yield('page') | Admin</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="admin-shell">
        <div class="sidebar-backdrop" data-sidebar-close></div>

        <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
            <div class="sidebar-header">
                <a class="brand-mark" href="index.html" aria-label="adminHMD dashboard">
                    <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
                    <span class="brand-copy">
                        <span class="brand-title">Admin Dashboard</span>
                        <span class="brand-subtitle">Admin</span>
                    </span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}" aria-current="page">
                    <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a class="nav-link {{ request()->routeIs('farmers.index') ? 'active' : '' }}"
                    href="{{ route('farmers.index') }}">
                    <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    <span class="nav-text">Farmer Profiles</span>
                </a>

                <!-- Users Menu -->
                <a class="nav-link" data-bs-toggle="collapse" href="#usersMenu">
                    <span class="nav-icon">
                        <i class="bi bi-person-plus"></i>
                    </span>
                    <span class="nav-text">Users</span>
                    <i class="bi bi-chevron-down float-end"></i>
                </a>

                <div class="collapse {{ request()->routeIs('users.*') ? 'show' : '' }}" id="usersMenu">
                    @can('manage users')
                        <a class="nav-link ps-5 {{ request()->routeIs('users.create') ? 'active' : '' }}"
                            href="{{ route('users.create') }}">
                            Add User
                        </a>
                    @endcan
                    <a class="nav-link ps-5 {{ request()->routeIs('users.index') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        View Users
                    </a>
                </div>
                
                <!-- Crops Menu -->
                <a class="nav-link" data-bs-toggle="collapse" href="#cropsMenu">
                    <span class="nav-icon">
                        <i class="bi bi-leaf"></i>
                    </span>
                    <span class="nav-text">Crops</span>
                    <i class="bi bi-chevron-down float-end"></i>
                </a>

                <div class="collapse {{ request()->routeIs('crops.*') ? 'show' : '' }}" id="cropsMenu">
                    @can('manage crops')
                        <a class="nav-link ps-5 {{ request()->routeIs('crops.create') ? 'active' : '' }}"
                            href="{{ route('crops.create') }}">
                            Add Crop
                        </a>
                    @endcan
                    <a class="nav-link ps-5 {{ request()->routeIs('crops.index') ? 'active' : '' }}"
                        href="{{ route('crops.index') }}">
                        View Crops
                    </a>
                </div>
                
                <!-- Seeds Menu -->
                {{-- <a class="nav-link" data-bs-toggle="collapse" href="#seedsMenu">
                    <span class="nav-icon">
                        <i class="bi bi-tree"></i>
                    </span>
                    <span class="nav-text">Seeds</span>
                    <i class="bi bi-chevron-down float-end"></i>
                </a>

                <div class="collapse {{ request()->routeIs('seeds.*') ? 'show' : '' }}" id="seedsMenu">
                    @can('manage seeds')
                        <a class="nav-link ps-5 {{ request()->routeIs('seeds.create') ? 'active' : '' }}"
                            href="{{ route('seeds.create') }}">
                            Add Seed
                        </a>
                    @endcan
                    <a class="nav-link ps-5 {{ request()->routeIs('seeds.index') ? 'active' : '' }}"
                        href="{{ route('seeds.index') }}">
                        View Seeds
                    </a>
                </div> --}}
                
                <a class="nav-link" href="{{ route('weather.index') }}">
                    <span class="nav-icon"><i class="bi bi-bar-chart-line" aria-hidden="true"></i></span>
                    <span class="nav-text">Weather Data</span>
                </a>


                {{-- <a class="nav-link" href="profile.html">
          <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
          <span class="nav-text">Profile</span>
        </a>
        <a class="nav-link" href="tables.html">
          <span class="nav-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
          <span class="nav-text">Tables</span>
        </a>
        <a class="nav-link" href="forms.html">
          <span class="nav-icon"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i></span>
          <span class="nav-text">Forms</span>
        </a>
        <a class="nav-link" href="components.html">
          <span class="nav-icon"><i class="bi bi-grid-3x3-gap" aria-hidden="true"></i></span>
          <span class="nav-text">Components</span>
        </a>
        <a class="nav-link" href="alerts.html">
          <span class="nav-icon"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></span>
          <span class="nav-text">Alerts</span>
        </a>
        <a class="nav-link" href="modals.html">
          <span class="nav-icon"><i class="bi bi-window-stack" aria-hidden="true"></i></span>
          <span class="nav-text">Modals</span>
        </a> --}}
                <a class="nav-link" href="settings.html">
                    <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
                    <span class="nav-text">Settings</span>
                </a>
            </nav>

            <div class="sidebar-user">
                <img class="avatar-img avatar-md sidebar-user-avatar" src="{{ url('images/avatar/avatar.jpg') }}"
                    alt="Admin {{ $user['name'] }}">
                <strong>Admin {{ $user['name'] }}</strong>
                <small>Active Workspace</small>
            </div>

            <div class="sidebar-footer">
                <span class="status-dot"></span>
                <span class="sidebar-footer-text">System running smoothly</span>
            </div>
        </aside>

        <div class="admin-main">
            <nav class="navbar admin-navbar navbar-expand bg-white">
                <div class="container-fluid px-3 px-lg-4">
                    <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar"
                        aria-expanded="true" aria-label="Toggle sidebar">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
                        <input class="form-control search-input" type="search"
                            placeholder="Search users, orders, reports" aria-label="Search">
                    </form>

                    <div class="navbar-actions ms-auto">
                        <button class="icon-button theme-toggle" type="button" data-theme-toggle
                            aria-label="Switch color theme" title="Switch color theme">
                            <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
                        </button>
                        <div class="dropdown">
                            <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                aria-label="Notifications">
                                <span class="notification-dot"></span>
                                <i class="bi bi-bell" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end notification-menu">
                                <div class="dropdown-header fw-bold text-body">Notifications</div>
                                <a class="dropdown-item" href="users.html">
                                    <span class="notification-title">New user registered</span>
                                    <span class="notification-time">4 minutes ago</span>
                                </a>
                                <a class="dropdown-item" href="charts.html">
                                    <span class="notification-title">Revenue target reached</span>
                                    <span class="notification-time">32 minutes ago</span>
                                </a>
                                <a class="dropdown-item" href="settings.html">
                                    <span class="notification-title">Security review completed</span>
                                    <span class="notification-time">1 hour ago</span>
                                </a>
                            </div>
                        </div>

                        <div class="dropdown">
                            <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img class="avatar-img avatar-sm" src="{{ url('images/avatar/avatar.jpg') }}"
                                    alt="Admin {{ $user['name'] }}">
                                <span class="profile-name d-none d-sm-inline">Admin {{ $user['name'] }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                                <li><a class="dropdown-item" href="settings.html">Account settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button class="dropdown-item">Sign out</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>


            @yield('content')


            <footer class="admin-footer">
                <div class="container-fluid px-3 px-lg-4">
                    <span>Copyright 2026 Admin Dashboard. <br> Developed by <a target="_blank"
                            class="fw-bold text-success" href="https://lotusinfotech.co.in/">Lotus Infotech</a></span>
                    <span>Professional dashboard.</span>
                </div>
            </footer>
        </div>
    </div>

    <script>
        window.user = {{ Js::from($user) }};
    </script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
