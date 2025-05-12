<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AT Shop</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light">

    <!-- Include the navbar -->
    @include('partials.navbar')

    <main class="container my-5 text-center">
        @yield('content')
    </main>

    <!-- Include the footer -->
    @include('partials.footer')

</body>

</html>