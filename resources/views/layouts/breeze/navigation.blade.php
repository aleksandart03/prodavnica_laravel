<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-3">
                <!-- Dashboard Link -->
                <li class="nav-item mx-3">
                    <a class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door-fill"></i> {{ __('Dashboard') }}
                    </a>
                </li>

                <!-- Store Link -->
                <li class="nav-item mx-3">
                    <a class="nav-link {{ request()->routeIs('home') || request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-shop-window"></i> {{ __('Store') }}
                    </a>
                </li>

                <!-- Profile Link -->
                <li class="nav-item mx-3">
                    <a class="nav-link {{ request()->routeIs('profile.edit') || request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person-circle"></i> {{ __('Profile') }}
                    </a>
                </li>
            </ul>

            <!-- Dropdown Menu za korisnika -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-bold">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>