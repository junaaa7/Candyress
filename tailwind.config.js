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
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#f0f3ff',
                    100: '#e0e7ff',
                    500: '#6366f1', // Indigo/Blue
                    600: '#4f46e5', // Hover Blue
                    900: '#0f172a', // Dark Navy/Charcoal
                },
                accent: {
                    500: '#a855f7', // Purple
                    600: '#9333ea', // Hover Purple
                }
            }
        },
    },
    plugins: [forms],
};