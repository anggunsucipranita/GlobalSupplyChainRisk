<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Supply Chain Risk Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    {{-- 🔥 INI PENTING BUAT CHART / JS DARI PAGE --}}
    @stack('scripts')

</body>
</html>