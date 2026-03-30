<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - {{ config('app.name', 'SimplyBook') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#f4f6ff] text-[#203044]">

<div class="flex h-screen overflow-hidden">

    <aside class="hidden lg:block w-[256px] h-full shrink-0 border-r border-gray-100 bg-white overflow-y-auto">
        <x-sidebar />
    </aside>

    <div class="flex flex-col flex-1 min-w-0 h-full relative">

        <livewire:components.x-admin-navbar />

        <main class="flex-1 overflow-y-auto p-[32px]">
            <div class="max-w-[1400px] mx-auto">
                {{ $slot }}
            </div>

            <x-need-help-section/>

        </main>

    </div>


</div>



<x-mobile-menu-modal />
<x-mobile-search-modal />

</body>
</html>
