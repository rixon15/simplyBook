<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SimplyBook') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#f4f6ff] flex flex-col min-h-screen">

<x-navbar/>

<main class="flex-grow">
    {{ $slot }}
</main>

@auth
    @if(auth()->user()?->role !== 'admin')
        {{-- CUSTOMER VIEW --}}
        <div class="block md:hidden">
            <x-bottom-navbar />
        </div>

        <div class="hidden md:block">
            <x-footer-main />
        </div>
    @else
        {{-- ADMIN: Always show Footer --}}
        <x-footer-main />
    @endif
@else
    {{-- GUEST: Always show Footer --}}
    <x-footer-main />
@endauth

</body>
</html>

