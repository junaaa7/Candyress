import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                // Teks biasa
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                // Judul & tombol (font bulat yang lucu)
                display: ['Fredoka', 'Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Pink pastel utama. Nilainya sama persis dengan variabel warna di file Blade:
                // 50 = blush, 100 = petal, 300 = rose, 600 = berry, 900 = cocoa
                brand: {
                    50: '#FFF5F8',   // blush (latar halaman)
                    100: '#FFE1EA',  // petal (latar kartu/pill)
                    200: '#FFC8D9',
                    300: '#FF9EBB',  // rose (tombol utama, border)
                    400: '#F77FA6',
                    500: '#E86FA0',  // hover / gradasi
                    600: '#D6477F',  // berry (teks aksen, link)
                    700: '#B83468',  // hover berry
                    800: '#8E3B5E',
                    900: '#5B3A4A',  // cocoa (teks utama)
                },
                // Pendamping: lilac lembut
                accent: {
                    50: '#F8F1FE',
                    100: '#EBDDFB',  // lilac
                    200: '#DCC6F7',
                    500: '#C9A7F0',
                    600: '#B48BE6',  // hover lilac
                },
                peach: '#FFE6D6',
                mint: '#DDF3EA',
            },
        },
    },
    plugins: [forms],
};