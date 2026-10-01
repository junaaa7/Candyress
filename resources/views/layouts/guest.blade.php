<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#FFE1EA">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon emoji permen -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍬</text></svg>">

        <!-- Scripts. Font Nunito & Fredoka dimuat dari app.css -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-brand-900 antialiased">
        <!-- Gambar SVG maskot & hiasan -->
        @include('components.cute-defs')

        <!-- Hiasan latar (fixed, agar tidak memengaruhi scroll halaman) -->
        <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden" aria-hidden="true">
            <div class="absolute inset-0 bg-cute-dots opacity-20"></div>
            <div class="absolute -left-24 -top-24 h-96 w-96 rounded-full bg-accent-100 opacity-70 blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-peach opacity-80 blur-3xl"></div>
            <svg class="absolute left-[10%] top-[16%] hidden h-[3.25rem] w-[3.25rem] -rotate-12 md:block" viewBox="0 0 32 32"><use href="#cute-heart"/></svg>
            <svg class="absolute right-[11%] top-[22%] hidden h-[3.25rem] w-[3.25rem] rotate-[10deg] md:block" viewBox="0 0 32 32"><use href="#cute-sparkle"/></svg>
            <svg class="absolute bottom-[16%] left-[14%] hidden h-[3.4rem] w-[5.5rem] rotate-6 md:block" viewBox="0 0 64 40"><use href="#cute-cloud"/></svg>
            <svg class="absolute bottom-[18%] right-[16%] hidden h-[2.8rem] w-[4.25rem] -rotate-[8deg] md:block" viewBox="0 0 48 32"><use href="#cute-bow"/></svg>
        </div>

        <div class="relative z-10 flex min-h-screen flex-col items-center bg-gradient-to-b from-brand-100/60 to-brand-50 px-4 pb-8 pt-6 sm:justify-center sm:pt-0">
            <div>
                <a href="/" class="flex flex-col items-center">
                    <svg class="mb-2 block h-auto w-[7rem] animate-float motion-reduce:animate-none" viewBox="0 0 200 140" role="img" aria-label="Maskot permen Candyress"><use href="#cute-mascot"/></svg>
                    <span class="font-display text-3xl font-bold text-brand-600">Candyress.</span>
                </a>
            </div>

            <div class="cute-card mt-6 w-full overflow-hidden px-6 py-6 shadow-[0_8px_0_theme(colors.brand.100)] sm:max-w-md sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>