<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Crossailors') }} — BSMT Portal</title>
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='6' fill='%231E4D9C'/><text x='50%25' y='54%25' dominant-baseline='middle' text-anchor='middle' font-size='20' font-family='serif'>⚓</text></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col bg-gradient-to-br from-brand-700 via-brand-800 to-brand-900">

            {{-- Back to Home --}}
            <div class="px-6 pt-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-brand-200 hover:text-white text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Home
                </a>
            </div>

            <div class="flex flex-1 flex-col sm:justify-center items-center px-4 py-10">

                {{-- Logo + Brand --}}
                <div class="mb-6 text-center">
                    <div class="flex items-center justify-center gap-2 mb-1">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L2 9l10 6 10-6-10-6zM2 17l10 6 10-6M2 13l10 6 10-6"/>
                        </svg>
                        <span class="text-white font-bold text-2xl tracking-wide">Crossailors</span>
                    </div>
                    <p class="text-brand-200 text-sm">BSMT Department Portal</p>
                </div>

                <div class="w-full sm:max-w-md bg-white rounded-2xl shadow-2xl px-8 py-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
