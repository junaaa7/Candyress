<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Toko Akun Premium</title>
    <meta name="theme-color" content="#FFE1EA">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍬</text></svg>">

    <!-- Font: Nunito (teks) & Fredoka (judul) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --c-blush: #FFF5F8;
            --c-petal: #FFE1EA;
            --c-rose: #FF9EBB;
            --c-berry: #D6477F;
            --c-cocoa: #5B3A4A;
            --c-lilac: #EBDDFB;
            --c-peach: #FFE6D6;
        }

        .login-body {
            position: relative; overflow: hidden; min-height: 100vh;
            display: flex; align-items: center; justify-content: center; padding: 2rem 1rem;
            font-family: 'Nunito', system-ui, sans-serif; color: var(--c-cocoa);
            background: linear-gradient(180deg, #FFEAF1 0%, var(--c-blush) 100%);
        }
        .login-dots { position: absolute; inset: 0; opacity: .22; pointer-events: none;
            background-image: radial-gradient(var(--c-rose) 1.4px, transparent 1.4px); background-size: 22px 22px; }
        .login-blob-a { position: absolute; top: -6rem; left: -6rem; width: 24rem; height: 24rem; border-radius: 999px; background: var(--c-lilac); filter: blur(64px); opacity: .7; pointer-events: none; }
        .login-blob-b { position: absolute; bottom: -6rem; right: -6rem; width: 24rem; height: 24rem; border-radius: 999px; background: var(--c-peach); filter: blur(64px); opacity: .8; pointer-events: none; }

        /* Stickers */
        .login-s { position: absolute; width: 3.25rem; height: 3.25rem; display: none; transform: rotate(var(--r, 0deg)); }
        .login-s3 { width: 5.5rem; height: 3.4rem; }
        .login-s4 { width: 4.25rem; height: 2.8rem; }
        .login-mascot { display: block; width: 7.5rem; height: auto; margin: 0 auto .75rem; animation: login-float 5s ease-in-out infinite; }
        .login-s1 { left: 10%; top: 16%; --r: -12deg; }
        .login-s2 { right: 11%; top: 22%; --r: 10deg }
        .login-s3 { left: 14%; bottom: 16%; --r: 8deg }
        .login-s4 { right: 16%; bottom: 18%; --r: -8deg }
        @media (min-width: 768px) { .login-s { display: block; } }
        @keyframes login-float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @media (prefers-reduced-motion: reduce) { .login-mascot { animation: none; } }

        .login-wrap { position: relative; z-index: 1; width: 100%; max-width: 28rem; }
        .login-brand { display: block; text-align: center; margin-bottom: 1.25rem; text-decoration: none;
            font-family: 'Fredoka', sans-serif; font-weight: 700; font-size: 1.75rem; color: var(--c-berry); }

        .login-card { background: #fff; border: 2px solid var(--c-petal); border-radius: 1.75rem;
            box-shadow: 0 8px 0 var(--c-petal); padding: 2rem; }
        .login-head { text-align: center; margin-bottom: 2rem; }
        .login-title { font-family: 'Fredoka', sans-serif; font-weight: 700; font-size: 1.75rem; line-height: 1.2; margin: 0; }
        .login-sub { margin: .6rem 0 0; font-size: .95rem; color: #9C7A8A; }

        .login-field { margin-bottom: 1.25rem; }
        .login-label { display: block; font-size: .9rem; font-weight: 700; margin-bottom: .5rem; }
        .login-input { width: 100%; padding: .75rem 1.1rem; border-radius: 1rem; border: 2px solid var(--c-petal);
            background: var(--c-blush); color: var(--c-cocoa); font-family: inherit; font-size: 1rem;
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease; }
        .login-input::placeholder { color: #C9A9B6; }
        .login-input:focus { outline: none; border-color: var(--c-rose); background: #fff; box-shadow: 0 0 0 4px rgba(255, 158, 187, .28); }

        .login-row { display: flex; align-items: center; justify-content: space-between; gap: .75rem; margin: .25rem 0 1.5rem; }
        .login-check { display: flex; align-items: center; gap: .5rem; font-size: .9rem; color: #9C7A8A; cursor: pointer; }
        .login-check input { width: 1.15rem; height: 1.15rem; accent-color: var(--c-rose); cursor: pointer; }
        .login-link { color: var(--c-berry); font-weight: 700; text-decoration: none; }
        .login-link:hover { text-decoration: underline; text-underline-offset: 3px; }

        .login-btn { width: 100%; padding: .95rem 1rem; border: 0; border-radius: 999px; cursor: pointer;
            background: var(--c-rose); color: #fff; font-family: 'Fredoka', sans-serif; font-weight: 600; font-size: 1.1rem;
            box-shadow: 0 5px 0 var(--c-berry); transition: transform .15s ease, box-shadow .15s ease; }
        .login-btn:hover { transform: translateY(2px); box-shadow: 0 3px 0 var(--c-berry); }
        .login-btn:focus-visible { outline: 3px solid var(--c-berry); outline-offset: 3px; }

        .login-foot { margin: 1.75rem 0 0; text-align: center; font-size: .95rem; color: #9C7A8A; }
    </style>
</head>
<body class="login-body">
    <div class="login-dots" aria-hidden="true"></div>
    <div class="login-blob-a" aria-hidden="true"></div>
    <div class="login-blob-b" aria-hidden="true"></div>

    <!-- Dekorasi SVG orisinal Candyress (maskot permen + hiasan) -->
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
        </defs>
    </svg>

    <svg class="login-s login-s1" style="--r:-12deg" viewBox="0 0 32 32" aria-hidden="true"><use href="#cute-heart"/></svg>
    <svg class="login-s login-s2" style="--r:10deg" viewBox="0 0 32 32" aria-hidden="true"><use href="#cute-sparkle"/></svg>
    <svg class="login-s login-s3" style="--r:6deg" viewBox="0 0 64 40" aria-hidden="true"><use href="#cute-cloud"/></svg>
    <svg class="login-s login-s4" style="--r:-8deg" viewBox="0 0 48 32" aria-hidden="true"><use href="#cute-bow"/></svg>

    <div class="login-wrap">
        <svg class="login-mascot" viewBox="0 0 200 140" role="img" aria-label="Maskot permen Candyress"><use href="#cute-mascot"/></svg>
        <a href="/" class="login-brand"><span aria-hidden="true">🍬</span> Candyress.</a>

        <div class="login-card">
            <div class="login-head">
                <h1 class="login-title">Selamat Datang Kembali 💕</h1>
                <p class="login-sub">Masuk untuk mulai berlangganan Netflix, Canva, &amp; AI</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Email -->
                <div class="login-field">
                    <label class="login-label" for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="login-input" placeholder="nama@email.com" required autofocus>
                </div>

                <!-- Password -->
                <div class="login-field">
                    <label class="login-label" for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="login-input" placeholder="••••••••" required>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="login-row">
                    <label class="login-check">
                        <input type="checkbox" name="remember">
                        <span>Ingat Saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="login-link" style="font-size: .9rem;">Lupa sandi?</a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-btn">Masuk Sekarang</button>
            </form>

            <p class="login-foot">
                Belum punya akun? <a href="{{ route('register') }}" class="login-link">Daftar di sini</a>
            </p>
        </div>
    </div>
</body>
</html>