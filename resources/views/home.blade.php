<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AT Shop</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body class="bg-light">


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
                        <a class="nav-link active" href="#"><i class="bi bi-house-door"></i> Home</a>
                    </li>
                    <li class="nav-item me-4">
                        <a class="nav-link" href="#"><i class="bi bi-box"></i> Products</a>
                    </li>
                    <li class="nav-item me-4">
                        <a class="nav-link" href="#"><i class="bi bi-list"></i> Categories</a>
                    </li>
                    <li class="nav-item me-4">
                        <a class="nav-link" href="#"><i class="bi bi-info-circle"></i> About Us</a>
                    </li>
                </ul>


                <div class="d-flex align-items-center justify-content-center justify-content-lg-end mt-2 mt-lg-0">
                    <a href="#" class="me-3 d-flex align-items-center">
                        <i class="bi bi-cart fs-4"></i>
                    </a>

                    @auth
                    <!-- Ako je ulogovan, prikaži link za Dashboard -->
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


    <main class="container my-5 text-center">
        <h1 class="display-4">Dobrodošli u AT Shop!</h1>
        <p class="lead">Najbolja online prodavnica za vas.</p>
    </main>

</body>

</html>