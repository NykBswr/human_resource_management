<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>HRM MANAGEMENT</title>
    {{-- CSS Tailwind --}}
    @vite('resources/css/app.css')
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('images/logo-ftmm.png') }}" />
</head>
<body class="bg-dark h-screen w-full">
    @yield('container')
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>