<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AT Shop</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Include the navbar -->
    @include('partials.navbar')

    <div class="page-wrapper flex-grow-1">
        <main class="container my-5 text-center">
            @yield('content')
        </main>
    </div>

    <!-- Include the footer -->
    @include('partials.footer')

    @stack('scripts')

</body>

</html>