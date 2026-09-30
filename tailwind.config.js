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
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                display: ['Fredoka', 'Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // 50 blush, 100 petal, 300 rose, 600 berry, 900 cocoa
                brand: {
                    50: '#FFF5F8',
                    100: '#FFE1EA',
                    200: '#FFC8D9',
                    300: '#FF9EBB',
                    400: '#F77FA6',
                    500: '#E86FA0',
                    600: '#D6477F',
                    700: '#B83468',
                    800: '#8E3B5E',
                    900: '#5B3A4A',
                },
                accent: {
                    50: '#F8F1FE',
                    100: '#EBDDFB',
                    200: '#DCC6F7',
                    500: '#C9A7F0',
                    600: '#B48BE6',
                },
                peach: '#FFE6D6',
                mint: '#DDF3EA',
                butter: '#FFD98A',
                mauve: '#9C7A8A',
            },
            borderRadius: {
                '4xl': '1.75rem',
            },
            // Bayangan "stiker": offset solid tanpa blur
            boxShadow: {
                'sticker-xs': '0 2px 0 #FFE1EA',
                'sticker-sm': '0 4px 0 #FFE1EA',
                'sticker': '0 6px 0 #FFE1EA',
                'sticker-lg': '0 10px 0 #FFE1EA',
                'pop': '0 5px 0 #D6477F',
                'pop-sm': '0 3px 0 #D6477F',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-12px)' },
                },
            },
            animation: {
                float: 'float 5s ease-in-out infinite',
            },
        },
    },
    plugins: [forms],
};