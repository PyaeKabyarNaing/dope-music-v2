<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased dark:bg-dark dark:text-white bg-white text-black">
    <!-- whole page -->
    <div class="min-h-screen">

        <!-- navbar -->
        @include('layouts.nav')

        <!-- sidebar -->
        @include('layouts.sidebar')

        <!-- Page Heading -->
        @isset($header)
            <header class="shadow ml-[21%] mt-[8%]">
                <div class="max-w-7xl mx-auto pt-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main
            class="lg:ml-[250px] ml-5 mt-[85px] mb-[85px] 
        @if (Route::is('album.show')) sm:mr-[30%] @endif">
            {{ $slot }}
        </main>

        <!-- audio player -->
        @include('layouts.audiobar')
    </div>

    <script src="{{ asset('js/player.js') }}"></script>
</body>

</html>
