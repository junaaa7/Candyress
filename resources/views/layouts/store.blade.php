<!DOCTYPE html>
<!-- Tambahkan class scroll-smooth di sini -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Candyress') - Premium Apps & Digital Accounts</title>

    <!-- Meta SEO -->
    <meta name="description" content="Temukan berbagai layanan digital premium untuk kebutuhan hiburan, produktivitas, desain, AI, dan lainnya di Candyress.">
    <meta name="theme-color" content="#FFE1EA">

    <!-- Favicon emoji permen -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍬</text></svg>">

    <!-- Font: Nunito (teks) & Fredoka (judul), dimuat sekali untuk semua halaman -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Dasar tema pink pastel (cadangan agar tampilan tetap benar sebelum CSS Tailwind ter-build) -->
    <style>
        body { background-color: #FFF5F8; color: #5B3A4A; font-family: 'Nunito', system-ui, sans-serif; }
        ::selection { background: #FF9EBB; color: #fff; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-brand-50 text-brand-900 selection:bg-brand-300 selection:text-white">

    <!-- Dekorasi SVG Candyress (maskot permen + hiasan), dipakai oleh home, navbar, dan footer -->
    <svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
        <defs>
            <symbol id="cute-mascot" viewBox="0 0 200 140">
                <path d="M54 70 L16 40 Q6 70 16 100 Z" fill="#EBDDFB" stroke="#5B3A4A" stroke-width="3" stroke-linejoin="round"/>
                <path d="M146 70 L184 40 Q194 70 184 100 Z" fill="#EBDDFB" stroke="#5B3A4A" stroke-width="3" stroke-linejoin="round"/>
                <path d="M38 58 Q34 70 38 82" fill="none" stroke="#5B3A4A" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M162 58 Q166 70 162 82" fill="none" stroke="#5B3A4A" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="100" cy="70" r="50" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="3"/>
                <path d="M66 42 Q78 30 94 28" fill="none" stroke="#fff" stroke-width="6" stroke-linecap="round" opacity=".7"/>
                <circle cx="130" cy="42" r="3" fill="#fff" opacity=".7"/>
                <circle cx="139" cy="56" r="2" fill="#fff" opacity=".7"/>
                <ellipse cx="82" cy="72" rx="5" ry="6.5" fill="#5B3A4A"/>
                <ellipse cx="118" cy="72" rx="5" ry="6.5" fill="#5B3A4A"/>
                <circle cx="84" cy="69.5" r="2" fill="#fff"/>
                <circle cx="120" cy="69.5" r="2" fill="#fff"/>
                <ellipse cx="67" cy="84" rx="9" ry="5.5" fill="#FF6F9C" opacity=".55"/>
                <ellipse cx="133" cy="84" rx="9" ry="5.5" fill="#FF6F9C" opacity=".55"/>
                <path d="M92 82 Q100 92 108 82" fill="none" stroke="#5B3A4A" stroke-width="3" stroke-linecap="round"/>
            </symbol>
            <symbol id="cute-heart" viewBox="0 0 32 32">
                <path d="M16 28 C6 20 2 14 2 9.5 C2 5.5 5 3 8.5 3 C11.5 3 14.5 4.8 16 7.5 C17.5 4.8 20.5 3 23.5 3 C27 3 30 5.5 30 9.5 C30 14 26 20 16 28Z" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="2" stroke-linejoin="round"/>
                <ellipse cx="9" cy="10" rx="2.5" ry="1.6" fill="#fff" opacity=".75" transform="rotate(-30 9 10)"/>
            </symbol>
            <symbol id="cute-sparkle" viewBox="0 0 32 32">
                <path d="M16 2 C17 11 21 15 30 16 C21 17 17 21 16 30 C15 21 11 17 2 16 C11 15 15 11 16 2Z" fill="#FFD98A" stroke="#5B3A4A" stroke-width="2" stroke-linejoin="round"/>
            </symbol>
            <symbol id="cute-cloud" viewBox="0 0 64 40">
                <path d="M16 36 C7 36 3 30 4 24 C5 18 10 15 15 16 C16 9 22 4 30 4 C38 4 43 9 44 15 C51 14 58 18 58 26 C58 32 54 36 48 36Z" fill="#fff" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round"/>
                <circle cx="25" cy="24" r="1.8" fill="#5B3A4A"/>
                <circle cx="39" cy="24" r="1.8" fill="#5B3A4A"/>
                <ellipse cx="20" cy="28" rx="3.2" ry="2" fill="#FF6F9C" opacity=".5"/>
                <ellipse cx="44" cy="28" rx="3.2" ry="2" fill="#FF6F9C" opacity=".5"/>
                <path d="M29 27 Q32 30 35 27" fill="none" stroke="#5B3A4A" stroke-width="1.8" stroke-linecap="round"/>
            </symbol>
            <symbol id="cute-bow" viewBox="0 0 48 32">
                <path d="M24 16 L5 4 Q0 16 5 28 Z" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="2" stroke-linejoin="round"/>
                <path d="M24 16 L43 4 Q48 16 43 28 Z" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="2" stroke-linejoin="round"/>
                <circle cx="24" cy="16" r="5" fill="#D6477F" stroke="#5B3A4A" stroke-width="2"/>
            </symbol>

            <!-- Ikon kategori -->
            <symbol id="cute-ic-streaming" viewBox="0 0 48 48">
                <path d="M17 10 L24 4 L31 10" fill="none" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <rect x="5" y="11" width="38" height="27" rx="7" fill="#fff" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <path d="M20 18 L33 24.5 L20 31Z" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <path d="M14 38 V42 M34 38 V42" fill="none" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
            </symbol>
            <symbol id="cute-ic-ai" viewBox="0 0 48 48">
                <path d="M24 14 V8" fill="none" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <circle cx="24" cy="6" r="3" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <rect x="3.5" y="23" width="5" height="9" rx="2.5" fill="#EBDDFB" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <rect x="39.5" y="23" width="5" height="9" rx="2.5" fill="#EBDDFB" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <rect x="8" y="14" width="32" height="26" rx="10" fill="#fff" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <circle cx="18" cy="26" r="2.6" fill="#5B3A4A"/>
                <circle cx="30" cy="26" r="2.6" fill="#5B3A4A"/>
                <ellipse cx="14" cy="32" rx="3" ry="2" fill="#FF6F9C" opacity=".5"/>
                <ellipse cx="34" cy="32" rx="3" ry="2" fill="#FF6F9C" opacity=".5"/>
                <path d="M21 32 Q24 35 27 32" fill="none" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
            </symbol>
            <symbol id="cute-ic-design" viewBox="0 0 48 48">
                <path d="M24 6 C13 6 5 14 5 24 C5 34 13 42 23 42 C28 42 29 38 26.5 35.5 C24 33 26 30 29.5 30 L36 30 C40.5 30 43 27 43 23 C43 13.5 35 6 24 6Z" fill="#FFF3EA" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <circle cx="15" cy="23" r="3.2" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="1.6"/>
                <circle cx="22" cy="14.5" r="3.2" fill="#C9A7F0" stroke="#5B3A4A" stroke-width="1.6"/>
                <circle cx="32.5" cy="16" r="3.2" fill="#FFD98A" stroke="#5B3A4A" stroke-width="1.6"/>
                <circle cx="16" cy="33" r="3.2" fill="#9FD8C0" stroke="#5B3A4A" stroke-width="1.6"/>
            </symbol>
            <symbol id="cute-ic-productivity" viewBox="0 0 48 48">
                <rect x="7" y="26" width="10" height="14" rx="3" fill="#C9A7F0" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <rect x="19" y="18" width="10" height="22" rx="3" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <rect x="31" y="9" width="10" height="31" rx="3" fill="#FFD98A" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <path d="M5 42 H43" fill="none" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <path d="M11 11 C11.4 14 12.6 15.2 15.5 15.5 C12.6 15.8 11.4 17 11 20 C10.6 17 9.4 15.8 6.5 15.5 C9.4 15.2 10.6 14 11 11Z" fill="#fff" stroke="#5B3A4A" stroke-width="1.6" stroke-linejoin="round"/>
            </symbol>
            <!-- Ikon fitur -->
            <symbol id="cute-ic-bolt" viewBox="0 0 48 48">
                <path d="M28 4 L10 27 H22 L19 44 L38 20 H26Z" fill="#FFD98A" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <path d="M26 11 L17 23" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round" opacity=".8"/>
            </symbol>
            <symbol id="cute-ic-shield" viewBox="0 0 48 48">
                <path d="M24 4 L39 9.5 V23 C39 33 32 40 24 44 C16 40 9 33 9 23 V9.5Z" fill="#DCC6F7" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <path d="M24 34 C17 29 15 25 15 22 C15 19.5 17 18 19 18 C21 18 23 19 24 21 C25 19 27 18 29 18 C31 18 33 19.5 33 22 C33 25 31 29 24 34Z" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="1.8" stroke-linejoin="round"/>
            </symbol>
            <!-- Lollipop -->
            <symbol id="cute-ic-lollipop" viewBox="0 0 48 48">
                <path d="M24 31 V45" fill="none" stroke="#5B3A4A" stroke-width="2.8" stroke-linecap="round"/>
                <path d="M24 38 L17 35 Q15 39 17 43Z M24 38 L31 35 Q33 39 31 43Z" fill="#EBDDFB" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <circle cx="24" cy="18" r="15" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>
                <path d="M24 18 C24 15 28 15 28 18 C28 23 20 23 20 18 C20 12 31 11 31 18 C31 26 17 27 17 18" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round"/>
            </symbol>
        </defs>
    </svg>


    <!-- Navbar Component -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="min-h-screen pt-16">
        @yield('content')
    </main>

    <!-- Footer Component -->
    @include('components.footer')

</body>
</html>