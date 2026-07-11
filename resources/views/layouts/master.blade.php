<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Global Supply Chain Risk Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CSS khusus tiap halaman --}}
    @stack('styles')

</head>

<body class="bg-dark text-light">

    @include('partials.navbar')

    <div class="container-fluid p-0">

        <div class="row g-0">

            @include('partials.sidebar')

            <main class="col-md-10 p-4 bg-dark min-vh-100">

                @yield('content')

            </main>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

    {{-- JavaScript khusus tiap halaman --}}
    @stack('scripts')

</body>

</html>