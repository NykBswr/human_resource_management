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

    <link rel="icon" href="{{ asset('img/logo.png') }}" />
</head>

<body class="h-full w-full bg-dark">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script>
    @yield('container')
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
