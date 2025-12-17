<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' : '' }}Polijub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-gray-100 text-gray-900" data-theme="light">

    <livewire:layout.navbar />

    {{-- MAIN CONTENT --}}
    <main>
        {{ $slot }}
    </main>

    <x-footer />

    <x-toast />
    <livewire:layout.floating-cart-bubble />
    @livewireScripts
    @stack('scripts')
</body>

</html>