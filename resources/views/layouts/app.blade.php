<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-900 text-gray-200">
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
