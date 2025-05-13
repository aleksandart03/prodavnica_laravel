<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid px-2 px-lg-5">

        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img src="{{ asset('images/logo.jpg') }}" alt="AT Shop Logo" height="40" class="d-inline-block">
            <span class="fw-bold fs-5">AT Shop</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">

            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item me-4">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-box"></i> Products
                    </a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <i class="bi bi-list"></i> Categories
                    </a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="bi bi-info-circle"></i> About Us
                    </a>
                </li>
            </ul>


            <div class="d-flex align-items-center justify-content-center justify-content-lg-end mt-2 mt-lg-0">
                <a href="{{ route ('cart.index') }}" class="me-3 d-flex align-items-center">
                    <i class="bi bi-cart fs-4"></i>
                </a>

                @auth
                <a href="{{ route('dashboard') }}" class="me-3 d-flex align-items-center">
                    <button class="btn btn-primary">Dashboard</button>
                </a>
                @endauth

                @guest
                @if (Route::has('login'))
                <a href="{{ route('login') }}" class="me-3 d-flex align-items-center">
                    <i class="bi bi-person fs-4"></i>
                </a>
                @endif

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="d-flex align-items-center">
                    <i class="bi bi-person-plus fs-4"></i>
                </a>
                @endif
                @endguest
            </div>
        </div>
    </div>
</nav>