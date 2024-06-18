<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @if (config('app.env') === 'production')
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif

    <title>{{ config('app.name', 'Het Koppel - ') }} - @yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sponsor-carousel.css') }}">
    @stack('styles')

    <!-- Scripts -->
    <script src="{{ asset('js/tailwind.js') }}"></script>
    <script type="module" src="{{ asset('js/tailwindconfig.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

</head>

<body class="font-montserrat flex flex-col min-h-[100vh]">
    <div>
        <header class="w-full">
            <x-header.navigation-bar />
        </header>

        <main class="inner-wrap mx-auto max-w-[1200px] px-8 md:px-20 mt-12 flex-grow">
            @yield('content')
        </main>
    </div>

    <x-footer-component />

    <script type="module" src="{{ asset('js/post/feed.js') }}"></script>
    @stack('scripts')
</body>

</html>
