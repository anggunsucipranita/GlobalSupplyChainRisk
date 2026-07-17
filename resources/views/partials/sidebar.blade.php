<aside class="sidebar">

    <div class="sidebar-logo">

        <div class="logo-icon">

            🌍

        </div>

        <div>

            <h5 class="mb-0 fw-bold">

                SC Risk

            </h5>

            <small>

                Supply Chain Dashboard

            </small>

        </div>

    </div>

    <ul class="nav flex-column mt-4">

        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('countries') }}"
               class="nav-link {{ request()->routeIs('countries') ? 'active' : '' }}">
                <i class="bi bi-globe2"></i>
                <span>Countries</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('weather') }}"
               class="nav-link {{ request()->routeIs('weather') ? 'active' : '' }}">
                <i class="bi bi-cloud-sun-fill"></i>
                <span>Weather</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('currency') }}"
               class="nav-link {{ request()->routeIs('currency') ? 'active' : '' }}">
                <i class="bi bi-currency-exchange"></i>
                <span>Currency</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('economy') }}"
               class="nav-link {{ request()->routeIs('economy') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i>
                <span>Economy</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('news') }}"
               class="nav-link {{ request()->routeIs('news') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i>
                <span>News</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('ports') }}"
               class="nav-link {{ request()->routeIs('ports') ? 'active' : '' }}">
                <i class="bi bi-water"></i>
                <span>Ports</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('comparison') }}"
               class="nav-link {{ request()->routeIs('comparison') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i>
                <span>Comparison</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('risk') }}"
               class="nav-link {{ request()->routeIs('risk') ? 'active' : '' }}">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>Risk Analysis</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('watchlists.index') }}"
               class="nav-link {{ request()->routeIs('watchlists.*') ? 'active' : '' }}">
                <i class="bi bi-star-fill"></i>
                <span>Favorite</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('visualization') }}"
               class="nav-link {{ request()->routeIs('visualization') ? 'active' : '' }}">
                <i class="bi bi-pie-chart-fill"></i>
                <span>Visualization</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Admin Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.users') }}"
               class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>User Management</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.ports') }}"
               class="nav-link {{ request()->routeIs('admin.ports') ? 'active' : '' }}">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Port Management</span>
            </a>
        </li>

        <li class="nav-item mb-4">
            <a href="{{ route('admin.articles') }}"
               class="nav-link {{ request()->routeIs('admin.articles') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Articles</span>
            </a>
        </li>

    </ul>

</aside>