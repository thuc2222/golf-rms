<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Golf Tour System') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">

<div class="min-h-screen">
    {{-- Navigation --}}
    @include('layouts.navigation')

    {{-- Page Content --}}
    <main class="py-6">
        @yield('content')
    </main>
</div>

@livewireScripts
</body>
</html>
